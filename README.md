
Student Name: SUDHIR ASLALIYA
Student Number: 8966602
Date: 13/08/2024

Technology Stack
Frontend: HTML, CSS, JAVASCRIPT
Backend: PHP with MySQL
Database: MySQL

Project Setup
Project Initialization: Repository created on GitHub and cloned to local machine.
Frontend Setup: Initialized HTML, CSS, Javascript project.
Backend Setup: Initialized PHP project with sql and connected to phpMyAdmin(XAMPP).


Database Schema Design :
categories Table: 
id (int)
name (text)

products table: 
id (int)
name (varchar)
description (text)
price (decimal)
category_id (int)
created_at (datetime)
updated_at (datetime)

customers table:
id (int)
first_name (varchar)
last_name (varchar)
email (varchar)
phone (varchar)
address (text)
created_at (datetime)

orders table: 
id (int)
customer_id (int)
order_date (datetime)
total_amount (decimal)
status (varchar)
created_at (datetime)

order_items table:
id (int)
order_id (int)
product_id (int)
quantity (int)
price (decimal)
created_at (datetime)


Frontend Setup
Basic structure set up for HTML , CSS and JavaScript.
State management planned to handle user sessions and cart data.

Notes : 
The project is set up using Git and GitHub for version control.
Further development will include implementing user interfaces for Categories, Item, product, order, and orderitems.



Here, i inserted link of video - https://stuconestogacon-my.sharepoint.com/:v:/g/personal/saslaliya6602_conestogac_on_ca/EdFRj7HSlC5An6mOXCp7Q_MBhnXgYS4KyeaGQy9ITFqXCA?nav=eyJyZWZlcnJhbEluZm8iOnsicmVmZXJyYWxBcHAiOiJTdHJlYW1XZWJBcHAiLCJyZWZlcnJhbFZpZXciOiJTaGFyZURpYWxvZy1MaW5rIiwicmVmZXJyYWxBcHBQbGF0Zm9ybSI6IldlYiIsInJlZmVycmFsTW9kZSI6InZpZXcifX0%3D&e=MzNT1Z
