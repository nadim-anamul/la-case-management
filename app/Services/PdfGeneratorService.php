<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

class PdfGeneratorService
{
    /**
     * Generate PDF from HTML content
     */
    public static function generateFromHtml(string $html, array $options = []): string
    {
        $browsershot = Browsershot::html($html)
            ->noSandbox()
            ->timeout($options['timeout'] ?? 120)
            ->format($options['format'] ?? 'A4');

        // Set Chrome path if available
        if (self::getChromePath()) {
            $browsershot->setChromePath(self::getChromePath());
        }

        // Add margins if specified
        if (isset($options['margins'])) {
            $margins = $options['margins'];
            $browsershot->margins($margins[0], $margins[1], $margins[2], $margins[3]);
        }

        // Additional options
        if ($options['showBackground'] ?? true) {
            $browsershot->showBackground();
        }

        if ($options['waitUntilNetworkIdle'] ?? true) {
            $browsershot->waitUntilNetworkIdle();
        }

        return $browsershot->pdf();
    }

    /**
     * Generate PDF from URL
     */
    public static function generateFromUrl(string $url, array $options = []): string
    {
        $browsershot = Browsershot::url($url)
            ->noSandbox()
            ->timeout($options['timeout'] ?? 60)
            ->format($options['format'] ?? 'A4');

        // Set Chrome path if available
        if (self::getChromePath()) {
            $browsershot->setChromePath(self::getChromePath());
        }

        return $browsershot->pdf();
    }

    /**
     * Get Chrome executable path
     */
    private static function getChromePath(): ?string
    {
        $paths = [
            '/usr/bin/google-chrome',
            '/usr/bin/google-chrome-stable',
            '/usr/bin/chromium-browser',
            '/usr/bin/chromium',
            env('CHROME_PATH'),
            env('PUPPETEER_EXECUTABLE_PATH')
        ];

        foreach ($paths as $path) {
            if ($path && file_exists($path)) {
                return $path;
            }
        }

        Log::warning('Chrome executable not found in common paths');
        return null;
    }

    /**
     * Test PDF generation
     */
    public static function test(): array
    {
        try {
            $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <title>PDF Test</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; color: #333; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>PDF Generation Test</h1>
                    <p>Generated at: ' . now() . '</p>
                    <p>Chrome path: ' . (self::getChromePath() ?: 'Not found') . '</p>
                </div>
            </body>
            </html>';

            $pdf = self::generateFromHtml($html, ['timeout' => 30]);

            return [
                'success' => true,
                'message' => 'PDF generated successfully',
                'chrome_path' => self::getChromePath(),
                'pdf_size' => strlen($pdf)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'chrome_path' => self::getChromePath(),
                'error_trace' => $e->getTraceAsString()
            ];
        }
    }
}
