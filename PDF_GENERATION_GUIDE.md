# PDF Generation System Guide

## Overview

This Laravel application includes a comprehensive PDF generation system using **Browsershot** with **Puppeteer** and **Google Chrome** for high-quality PDF output.

## 🏗️ Architecture

### Core Components

1. **Browsershot** - PHP library for generating PDFs from HTML
2. **Puppeteer** - Node.js library for controlling Chrome/Chromium
3. **Google Chrome** - Full browser for PDF rendering
4. **Node.js 18.x** - Runtime for Puppeteer

### Key Features

- ✅ **High-quality PDF generation** with proper formatting
- ✅ **Bengali text support** with proper font rendering
- ✅ **A4 page format** with customizable margins
- ✅ **Background rendering** for better visual output
- ✅ **Error handling** with graceful fallbacks
- ✅ **Timeout management** (120 seconds for complex documents)
- ✅ **Memory optimization** (256M limit for PDF generation)

## 🐳 Docker Setup

### Dockerfile.simple Enhancements

```dockerfile
# Install Node.js 18.x (LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Google Chrome
RUN wget -q -O - https://dl.google.com/linux/linux_signing_key.pub | apt-key add - \
    && echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list \
    && apt-get update \
    && apt-get install -y google-chrome-stable

# Install Puppeteer globally
RUN npm install -g puppeteer
```

### System Dependencies

The following Chrome dependencies are installed:
- `fonts-liberation` - Font support
- `libasound2` - Audio support
- `libatk-bridge2.0-0` - Accessibility toolkit
- `libcups2` - Printing support
- `libdbus-1-3` - D-Bus support
- `libgtk-3-0` - GTK+ toolkit
- `libnspr4` - Mozilla runtime
- `libnss3` - Network Security Services

## 📄 PDF Generation Implementation

### 1. Notice PDF Generation

**File:** `app/Http/Controllers/CompensationController.php`
**Method:** `generateNoticePdf($id)`

```php
public function generateNoticePdf($id)
{
    // Increase execution time limit for PDF generation
    set_time_limit(120); // 2 minutes
    ini_set('memory_limit', '256M'); // Increase memory limit
    
    $compensation = Compensation::findOrFail($id);
    
    try {
        // Generate PDF directly from HTML content for better performance
        $html = view('pdf.notice_pdf', compact('compensation'))->render();
        
        $pdf = Browsershot::html($html)
            ->noSandbox()
            ->timeout(120) // Increased timeout to 120 seconds
            ->format('A4')
            ->margins(10, 10, 10, 10) // Add margins
            ->showBackground() // Show background for better rendering
            ->waitUntilNetworkIdle() // Wait for network to be idle
            ->pdf();
            
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Notice PDF generation error: ' . $e->getMessage());
        
        // Fallback: Return HTML view instead of PDF
        return view('compensation.notice_preview', compact('compensation'))
            ->with('error', 'PDF তৈরি করতে সমস্যা হয়েছে। HTML ভার্সন দেখানো হচ্ছে।');
    }

    return response($pdf, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="notice_'.$compensation->id.'.pdf"',
    ]);
}
```

### 2. Order Sheet PDF Generation

**File:** `app/Http/Controllers/OrderSheetController.php`
**Method:** `generatePdf($id)`

```php
public function generatePdf($id)
{
    $order = OrderSheet::findOrFail($id);
    
    // Get the full URL to the preview page
    $url = route('order.preview', $order->id);
    
    // Replace 127.0.0.1 with localhost for better compatibility
    $url = str_replace('127.0.0.1', 'localhost', $url);

    try {
        // Use Browsershot to convert the URL to a PDF
        $pdf = Browsershot::url($url)
            ->noSandbox() // Added to fix Puppeteer sandbox error
            ->timeout(60) // Increased timeout to 60 seconds
            ->format('A4')
            ->pdf();
    } catch (\Exception $e) {
        // Fallback: Generate PDF from HTML content directly
        $html = view('pdf.pdf_preview', compact('order'))->render();
        
        $pdf = Browsershot::html($html)
            ->noSandbox()
            ->timeout(60)
            ->format('A4')
            ->pdf();
    }

    return response($pdf, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="order_sheet_'.$order->id.'.pdf"',
    ]);
}
```

## 🧪 Testing

### Test Route

A test route is available at `/test-pdf` to verify PDF generation:

```php
Route::get('/test-pdf', function () {
    try {
        $html = '<!DOCTYPE html><html><head><title>PDF Test</title></head><body><h1>PDF Generation Test</h1><p>Generated at: ' . now() . '</p></body></html>';
        
        $pdf = \Spatie\Browsershot\Browsershot::html($html)
            ->noSandbox()
            ->timeout(60)
            ->format('A4')
            ->pdf();
            
        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="test.pdf"',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'PDF generation failed',
            'message' => $e->getMessage()
        ], 500);
    }
})->name('test.pdf');
```

### Automated Testing

The deployment script includes automated PDF testing:

