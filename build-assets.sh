#!/bin/bash

echo "🚀 Building Assets for Development"
echo "=================================="

# Check if node_modules exists
if [ ! -d "node_modules" ]; then
    echo "📦 Installing dependencies..."
    npm install
fi

# Build assets
echo "🔨 Building CSS and JS assets..."
npm run build

# Check if build was successful
if [ $? -eq 0 ]; then
    echo "✅ Assets built successfully!"
    echo "📁 Built files:"
    ls -la public/build/assets/
else
    echo "❌ Asset build failed!"
    exit 1
fi

echo ""
echo "💡 To start development server:"
echo "   npm run dev"
echo ""
echo "💡 To serve the application:"
echo "   php artisan serve"
echo ""
echo "🌐 Access the application at: http://localhost:8000" 