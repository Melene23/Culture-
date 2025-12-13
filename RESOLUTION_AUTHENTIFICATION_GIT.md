# 🔐 Résolution du Problème d'Authentification Git

## Problème identifié

Lors du push, deux problèmes peuvent survenir :
1. **403 Forbidden** : Problème de permissions/authentification
2. **Timeout de connexion** : Problème réseau avec GitHub

## ✅ Solutions

### Solution 1 : Utiliser un Personal Access Token (Recommandé)

GitHub a supprimé le support du mot de passe pour HTTPS. Vous devez utiliser un **Personal Access Token**.

#### Étape 1 : Créer un token GitHub

1. Allez sur GitHub : https://github.com/settings/tokens
2. Cliquez sur **"Generate new token (classic)"**
3. Donnez un nom : `Culture-Git-Push`
4. Sélectionnez les permissions :
   - ✅ `repo` (accès complet aux dépôts)
5. Cliquez sur **"Generate token"**
6. **⚠️ IMPORTANT** : Copiez le token immédiatement (ex: `ghp_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`)
   - Vous ne pourrez plus le voir après !

#### Étape 2 : Utiliser le token

Quand Git vous demande le mot de passe, utilisez le **token** au lieu de votre mot de passe.

**Via la ligne de commande :**
```bash
git push origin main
# Username: Melene23 (ou votre nom d'utilisateur GitHub)
# Password: ghp_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx (le token)
```

**Ou configurez-le directement dans l'URL :**
```bash
git remote set-url origin https://ghp_VOTRE_TOKEN@github.com/Melene23/Culture-.git
git push origin main
```

### Solution 2 : Utiliser SSH (Alternative)

Si vous préférez utiliser SSH :

#### Étape 1 : Générer une clé SSH

```bash
ssh-keygen -t ed25519 -C "natajohn41@gmail.com"
# Appuyez sur Entrée pour accepter l'emplacement par défaut
# Entrez un mot de passe (optionnel mais recommandé)
```

#### Étape 2 : Ajouter la clé à GitHub

1. Affichez votre clé publique :
```bash
cat $env:USERPROFILE\.ssh\id_ed25519.pub
```

2. Copiez tout le contenu affiché

3. Allez sur GitHub : https://github.com/settings/keys
4. Cliquez sur **"New SSH key"**
5. Donnez un titre : `Culture-Git-Windows`
6. Collez la clé dans le champ "Key"
7. Cliquez sur **"Add SSH key"**

#### Étape 3 : Changer l'URL du dépôt

```bash
git remote set-url origin git@github.com:Melene23/Culture-.git
git push origin main
```

### Solution 3 : Vérifier le compte GitHub

Assurez-vous que vous êtes connecté avec le bon compte GitHub :
- Le dépôt appartient à : `Melene23`
- Votre compte actuel semble être : `natajohn41-arch`

**Si vous n'êtes pas le propriétaire du dépôt :**
- Vous devez être collaborateur du dépôt
- Ou utiliser le compte `Melene23` pour pousser

### Solution 4 : Résoudre les problèmes de connexion réseau

Si vous avez des timeouts de connexion :

#### Vérifier le proxy

Si vous êtes derrière un proxy :
```bash
git config --global http.proxy http://proxy.example.com:8080
git config --global https.proxy https://proxy.example.com:8080
```

#### Désactiver le proxy (si pas nécessaire)
```bash
git config --global --unset http.proxy
git config --global --unset https.proxy
```

#### Vérifier la connectivité
```bash
ping github.com
```

## 🚀 Commandes rapides

### Push avec token (méthode la plus simple)

1. Créez un token (voir Solution 1)
2. Exécutez :
```bash
git push origin main
```
3. Quand demandé :
   - **Username** : `Melene23`
   - **Password** : `ghp_VOTRE_TOKEN_ICI`

### Push avec SSH

1. Configurez SSH (voir Solution 2)
2. Changez l'URL :
```bash
git remote set-url origin git@github.com:Melene23/Culture-.git
git push origin main
```

## ✅ Vérification

Après avoir configuré l'authentification, vérifiez :

```bash
git remote -v
git push origin main
```

Si tout fonctionne, vous devriez voir :
```
Enumerating objects: X, done.
Counting objects: 100% (X/X), done.
Writing objects: 100% (X/X), done.
To https://github.com/Melene23/Culture-.git
   xxxxx..xxxxx  main -> main
```

## 📝 État actuel

✅ **Tous vos fichiers sont déjà commités localement**
- 10 fichiers modifiés
- 625 insertions
- Commit ID: `d991762`

Il ne reste plus qu'à pousser vers GitHub une fois l'authentification résolue.

## 🔗 Liens utiles

- [Créer un token GitHub](https://github.com/settings/tokens)
- [Configurer SSH sur GitHub](https://docs.github.com/en/authentication/connecting-to-github-with-ssh)
- [Documentation Git Credential Helper](https://git-scm.com/docs/gitcredentials)

---

**Une fois l'authentification configurée, exécutez simplement :**
```bash
git push origin main
```


