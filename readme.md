VERSION 1.30

What is working:

- Login/Register Users
- Front Page with Pictures (shows based on non-existant number of likes)
- Temporary upload page
- Write a story

Need To Fix/To Be Done:

- As you can see the front page needs some design!!

- A lot of these are stub pages for people who are working on the frontend.

- Please make sure you understand routing, controllers, views, and models.

- Need more design and view creation from the frontend people. 

Important Info

Models manage data and such.... (Backend)

Views are what the viewer sees... (Frontend)

Controllers is what connects everything through inputs and outputs

Me and Matt worked our butts off debugging the authentication system and understanding how these three things work together.  There are some files in this repository that show you how some of this is accomplished. 


Models are in /app. 

User.php - Completed for auth() functions. auth() = just routing commands for the authentication function

AccountFrontPage.php - Me trying to pull info from the database with app/Repositories/AccountRepository.php. It is unfinished


Controller are in app/http/controller

auth/AuthController.php - Handles registeration and validation form

auth/FrontPageController.php - still playing around with this to output something from the database. Unfinished


Routes are in /app/http/routes.php

We choose what each domain does here with Controllers. 

Example:

  get('/', ~) - if user goes to www.dreamvents.com/ we show them the welcome page

   get(/frontpages', ~) if user is redirected to .com/frontpages controller will check if authenticated if so show frontpages.index
   

Views are in /DreamVent/resources/views

these are what the user sees

