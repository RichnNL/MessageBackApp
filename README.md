# Can run the backend locally 
To run locally need a MySql database and the server needs the following Environment variables
DB_CONNECTION=Examplemysql
DB_DATABASE=ExampleDatabase
DB_HOST=Example127.0.0.1
DB_USERNAME=Exampleroot
DB_PASSWORD=ExamplePassword
APP_KEY=exampleMadeUpKey
PRODUCTION=false

# Or can go the deployed version on Heroku there are two endpoints 
https://messageapp-1122.herokuapp.com/
# endpoints are login endpoint api.login.php
# and message endpoint api/messages.php 

deplyed endpoints are 
https://messageapp-1122.herokuapp.com/api/login.php
https://messageapp-1122.herokuapp.com/api/messages.php

# because it is on heroku if the server has not been used for a while it will be slow to start up

GitHub is located at 
https://github.com/RichnNL/MessageBackApp

# Walkthrough

In order to see the messages first must acquire a JWT token
To get a token is simple go to the use POST METHOD api/login.php/?username=<YourUserName> GET method will not work, and only username will work

# example https://messageapp-1122.herokuapp.com/api/login.php/?username=Bob

no password is needed if it is a new user a new user will be created stored and a token will be generated and returned to you

use that token in the Header as so: Authorization: Bearer <token>

to get your messages go to api/messages.php use GET and include the token in the header the backend will know your identity and retrieve your message if you have any.

to send a message go to the same endpoint api/messages.php but include 
recipient=<Name>
content=<YourMessage>

# example POST https://messageapp-1122.herokuapp.com/api/messages.php/?recipient=Hans&content=Hello
# example GET https://messageapp-1122.herokuapp.com/api/messages.php/
 as parameters and the token again in the headers, if successful will retrieve a success JSON object

# Structure
The application is divided into 
api - where the routes for the api is
Controller - which manage the logic concerning the logic
database - is a singelton object that is used multiple times throughout the app for models singelton               so that mutliple connections are not made
entities - are the pain data objects returned to the api routes
lib - contains only one library for JWT,
Models - interact directly with the database
util- has functions used through the app




