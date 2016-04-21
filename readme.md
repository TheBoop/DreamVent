This version has a temporary home page. 

Has a form page for register account

Creates user account with ID 10-19 for user 1. User 2 will have ID 20-29. etc

after submission of form, 

*still needs a value for "name" at the moment USER takes a static value of "Bob Ross" as a name.

Updates DreamVents schema table: USER and USER_LIST

Needs a login authenicatable page now to transfer user to his front page.

FatalThrowableError in SessionGuard.php line 418: could be source where this is done

Note: unsure if sqlserver is connected properly at the moment. Only tested on homestead local enviroment today

If server is connected properly then RegisterAccount is functional.

Requirements:

1. composer

2. laravel

3. mysql server

4. php 7~

5. apache2

Installation for EC2 Server:

1) git clone this repository to a folder make sure its chmod 777 so the server can write to it

  - you might have to add the server key to your github account. 
  
  - cat ~/.ssh/id_rsa.pub    - copy this to your github account. I am not entirely sure. But this is how I cloned the git to the server
  - git clone https://yourusername@github.com/TheBoop/DreamVent

2) change your apache config files /etc/apache2/sites-available/000-default.conf   change your document root to www/~~~/DreamVent/Root

  -depends on what command do the work. In this case apachectl

3) sudo apachectl restart

4) navigate to the Dreamvent folder            

5) sudo chmod -R 777 storage && sudo chmod -R 777 bootstrap/cache          permissions for stuff.

6) sudo composer install                to install dependencies

7) change env to .env and then cd to public/htaccess and rename htaccess to .htaccess

  -env is your enviroment variable
  
  -htaccess routes the web server to the controllers how neat
  
8) php artisan key:generate              to install key to .env file

9) check the site

Hopefully these steps work...

Note: I chmod -R 777 the entire DreamVent folder and gave everything permissions. This is the only step thats not here. Next installation hopefully I can test that and confirm it is not necessary. I was debugging....and testing whether permissions were the cause.


