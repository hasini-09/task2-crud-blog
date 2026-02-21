# Internship Project: Blog Application
**ApexPlanet Software Pvt Ltd**

## Description
This is a comprehensive Blog Application developed as part of my internship. It started with core CRUD functionality and user authentication (Task 2) and was later enhanced with advanced search, pagination, and a modern UI (Task 3).

## Technologies Used
* **PHP:** Used MySQLi and Prepared Statements for secure backend logic.
* **MySQL:** Used for database management and storage.
* **XAMPP:** Used as the local server environment.
* **HTML5 & CSS3:** Leveraged Flexbox and Gradients for a modern interface.

## Features

### Task 3 – Advanced Implementation
* **Dynamic Search:** Integrated a search bar to filter posts by title or content instantly.
* **Pagination:** Structured the dashboard to display 5 posts per page to improve performance.
* **Improved Security:** Refactored code using Prepared Statements to handle special characters (like apostrophes) and prevent SQL injection.
* **Modern UI:** Redesigned the interface with a purple-themed responsive layout and better user feedback.

### Task 2 – Core Functionality
* **User Authentication:** Registration with password validation and login with session management.
* **Full CRUD:** Capability to Create, Read, Update, and Delete blog posts.
* **Database Integration:** Connected the frontend to a MySQL database for persistent storage.
* **Secure Logout:** Functionality to clear sessions and protect user data.

## How to Run the Project
1. **Install XAMPP:** Download and install the XAMPP stack.
2. **Start Services:** Start Apache and MySQL services from the XAMPP Control Panel.
3. **Setup Database:** Open phpMyAdmin and create a database named `blog`.
4. **Create Tables:** Create the `users` and `posts` tables within the `blog` database.
5. **File Placement:** Place the project folder in `C:\xampp\htdocs\`.
6. **Access App:** Access the application via `http://localhost/your_folder_name/index.php`.
