#!/bin/bash

echo "📊 Laravel PDF Generator - Data Export"
echo "======================================"

# Check if Docker containers are running
if ! docker compose ps | grep -q "laravel-pdf-generator-db"; then
    echo "❌ Database container is not running. Please start Docker containers first:"
    echo "   docker compose up -d"
    exit 1
fi

# Create exports directory
mkdir -p exports

# Get current timestamp
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

echo "🗄️  Exporting database..."
docker compose exec -T db mysqldump -u your_mysql_user -p your_mysql_password laravel_pdf_generator > "exports/database_backup_${TIMESTAMP}.sql"

echo "📁 Exporting storage files..."
tar -czf "exports/storage_backup_${TIMESTAMP}.tar.gz" storage/

echo "📋 Creating data summary..."
docker compose exec app php artisan tinker --execute="
echo 'Database Summary:';
echo '================';
echo 'Compensations: ' . App\Models\Compensation::count();
echo 'Users: ' . App\Models\User::count();
echo '';
echo 'Sample Compensation Records:';
echo '==========================';
App\Models\Compensation::take(3)->get()->each(function(\$comp) {
    echo 'ID: ' . \$comp->id . ' | Case: ' . \$comp->case_number . ' | Date: ' . \$comp->case_date;
});
" > "exports/data_summary_${TIMESTAMP}.txt"

echo ""
echo "✅ Export completed successfully!"
echo ""
echo "📁 Exported files:"
echo "   Database: exports/database_backup_${TIMESTAMP}.sql"
echo "   Storage: exports/storage_backup_${TIMESTAMP}.tar.gz"
echo "   Summary: exports/data_summary_${TIMESTAMP}.txt"
echo ""
echo "📋 To import this data in another environment:"
echo "   1. Copy the SQL file to your new environment"
echo "   2. Import using: mysql -u username -p database_name < database_backup_${TIMESTAMP}.sql"
echo "   3. Extract storage files: tar -xzf storage_backup_${TIMESTAMP}.tar.gz"
echo "" 