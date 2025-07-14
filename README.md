# PDF Generate Laravel Project

This project is a Laravel-based application for generating and previewing order sheet PDFs using Browsershot (Puppeteer/Chromium).

---

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Setup Instructions](#setup-instructions)
  - [Windows](#windows-setup)
  - [Ubuntu](#ubuntu-setup)
- [Usage](#usage)
- [PDF Generation](#pdf-generation)
- [Troubleshooting](#troubleshooting)
- [Project Structure](#project-structure)
- [License](#license)

---

## Features
- Create, edit, and list order sheets
- Preview order sheets in a styled HTML view
- Generate downloadable PDFs using Browsershot (Puppeteer/Chromium)
- Bengali font support for PDF output

---

## Requirements
- PHP >= 8.1
- Composer
- Node.js (v18+ recommended)
- npm
- Google Chrome or Chromium (Browsershot uses Puppeteer)

---

## Setup Instructions

### Windows Setup

1. **Install PHP**
   - Download from [php.net](https://windows.php.net/download/)
   - Add PHP to your system PATH

2. **Install Composer**
   - Download and run the installer from [getcomposer.org](https://getcomposer.org/download/)

3. **Install Node.js and npm**
   - Download and install from [nodejs.org](https://nodejs.org/)

4. **Install Google Chrome**
   - Download and install from [google.com/chrome](https://www.google.com/chrome/)

5. **Clone the repository**
   ```sh
   git clone <your-repo-url>
   cd pdf-generate
   ```

6. **Install PHP dependencies**
   ```sh
   composer install
   ```

7. **Install Node.js dependencies**
   ```sh
   npm install
   ```

8. **Copy and configure environment file**
   ```sh
   copy .env.example .env
   # Edit .env as needed (set DB connection, etc.)
   ```

9. **Generate application key**
   ```sh
   php artisan key:generate
   ```

10. **Run migrations**
    ```sh
    php artisan migrate
    ```

11. **Start the Laravel development server**
    ```sh
    php artisan serve
    ```

12. **Access the app**
    - Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser

---

### Ubuntu Setup

1. **Update and install dependencies**
   ```sh
   sudo apt update
   sudo apt install -y php php-cli php-mbstring php-xml php-zip php-curl unzip curl git
   sudo apt install -y composer
   sudo apt install -y nodejs npm
   sudo apt install -y chromium-browser
   ```

2. **Clone the repository**
   ```sh
   git clone <your-repo-url>
   cd pdf-generate
   ```

3. **Install PHP dependencies**
   ```sh
   composer install
   ```

4. **Install Node.js dependencies**
   ```sh
   npm install
   ```

5. **Copy and configure environment file**
   ```sh
   cp .env.example .env
   # Edit .env as needed (set DB connection, etc.)
   ```

6. **Generate application key**
   ```sh
   php artisan key:generate
   ```

7. **Run migrations**
   ```sh
   php artisan migrate
   ```

8. **Start the Laravel development server**
   ```sh
   php artisan serve
   ```

9. **Access the app**
   - Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser

---

## PDF Generation
- The app uses [spatie/browsershot](https://github.com/spatie/browsershot) (Puppeteer/Chromium) to generate PDFs from HTML views.
- If you encounter sandbox errors on Ubuntu, the project is already configured to use the `--no-sandbox` flag.
- If you encounter timeouts, the controller will fallback to generating the PDF from HTML content directly.

---

## Usage
- **Create Order Sheet:** Use the form to create a new order sheet.
- **Preview:** Click the "Preview Page" link to see the styled HTML preview.
- **Download PDF:** Click the "Download PDF" link to generate and download the PDF.

---

## Troubleshooting
- **Browsershot/Puppeteer errors:**
  - Ensure Node.js and npm are installed and in your PATH.
  - Ensure Chromium/Chrome is installed and accessible.
  - On Ubuntu, if you see sandbox errors, the app uses `--no-sandbox` by default.
  - If you see timeouts, check that your Laravel server is running and accessible.
- **Permission issues:**
  - On Linux, you may need to run `sudo chown -R $USER:$USER storage bootstrap/cache` to fix permissions.
- **Database errors:**
  - Ensure your `.env` file is configured with the correct database credentials.

---

## Project Structure

- `app/Http/Controllers/OrderSheetController.php` — Main controller for order sheet logic and PDF generation
- `app/Models/OrderSheet.php` — Eloquent model for order sheets
- `resources/views/pdf/pdf_preview.blade.php` — Blade view for PDF/preview
- `routes/web.php` — Web routes
- `database/migrations/` — Database schema

---

## License
MIT
