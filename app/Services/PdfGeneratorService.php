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
            ->format($options['format'] ?? 'A4')
            ->addChromiumArguments([
                '--font-render-hinting=none',
                '--disable-font-subpixel-positioning',
                '--disable-gpu-sandbox',
                '--disable-software-rasterizer',
                '--disable-background-timer-throttling',
                '--disable-renderer-backgrounding',
                '--disable-backgrounding-occluded-windows',
                '--disable-features=TranslateUI,VizDisplayCompositor'
            ]);

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
        // First try Puppeteer's default Chrome
        $puppeteerChrome = '/root/.cache/puppeteer/chrome/linux-138.0.7204.94/chrome-linux64/chrome';
        if (file_exists($puppeteerChrome)) {
            return $puppeteerChrome;
        }

        // Fallback to system Chrome paths
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
            <html lang="bn">
            <head>
                <meta charset="UTF-8">
                <title>PDF Test</title>
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    body { 
                        font-family: "Noto Sans Bengali", "Lohit Bengali", "DejaVu Sans", "Liberation Sans", Arial, sans-serif; 
                        margin: 20px; 
                    }
                    .header { text-align: center; color: #333; }
                    .bengali { font-size: 18px; line-height: 1.6; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>PDF Generation Test</h1>
                    <h2 class="bengali">পিডিএফ জেনারেশন টেস্ট</h2>
                    <p>Generated at: ' . now() . '</p>
                    <p class="bengali">তৈরি করা হয়েছে: ' . now()->format('Y-m-d H:i:s') . '</p>
                    <p>Chrome path: ' . (self::getChromePath() ?: 'Not found') . '</p>
                    <div class="bengali">
                        <h3>বাংলা ফন্ট টেস্ট:</h3>
                        <p>এটি একটি বাংলা ফন্ট পরীক্ষা। যদি আপনি এই টেক্সট সঠিকভাবে দেখতে পান, তাহলে বাংলা ফন্ট কাজ করছে।</p>
                        <p>সংখ্যা: ১২ৃ৪৫৬৭৮৯০</p>
                        <p>বিশেষ চিহ্ন: ৳ ০ ১ ২ ৩ ৪ ৫ ৬ ৭ ৮ ৯</p>
                    </div>
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
