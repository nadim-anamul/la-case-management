#!/bin/bash

echo "🚀 Starting Laravel PDF Generator"
echo "================================"

# Check if containers are running
if docker compose ps | grep -q "laravel-app"; then
    echo "✅ Application is already running"
    echo "🌐 Access at: http://localhost:8000"
    echo "📊 View compensation data: http://localhost:8000/compensations"
    exit 0
fi

# Start containers
echo "🐳 Starting containers..."
docker compose up -d

# Wait for application to be ready
echo "⏳ Waiting for application to be ready..."
sleep 10

# Verify data is available
echo "📊 Verifying data availability..."
record_count=$(docker compose exec app php artisan tinker --execute="echo App\Models\Compensation::count();" 2>/dev/null | tail -1)
if [ "$record_count" -ge 4 ]; then
    echo "✅ Demo data is available ($record_count records)"
else
    echo "⚠️  Demo data may not be loaded. Run 'docker-setup.sh' for fresh setup."
fi

echo ""
echo "✅ Application started successfully!"
echo "🌐 Access at: http://localhost:8000"
echo "📊 View compensation data: http://localhost:8000/compensations"
echo ""
echo "📋 Demo data includes:"
echo "   • 4 comprehensive compensation records"
echo "   • SA and RS-based cases with full details"
echo "   • Multiple applicants and ownership information"
echo ""
echo "🔧 Useful commands:"
echo "   View logs: docker compose logs -f"
echo "   Stop: docker compose down"
echo "   Restart: docker compose restart"
echo "   Fresh setup: ./docker-setup.sh"
echo "" 