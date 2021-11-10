## Tokened.life demo

This demo is built with Laravel/VueJs

## Usage

Clone the repo. 


```
git clone https://github.com/shoreadmin13/tokened.git
```

Run the install: 
```
composer install
```

### Create MYSQL database, db_user and db_user_password.

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

```
php artisan db:seed
```

Generate key and symbolic links to storage/app/images and public/storage
```
php artisan key:generate
php artisan storage:link
```

### Nginx / Apache
Set web root to /public folder.


### Frontend

CSS is made with https://tailwindcss.com/
see config here: tailwind.config.js

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
