# 🚀 Guide de Déploiement sur Render

Ce guide vous accompagne étape par étape pour déployer votre application Laravel "Culture Bénin" sur Render avec PostgreSQL.

## 📋 Prérequis

- Un compte Render (gratuit disponible sur [render.com](https://render.com))
- Votre dépôt Git (GitHub, GitLab, ou Bitbucket) connecté à Render
- Composer et PHP installés localement (pour tester)

---

## 🔧 Étape 1 : Préparer le dépôt Git

### 1.1 Vérifier les fichiers créés

Assurez-vous que les fichiers suivants sont présents dans votre dépôt :
- ✅ `render.yaml` - Configuration Render
- ✅ `render-build.sh` - Script de build
- ✅ `.env.example` - Exemple de configuration

### 1.2 Commiter et pousser les changements

```bash
git add .
git commit -m "Préparation pour déploiement Render avec PostgreSQL"
git push origin main
```

---

## 🌐 Étape 2 : Créer un compte Render

1. Allez sur [https://render.com](https://render.com)
2. Cliquez sur **"Get Started for Free"**
3. Inscrivez-vous avec GitHub, GitLab, ou votre email
4. Vérifiez votre email si nécessaire

---

## 🗄️ Étape 3 : Créer la base de données PostgreSQL

### 3.1 Créer une nouvelle base de données

1. Dans le dashboard Render, cliquez sur **"New +"**
2. Sélectionnez **"PostgreSQL"**
3. Configurez la base de données :
   - **Name** : `culture-benin-db`
   - **Database** : `culture_benin`
   - **User** : `culture_user`
   - **Region** : `Frankfurt` (ou la région la plus proche)
   - **Plan** : `Starter` (gratuit pour commencer)
4. Cliquez sur **"Create Database"**

### 3.2 Noter les informations de connexion

Une fois créée, Render vous donnera :
- **Internal Database URL** : `postgresql://culture_user:password@host:5432/culture_benin`
- **Host** : `dpg-xxxxx-a.frankfurt-postgres.render.com`
- **Port** : `5432`
- **Database** : `culture_benin`
- **User** : `culture_user`
- **Password** : (généré automatiquement)

⚠️ **Important** : Notez ces informations, vous en aurez besoin !

---

## 🚀 Étape 4 : Déployer l'application Web

### Option A : Déploiement automatique avec render.yaml (Recommandé)

1. Dans le dashboard Render, cliquez sur **"New +"**
2. Sélectionnez **"Blueprint"**
3. Connectez votre dépôt Git :
   - Si c'est la première fois, autorisez Render à accéder à votre dépôt
   - Sélectionnez le dépôt `Culture-`
   - Sélectionnez la branche `main`
4. Render détectera automatiquement le fichier `render.yaml`
5. Cliquez sur **"Apply"**

Render créera automatiquement :
- ✅ Le service web
- ✅ La base de données PostgreSQL
- ✅ Les variables d'environnement

### Option B : Déploiement manuel

Si vous préférez configurer manuellement :

1. Cliquez sur **"New +"** → **"Web Service"**
2. Connectez votre dépôt Git
3. Configurez le service :
   - **Name** : `culture-benin`
   - **Environment** : `PHP`
   - **Region** : `Frankfurt`
   - **Branch** : `main`
   - **Root Directory** : (laissez vide)
   - **Build Command** : `./render-build.sh`
   - **Start Command** : `php artisan serve --host=0.0.0.0 --port=$PORT`
   - **Plan** : `Starter` (gratuit)

4. **Variables d'environnement** :
   ```
   APP_ENV=production
   APP_DEBUG=false
   LOG_CHANNEL=stderr
   LOG_LEVEL=error
   DB_CONNECTION=pgsql
   DB_HOST=<HOST_DE_LA_BD>
   DB_PORT=5432
   DB_DATABASE=<NOM_DE_LA_BD>
   DB_USERNAME=<USER_DE_LA_BD>
   DB_PASSWORD=<PASSWORD_DE_LA_BD>
   APP_KEY=<GÉNÉRÉ_AUTOMATIQUEMENT>
   CACHE_DRIVER=file
   SESSION_DRIVER=file
   QUEUE_CONNECTION=sync
   ```

5. **Lier la base de données** :
   - Dans la section "Environment", cliquez sur "Add Database"
   - Sélectionnez votre base de données PostgreSQL créée à l'étape 3
   - Render ajoutera automatiquement les variables `DB_*`

6. Cliquez sur **"Create Web Service"**

---

## ⚙️ Étape 5 : Configurer les variables d'environnement

### 5.1 Variables automatiques (si vous avez lié la BD)

Si vous avez lié la base de données dans Render, ces variables sont automatiques :
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

### 5.2 Variables à ajouter manuellement

Dans les **Environment Variables** de votre service web, ajoutez :

```
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stderr
LOG_LEVEL=error
DB_CONNECTION=pgsql
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

### 5.3 Générer APP_KEY

1. Dans le shell de Render (ou localement) :
   ```bash
   php artisan key:generate --show
   ```
2. Copiez la clé générée
3. Ajoutez-la comme variable d'environnement :
   ```
   APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
   ```

**OU** Laissez Render la générer automatiquement (si vous utilisez `render.yaml` avec `generateValue: true`)

---

## 🔨 Étape 6 : Premier déploiement

### 6.1 Lancer le build

1. Render commencera automatiquement le build après la création
2. Surveillez les logs dans l'onglet **"Logs"**
3. Le build peut prendre 5-10 minutes la première fois

### 6.2 Vérifier les erreurs

Si vous voyez des erreurs dans les logs :

**Erreur : "APP_KEY not set"**
- Solution : Ajoutez la variable `APP_KEY` (voir étape 5.3)

**Erreur : "Database connection failed"**
- Solution : Vérifiez que la base de données est liée et que les variables `DB_*` sont correctes

**Erreur : "Migration failed"**
- Solution : Vérifiez les logs détaillés, il peut y avoir un problème de syntaxe SQL

---

## 🗄️ Étape 7 : Exécuter les migrations

### 7.1 Via le shell Render (Recommandé)

1. Dans votre service web, allez dans l'onglet **"Shell"**
2. Exécutez :
   ```bash
   php artisan migrate --force
   ```

### 7.2 Via les logs de build

Si vous avez inclus `php artisan migrate --force` dans `render-build.sh`, les migrations s'exécutent automatiquement lors du build.

### 7.3 Exécuter les seeders (optionnel)

Si vous voulez peupler la base de données avec des données initiales :

```bash
php artisan db:seed --force
```

---

## ✅ Étape 8 : Vérifier le déploiement

### 8.1 Tester l'application

1. Une fois le déploiement terminé, Render vous donnera une URL : `https://culture-benin.onrender.com`
2. Ouvrez cette URL dans votre navigateur
3. Vérifiez que :
   - ✅ La page d'accueil s'affiche
   - ✅ Les statistiques sont dynamiques (pas de valeurs hardcodées)
   - ✅ La connexion à la base de données fonctionne

### 8.2 Tester les fonctionnalités

- Créer un compte utilisateur
- Se connecter
- Créer un contenu
- Vérifier le dashboard admin (si vous avez un compte admin)

---

## 🔧 Étape 9 : Configuration avancée (Optionnel)

### 9.1 Domaine personnalisé

1. Dans les paramètres de votre service web
2. Allez dans **"Custom Domains"**
3. Ajoutez votre domaine
4. Suivez les instructions DNS

### 9.2 Variables d'environnement supplémentaires

Si vous utilisez des services externes (FedaPay, etc.), ajoutez leurs clés :

```
FEDAPAY_API_KEY=your_key_here
FEDAPAY_API_SECRET=your_secret_here
```

### 9.3 Stockage des fichiers

⚠️ **Important** : Sur Render, le système de fichiers est **éphémère**. Les fichiers uploadés seront perdus lors des redéploiements.

**Solutions** :
1. Utiliser un service de stockage cloud (AWS S3, Cloudinary, etc.)
2. Configurer le stockage dans `config/filesystems.php`

---

## 🐛 Résolution des problèmes courants

### Problème : "500 Internal Server Error"

**Solutions** :
1. Vérifiez les logs dans Render
2. Vérifiez que `APP_DEBUG=false` en production
3. Vérifiez que toutes les migrations ont été exécutées
4. Vérifiez les permissions des fichiers

### Problème : "Database connection timeout"

**Solutions** :
1. Vérifiez que la base de données est dans la même région que le service web
2. Vérifiez les variables d'environnement `DB_*`
3. Vérifiez que la base de données est active (pas en pause)

### Problème : "Migration error: syntax error"

**Solutions** :
1. Vérifiez que vous utilisez PostgreSQL (pas MySQL)
2. Vérifiez que les migrations sont compatibles PostgreSQL
3. Testez les migrations localement avec PostgreSQL

### Problème : "Assets not loading (CSS/JS)"

**Solutions** :
1. Vérifiez que `npm run build` s'exécute correctement
2. Vérifiez que les assets sont dans `public/build`
3. Vérifiez la configuration Vite dans `vite.config.js`

---

## 📊 Étape 10 : Monitoring et maintenance

### 10.1 Surveiller les logs

- Allez dans l'onglet **"Logs"** de votre service
- Surveillez les erreurs et les warnings

### 10.2 Mises à jour

Pour mettre à jour l'application :

1. Faites vos modifications localement
2. Commitez et poussez vers Git :
   ```bash
   git add .
   git commit -m "Mise à jour..."
   git push origin main
   ```
3. Render redéploiera automatiquement

### 10.3 Sauvegardes de la base de données

Render fait des sauvegardes automatiques pour les bases de données payantes. Pour le plan gratuit, pensez à exporter régulièrement :

```bash
pg_dump -h <HOST> -U <USER> -d <DATABASE> > backup.sql
```

---

## 🎉 Félicitations !

Votre application est maintenant déployée sur Render ! 

**Résumé des URLs importantes** :
- 🌐 Application : `https://culture-benin.onrender.com`
- 📊 Dashboard Render : `https://dashboard.render.com`
- 🗄️ Base de données : Accessible via le dashboard Render

---

## 📞 Support

Si vous rencontrez des problèmes :
1. Consultez les [docs Render](https://render.com/docs)
2. Vérifiez les logs de votre application
3. Contactez le support Render si nécessaire

---

## 🔐 Sécurité

⚠️ **Important** : 
- Ne commitez JAMAIS le fichier `.env` dans Git
- Utilisez toujours `APP_DEBUG=false` en production
- Gardez vos clés API secrètes dans les variables d'environnement Render
- Activez HTTPS (automatique sur Render)

---

**Bon déploiement ! 🚀**

