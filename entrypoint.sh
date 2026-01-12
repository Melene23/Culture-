#!/bin/bash

# Attendre que la base de données soit disponible
echo "Attente de la base de données..."
while ! pg_isready -h $DB_HOST -p $DB_PORT -U $DB_USERNAME; do
  echo "Base de données non disponible, attente..."
  sleep 2
done

echo "Base de données disponible, exécution des migrations..."
php artisan migrate --force

echo "Exécution des autres commandes..."
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Démarrage d'Apache..."
apache2-foreground