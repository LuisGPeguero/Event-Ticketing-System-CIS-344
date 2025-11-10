# Event Ticketing System (CIS 344)

This is a simple event ticketing system built with PHP, MySQL, and vanilla JavaScript for CIS 344. It allows users to register, log in, browse events, and book tickets.

## Part 1: Local Setup Instructions

To run this application on your local machine, you will need a local server environment like XAMPP.

**Install XAMPP:**

Download and install XAMPP from the [official website](https://www.apachefriends.org/).

**Run XAMPP Control Panel:**

Open the XAMPP Control Panel.

Start the Apache module.

Start the MySQL module.

**Place Project Files:**

Navigate to your XAMPP installation directory (e.g., ```C:/xampp/```).

Find the htdocs folder (e.g., ```C:/xampp/htdocs/```). This is the web server's root directory.

Place the entire project folder (e.g., Event-Ticketing-System-CIS-344) inside htdocs.

**Create the Database:**

In the XAMPP Control Panel, click the "Admin" button for the MySQL module. This will open phpMyAdmin in your browser.

Click on the "Databases" tab.

In the "Create database" field, enter event_system_db and click "Create".

Click on the new event_system_db database from the left-hand menu.

Click on the "SQL" tab.

Open the database.sql file from the project folder, copy its entire content, and paste it into the SQL query box in phpMyAdmin.

Click the "Go" button to execute the script. This will create all the tables (users, events, bookings) and insert the sample data.

Note: The default database credentials in api/db_connect.php are set to root with no password, which is the XAMPP default.

## Part 2: Application Usage

Open the Application:

Open your web browser and navigate to the project's URL on your local server.

This will typically be: http://localhost/Event-Ticketing-System-CIS-344/login.html

Register an Account:

On the "Sign In" form, click the "Register" link at the bottom.

Fill in your desired Username, Email, and Password.

Click the "Register" button. You will be returned to the Sign In form.

Sign In:

Enter the Username and Password you just registered.

Click the "Sign In" button.

Browse Events:

You will now see the "Events" home page.

Scroll through the list of available events, which are displayed as cards.

Purchase Tickets:

Click on any event card you are interested in.

A "Buy Tickets" panel will appear.

Enter the desired quantity (e.g., "2").

Click the "Buy Tickets" button. You will receive an alert confirming your booking.

View Your Bookings:

On the main "Events" page, click the "My Bookings" button.

A "My Bookings" panel will appear, listing all the events you have successfully booked, the quantity, and the event date.

Click "Close" to hide the panel.

Sign Out:

To log out, click the "Sign Out" button at the top right of the page. You will be returned to the "Sign In" screen.
