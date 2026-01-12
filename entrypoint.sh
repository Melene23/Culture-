#!/bin/bash

# Démarrer Apache en arrière-plan immédiatement
echo "Démarrage d'Apache en arrière-plan..."
apache2-foreground &

# Attendre que la base de données soit disponible (avec timeout)
echo "Attente de la base de données (timeout 30s)..."
timeout=30
elapsed=0
while [ $elapsed -lt $timeout ]; do
  if pg_isready -h $DB_HOST -p $DB_PORT -U $DB_USERNAME -d $DB_DATABASE; then
    echo "Base de données disponible, exécution des migrations..."
    php artisan migrate --force
    echo "Migrations terminées."
    break
  else
    echo "Base de données non disponible, attente... ($elapsed/$timeout)"
    sleep 2
    elapsed=$((elapsed + 2))
  fi
done

if [ $elapsed -ge $timeout ]; then
  echo "Timeout atteint, démarrage sans migrations. Les migrations devront être exécutées manuellement."
fi

echo "Configuration Laravel..."
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Service prêt."

# Garder le conteneur en cours d'exécution
wait