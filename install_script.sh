#! /bin/sh
sudo chmod -R 777 /public/Pictures
sudo chmod -R 777 bootstrap/cache
sudo chmod -R 777 storage 
sudo composer install
sudo composer update
mv env .env
cd public/
mv htaccess .htaccess
cd ..
php artisan key:generate