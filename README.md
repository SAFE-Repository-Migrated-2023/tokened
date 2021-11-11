## https://tokened.thesafebutton.com/ demo

This demo is built with Laravel/VueJs

## Usage

Clone the repo. 


```
git clone https://github.com/leoshore/tokened
```

Run the install: 
```
composer install
```

### Create MYSQL database, db_user and db_user_password.

Note composer post-root-package-install command will copy '.env.example' to '.env' only if .env file does not exist already.
Copy/rename '.env.example' to '.env' and configure database connection and other settings

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USER
DB_PASSWORD=YOUR_DB_USER_PASSWORD
```

### Run the migrations and seed the database

```
php artisan migrate:fresh --seed
```
You can run standalone seeder to create 3 new contacts with faker:
Note that seeder only creates contacts, user can manage but not site users.

```
php artisan db:seed
```

Generate key and symbolic links to storage/app/images and public/storage
```
php artisan key:generate
php artisan storage:link
```

Update your .env and set your Safe application configuration.

Development:

```
APP_ENV=local
APP_DEBUG=true

SAFE_CLIENT_ID=name_of_your_app
SAFE_CLIENT_SECRET=your_app_secret_key
SAFE_CLIENT_SAFE_ID=client_id_app_owner

#Production
#URI_OAUTH="https://oauth.thesafe.io/oauth2"
#URI_API="https://api.thesafe.io"

#Development
URI_OAUTH="https://oauth.dev.thesafe.io"
URI_API="https://api.dev.thesafe.io"
```

Production:

```
APP_ENV=production
APP_DEBUG=false

SAFE_CLIENT_ID=name_of_your_app
SAFE_CLIENT_SECRET=your_app_secret_key
SAFE_CLIENT_SAFE_ID=client_id_app_owner

#Production
URI_OAUTH="https://oauth.thesafe.io/oauth2"
URI_API="https://api.thesafe.io"

#Development
#URI_OAUTH="https://oauth.dev.thesafe.io"
#URI_API="https://api.dev.thesafe.io"
```

### Nginx / Apache
Set web root to /public folder.


### Frontend

CSS is made with https://tailwindcss.com/
see config here: tailwind.config.js

Both css and js files were compiled and are part of this repo. 
Use commands below if you need to make changes.

Install npm:
```
npm install
```

Development:

```
npm run watch
```

Production will treeshake unused css and will place uglified assets to public folders.

```
npm run prod
```
