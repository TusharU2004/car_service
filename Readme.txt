Car Rental System - Setup Instructions
Welcome to the Car Rental System, a web-based platform for managing car rental operations.
Follow these steps to set up and run the project on your local or web server.

System Requirements:-

Ensure your system meets the following requirements:

Web Server: XAMPP, WAMP, or any server with PHP support.
PHP: Version 7.4 or later.
MySQL: For database management.
Browser: A modern browser like Google Chrome or Firefox.


Step-by-Step Setup

1. Download and Extract
Download the zip file containing the project.
Extract it to your local system.

2. Set Up the Database
Open your database management tool (e.g., phpMyAdmin).
Create a new database named car_rental.
Import the car_rental.sql file into this database.

3. Configure the Database Connection
Open the config.php file located in the root directory of the project.
Update the following details with your database credentials:
php Copy code
$host = 'localhost';  
$db_name = 'car_rental';  
$username = 'root';  
$password = '';  

4. Set Up the Environment
Place the project folder in the root directory of your web server:
For XAMPP, move the folder to htdocs.
For WAMP, move the folder to www.
Start your web server and database server.

5. Access the Application
Open your browser and navigate to:
http://localhost/CarRentalSystem/
Admin and User Credentials
Admin
Username: admin
Password: Test@12345

User
New users can register using the registration page.

Features Included

User Module
Car Booking:
	Search and filter cars by availability.
	Book cars for hourly or daily rentals.
	Dynamic payment calculation based on booking duration.
Payment Integration:
	Secure online payment gateway.
	Generate and download booking receipts.
Email Notifications:
	Receive booking status updates via email.
	Booking History:
	View past and current bookings.

Admin Module

Car Listing Management:
	Review and approve/reject car listing requests from car owners.
	Bulk approve/reject functionality with email notifications.
Booking Management:
	Monitor bookings and manage payment records.
Earnings Report:
	View graphical earnings reports filtered by date or car models.
User Management:
	Manage registered users.

Troubleshooting

Database Connection Issues: Check the credentials in config.php.
Missing Tables or Data: Ensure the car_rental.sql file is properly imported.
Email Not Working: Verify SMTP settings in the email configuration.
Graph Issues: Ensure Chart.js is included and properly configured.