```bash
# Test PDF generation
test_pdf_generation() {
    print_status "🧪 Testing PDF generation..."
    
    # Check if test route is available
    if curl -s -o /dev/null -w "%{http_code}" http://localhost:8000/test-pdf | grep -q "200"; then
        print_success "✅ PDF generation test passed"
        
        # Verify PDF content
        local pdf_content=$(curl -s http://localhost:8000/test-pdf | head -c 100)
        if [[ "$pdf_content" == "%PDF"* ]]; then
            print_success "✅ PDF content verified - valid PDF generated"
        fi
    else
        print_warning "⚠️ PDF generation test failed"
    fi
}
```

## 🔧 Configuration

### Browsershot Options

Common Browsershot options used in this application:

```php
Browsershot::html($html)
    ->noSandbox()           // Disable Chrome sandbox for Docker
    ->timeout(120)          // 2-minute timeout
    ->format('A4')          // A4 page format
    ->margins(10, 10, 10, 10) // 10mm margins
    ->showBackground()      // Show background colors/images
    ->waitUntilNetworkIdle() // Wait for network to be idle
    ->pdf()
```

### Environment Variables

No specific environment variables are required for PDF generation, but the following are recommended:

```env
# Optional: Customize Chrome path if needed
CHROME_PATH=/usr/bin/google-chrome

# Optional: Customize Puppeteer settings
PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
```

## 🚀 Deployment

### Production Deployment

The production deployment script includes PDF setup:

```bash
# Setup PDF generation
setup_pdf_generation() {
    print_status "📄 Setting up PDF generation..."
    
    # Check Node.js
    if docker compose -f docker-compose.server.yml exec -T app node --version; then
        print_success "✅ Node.js is installed"
    fi
    
    # Check Puppeteer
    if docker compose -f docker-compose.server.yml exec -T app npm list -g puppeteer; then
        print_success "✅ Puppeteer is installed"
    fi
    
    # Check Chrome
    if docker compose -f docker-compose.server.yml exec -T app which google-chrome; then
        print_success "✅ Chrome is installed"
    fi
}
```

### Verification Commands

```bash
# Check if PDF generation is working
curl -o test.pdf http://localhost:8000/test-pdf

# Check Chrome installation
docker compose -f docker-compose.server.yml exec -T app google-chrome --version

# Check Puppeteer installation
docker compose -f docker-compose.server.yml exec -T app npm list -g puppeteer

# Check Node.js installation
docker compose -f docker-compose.server.yml exec -T app node --version
```

## 🐛 Troubleshooting

### Common Issues

1. **Chrome not found**
   ```bash
   # Install Chrome dependencies
   apt-get install -y google-chrome-stable
   ```

2. **Puppeteer timeout**
   ```php
   // Increase timeout
   ->timeout(120)
   ```

3. **Memory issues**
   ```php
   // Increase memory limit
   ini_set('memory_limit', '256M');
   ```

4. **Sandbox errors**
   ```php
   // Disable sandbox
   ->noSandbox()
   ```

### Logs

Check application logs for PDF generation errors:

```bash
# View recent logs
docker compose -f docker-compose.server.yml logs --tail=50 app | grep -i "pdf\|browsershot\|chrome"

# Check Laravel logs
docker compose -f docker-compose.server.yml exec -T app tail -f storage/logs/laravel.log
```

## 📊 Performance

### Optimization Tips

1. **Use HTML content directly** instead of URLs when possible
2. **Increase timeout** for complex documents
3. **Add margins** for better formatting
4. **Show background** for better visual output
5. **Wait for network idle** for dynamic content

### Resource Usage

- **Memory:** 256M limit for PDF generation
- **Timeout:** 120 seconds for complex documents
- **CPU:** Moderate usage during PDF generation
- **Storage:** Temporary files cleaned up automatically

## 🔄 Updates and Maintenance

### Regular Maintenance

1. **Update Chrome** - Keep Chrome updated for security
2. **Update Puppeteer** - Keep Puppeteer updated for features
3. **Monitor logs** - Check for PDF generation errors
4. **Test regularly** - Use test route to verify functionality

### Version Compatibility

- **Laravel:** 12.x
- **PHP:** 8.2+
- **Node.js:** 18.x (LTS)
- **Puppeteer:** 24.x
- **Chrome:** Latest stable

## 📝 Examples

### Basic PDF Generation

```php
use Spatie\Browsershot\Browsershot;

$html = view('pdf.template', $data)->render();

$pdf = Browsershot::html($html)
    ->noSandbox()
    ->timeout(60)
    ->format('A4')
    ->pdf();

return response($pdf, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; filename="document.pdf"',
]);
```

### Advanced PDF Generation

```php
$pdf = Browsershot::html($html)
    ->noSandbox()
    ->timeout(120)
    ->format('A4')
    ->margins(15, 15, 15, 15)
    ->showBackground()
    ->waitUntilNetworkIdle()
    ->landscape() // For landscape orientation
    ->pdf();
```

This PDF generation system provides a robust, scalable solution for generating high-quality PDFs with Bengali text support and proper formatting.
