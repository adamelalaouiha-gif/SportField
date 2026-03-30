# SportsField - Instructions de démarrage

## 1. Configuration .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pfe
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=database
```

## 2. Commandes à exécuter (dans le dossier du projet)

```bash
# Générer la clé
php artisan key:generate

# Créer les tables
php artisan migrate:fresh

# Créer le compte Super Admin
php artisan db:seed

# Créer le lien storage pour les images
php artisan storage:link

# Lancer le serveur
php artisan serve
```

## 3. Comptes par défaut

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Super Admin | admin@sportsfield.ma | password123 |

## 4. Structure des rôles

- **Visiteur** : Voir les clubs et terrains sans compte
- **Client** : S'inscrire, réserver des terrains, gérer ses réservations
- **Admin Club** : Gérer les terrains et réservations de son club
- **Super Admin** : Gérer tout le système (clubs, utilisateurs, demandes)

## 5. Flux d'utilisation

1. Un visiteur envoie une demande d'inscription de club
2. Le Super Admin approuve → le compte Admin est créé automatiquement
3. L'Admin se connecte et ajoute ses terrains
4. Les clients réservent les terrains en ligne

