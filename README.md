```markdown
# 🎵 MusicBoxAPI

Une **API RESTful moderne** développée avec Laravel pour la gestion complète d'une bibliothèque musicale. Permet de gérer des artistes, albums et chansons avec une documentation interactive Swagger.

---

## ✨ Fonctionnalités

### 🎤 Gestion des artistes
- Consultation, création, modification et suppression d'artistes
- Filtres avancés et pagination
- Relations avec les albums et chansons

### 💿 Gestion des albums
- Gestion complète des albums musicaux
- Association automatique aux artistes
- Liste des chansons par album

### 🎵 Gestion des chansons
- CRUD complet pour les chansons
- Filtres par durée, genre, année
- Association aux albums et artistes

### 🔐 Sécurité
- Authentification par tokens Sanctum
- Protection de toutes les routes API
- Gestion sécurisée des sessions

### 📖 Documentation
- Documentation interactive Swagger/OpenAPI
- Génération automatique depuis les annotations
- Exemples de requêtes et réponses

---

## 🛠️ Stack Technique

- **Backend** : PHP 8.2+ avec Laravel 10
- **Base de données** : MySQL 8.0+ ou MariaDB 10.4+
- **Authentification** : Laravel Sanctum
- **Documentation** : L5-Swagger (OpenAPI 3.0)
- **Tests** : Postman, PHPUnit
- **Outils** : Composer, Node.js

---

## 🚀 Installation et Démarrage

### Prérequis
- PHP 8.2 ou supérieur
- Composer
- MySQL/MariaDB
- Node.js et npm

### 📥 Installation

1. **Cloner le repository**
```bash
git clone https://github.com/TON_USERNAME/MusicBoxAPI.git
cd MusicBoxAPI
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances frontend (si nécessaire)**
```bash
npm install && npm run dev
```

4. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurer la base de données**
Éditer le fichier `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=musicbox
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

6. **Exécuter les migrations**
```bash
php artisan migrate --seed
```

7. **Démarrer le serveur**
```bash
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

---

## 🔐 Authentification

L'API utilise Laravel Sanctum pour l'authentification par tokens.

### 📝 Inscription
```http
POST /api/register
Content-Type: application/json

{
  "name": "Utilisateur",
  "email": "user@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

### 🔑 Connexion
```http
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

### 🚪 Déconnexion
```http
POST /api/logout
Authorization: Bearer {token}
```

---

## 📚 API Endpoints

### 🎤 Artistes

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `GET` | `/api/artists` | Liste paginée des artistes |
| `POST` | `/api/artists` | Créer un nouvel artiste |
| `GET` | `/api/artists/{id}` | Détails d'un artiste |
| `PUT` | `/api/artists/{id}` | Modifier un artiste |
| `DELETE` | `/api/artists/{id}` | Supprimer un artiste |

### 💿 Albums

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `GET` | `/api/albums` | Liste paginée des albums |
| `POST` | `/api/albums` | Créer un nouvel album |
| `GET` | `/api/albums/{id}` | Détails d'un album |
| `PUT` | `/api/albums/{id}` | Modifier un album |
| `DELETE` | `/api/albums/{id}` | Supprimer un album |
| `GET` | `/api/albums/{id}/songs` | Chansons de l'album |

### 🎵 Chansons

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `GET` | `/api/songs` | Liste paginée des chansons |
| `POST` | `/api/songs` | Créer une nouvelle chanson |
| `GET` | `/api/songs/{id}` | Détails d'une chanson |
| `PUT` | `/api/songs/{id}` | Modifier une chanson |
| `DELETE` | `/api/songs/{id}` | Supprimer une chanson |

---

## 📖 Documentation API

### Documentation Interactive
Accédez à la documentation Swagger interactive :  
**http://localhost:8000/docs**

### Fichier OpenAPI
Le fichier JSON OpenAPI est disponible à :  
**http://localhost:8000/api/documentation**

---

## ⚡ Optimisations

- **Eager Loading** : Prévention des problèmes N+1
- **Filtres Dynamiques** : Filtrage par nom, genre, année, durée
- **Pagination** : Toutes les listes sont paginées
- **Validation** : Validation robuste des données
- **Relations** : Gestion optimisée des relations Eloquent

---

## 🧪 Tests

### Avec Postman
1. Importer la collection Postman fournie
2. Configurer l'environnement avec l'URL de base et le token
3. Exécuter les tests pour chaque endpoint

### Tests Unitaires
```bash
php artisan test
```

---

## 📁 Structure du Projet

```
MusicBoxAPI/
├── app/
│   ├── Models/
│   │   ├── Artist.php
│   │   ├── Album.php
│   │   └── Song.php
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
└── config/
```

---

## 🚨 Notes Importantes

- ⚠️ Ne jamais versionner le fichier `.env`
- 🔧 Adapter les configurations selon l'environnement
- 📊 Vérifier les connexions à la base de données
- 🔒 Régénérer les tokens après déploiement en production

---

## 👩‍💻 Auteur

**Basma Haimer**  
- GitHub : [TON_USERNAME]((https://github.com/basmahaimer))
- Projet : [MusicBoxAPI](https://github.com/basmahaimer/MusicBoxAPI)

---

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.
```


