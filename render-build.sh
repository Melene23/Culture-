#!/bin/bash
set -e

echo "🚀 Build final avec sessions database..."

# NETTOYAGE
echo "🧹 Nettoyage..."
rm -f bootstrap/cache/*.php

# DÉPENDANCES
composer install --no-dev --optimize-autoloader --no-interaction
npm ci --production
npm run build

# CONFIGURATION
php artisan key:generate --force

# MIGRATIONS SESSIONS (CRITIQUE)
echo "🗃️  Préparation sessions..."
if [ ! -f "database/migrations/*create_sessions_table.php" ]; then
    php artisan session:table
fi

echo "🗄️  Migration..."
php artisan migrate --force

# CACHE
php artisan config:cache
php artisan route:cache
php artisan view:cache

# VÉRIFICATION
echo "🔍 Vérification PostgreSQL et sessions..."
php artisan tinker --execute="
try {
    echo '📊 Database: ' . \DB::connection()->getDatabaseName() . PHP_EOL;
    echo '🔌 Driver: ' . \DB::connection()->getDriverName() . PHP_EOL;
    echo '📋 Sessions table: ' . (\Schema::hasTable('sessions') ? '✅ OUI' : '❌ NON') . PHP_EOL;
} catch(\Exception \$e) {
    echo '❌ Erreur: ' . \$e->getMessage() . PHP_EOL;
}
" 2>/dev/null || true

php artisan storage:link
echo "🎉 Terminé !"
