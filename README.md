Simple market system
======

Product designed for small shops. Made on codeigniter

Remains: Need to create a connection with the cash register.

After importing the database.
You have one user with data: username: admin and password: 12345 (Apply to both cases.)
This is demo working version: http://market.targovishte.com/ and http://market.targovishte.com/store/

You manage this your products from here, if yours address for project is http://localhost/ and store is this http://localhost/store/
Your cashier is here: http://localhost/

How to install this system
======
1. Download code on your computer.
2. Import your database from "/db" folder at project.
3. Open config file from: application/config/database.php
4. Change this settings with your:

    $db['default']['hostname'] = 'localhost'; 
    
    $db['default']['username'] = 'root'; // Put your username for database.
    
    $db['default']['password'] = 'new password here'; // Put yuor password for database.
    
    $db['default']['database'] = 'market'; // This is database table name.
