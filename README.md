# epl343.winter23.team5

## Manual installation

Our web app uses MariaDB (MySQL) and PHP, we also wanted to be able to host the app locally.
For this we used the application XAMPP [https://www.apachefriends.org/]. This app hosts locally
an apache Web server, a PHP server and a MariaDB server. This was used on GNU/Linux (debian)
and Windows 11. In order to launch the web app, store the files of said app in the directory
htdocs ("/opt/lampp/htdocs/" and "C:\XAMPP\htdocs" for Linux and Windows respectively). You
need to also launch the XAMPP control panel (app) and start the Apache and MariaDB server.
Then, enter the URL/domain [localhost/your_folder_name_here/] in your browser.

## Load the database

Using the SQL scripts given ("tutoring.sql") go to the URL [localhost/phpmyadmin] and then import
said script onto the database.

Everything should be working.

## Basic website functionalities

You can then enter in any account found in the SQL script. Each account has a password="0", for
testing purposes. The use of the website remains the same as described in the deliverables. Each
type of user (admin, teacher, student) has their own personal page with the features they're given.
If you want to create an account simply register; you need a key for a teacher and you need to be
approved by the admin if you're a student.

Detailed description of how the web app works is outside the scope of this manual.
