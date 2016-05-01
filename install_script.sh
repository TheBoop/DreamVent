#! /bin/sh
sudo chmod -R 777 public/Pictures
sudo chmod -R 777 bootstrap/cache
sudo chmod -R 777 storage 
sudo composer install
sudo composer update
php artisan key:generate
