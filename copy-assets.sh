#!/bin/bash

echo "📦 Copying Locally Built Assets"
echo "==============================="

# Check if assets are built locally
if [ ! -d "public/build" ]; then
    echo "❌ No local assets found. Building assets first..."
    npm run build
fi

if [ ! -d "public/build" ]; then
    echo "❌ Asset build failed locally"
    exit 1
fi

echo "✅ Local assets found"
echo "📋 Local build directory contents:"
ls -la public/build/

echo ""
echo "💡 To copy these assets to your server:"
echo "   1. Upload the public/build/ directory to your server"
echo "   2. Place it in the same location on the server"
echo "   3. Restart the Docker container"
echo ""
echo "🔧 Or run the redeploy script: ./redeploy-with-seeder.sh" 