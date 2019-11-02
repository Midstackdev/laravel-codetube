## About Codetube

This is a youtube like clone I built for fun with the laravel Framework and Vue.js.

## Features 

- Laravel 6.0.
- Vue.js 
- Bootstrap 4
- Font awesome 4
- video.js for the video player.
- Algolia driver for quick search.
- Amazon S3 for storage.
- Telestream cloud for video Encoding 



## Instalation

- Clone the repo
- Copy .env.example to .env
- Configure .env
- Run composer install
- Run php artisan key:generate
- Run php artisan migrate
- Run npm install

## Included
- Setup Amazon S3 and enter bucket links in codetude.php in config.
- Setup Telestream cloud and use notification webhook/encoding in routes.
- Setup ngrok for local http tunneling for webhooks from telestream cloud.
