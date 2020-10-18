## Library project

The project was created with a Vagrant laravel/homestead box alongside the next tools:

- **Laravel Framework 8.10.0**
- **PHP 7.4.11**
- **MySQL 5.7.31**

This said, a database named **library** is required, also make sure to do the proper modification on your **.env** file to match the connection data.

Now you need to run a Composer migration with:

`php artisan migrate`

and check if the tables were created on your database, if so, then run:

`php artisan db:seed`

to populate the **users table** with some data, if you get an error, just rerun the command.

At this point, the project should be ready to run.