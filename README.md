# PHP Cafeteria Management System

A simple PHP-based cafeteria management system that helps manage users, rooms, products, categories, and orders.  
The project is structured as a core PHP web application and uses MySQL as the database.

---

## Team Members
- **Ramadan Mohamed**
- **Karim Kadry**
- **Ahmed Ibrahim Elemam**
- **Mawadah Hassan**
- **Amr Shokry**

---

## Team Contributions

### Ramadan Mohamed
_Write your contribution here._

Example:
- Responsible for the ______ module.
- Built the ______ page / feature.
- Worked on ______.
- Helped with testing and bug fixing.

### Karim Kadry
- Developed the Order Request module that allows users to select products and place orders.
- Implemented cart functionality using PHP sessions to manage selected products and quantities.
- Built the backend logic for creating orders and storing order items in the database.
- Added product search and availability filtering.
- Implemented role-based ordering, allowing admins to create orders for different users.
- Handled order validation and error handling before submitting orders.
- Built the main navigation bar (Navbar) for the application.
- Worked on OrderController and order-related views.
- Assisted with testing the ordering workflow and fixing issues.

### Ahmed Ibrahim Elemam — User Module
I was responsible for the **User Management** part of the project.
- Building the **All Users** page to display users in a table.
- Building the **Add User** page.
- Building the **Edit User** page.
- Displaying user information such as:
  - name
  - email
  - room
  - extension
  - image
- Handling core user operations:
  - create user
  - update user
  - delete user
  - show user details
- Working on user image handling, including displaying a default image when no image exists.
- Adding validation for user input.
- Improving the UI of the user pages using Bootstrap.
- Testing and fixing user-related issues.

### Mawadah Hassan -Managed all orders-related operations.

Implemented role-based access for users and admins.

Allowed users to view and cancel their own orders.

Allowed admins to view and manage all orders, including updating statuses.

Supported filtering orders by status and date range.

Loaded order items with product details.

Associated orders with rooms and users.

Enforced authentication and ownership checks for security.

Rendered orders views based on user role for a clear order management interfac.

### Amr Shokry -Product Management
- Full CRUD operations (Create, Read, Update, Delete) for products
- Image upload support for product images
Category Management
- Full CRUD operations for categories
Pagination
- Implemented pagination for both products and categories to efficiently handle large datasets
Authorization
- Admin-only access control to manage products and categories
- Protected routes ensuring that only authorized administrators can perform management operations

---

## Project Overview
This project is a web-based cafeteria management system where:
- Admin can manage users, products, categories, and orders.
- Users can log in and interact with the system.
- Orders are linked to users and rooms.
- Products are organized by categories.

---

## Tech Stack
- **PHP**
- **MySQL**
- **HTML / CSS**
- **Bootstrap**
- **Apache**

---

## Project Structure
```bash
project-php-iti/
│
├── App/
├── config/
├── public/
├── schema.sql
├── seeder.sql
├── README.md
└── ...
```

---

## Requirements
Before running the project, make sure you have:
- PHP installed
- MySQL installed
- Apache server running (XAMPP / Laragon / WAMP)
- A browser

---

## Database Setup
### Step 1: Create / Import the database schema
Import **`seeder.sql`** first.

This file creates:
- database structure
- tables
- primary keys
- indexes
- auto increment values
- foreign key constraints
- Seeds data to database



### Database Configuration
The database configuration used in the project is:
- **Host:** `localhost`
- **Port:** `3306`
- **Database Name:** `iti_php_project`
- **Username:** `root`
- **Password:** `` (empty by default)

If needed, update the database settings from the configuration file.

---

## Test Credentials
The seeded accounts are ready for testing.

### Admin Account
- **Email:** `admin@cafeteria.com`
- **Password:** `123456`
- **Role:** `admin`

### User Accounts
- **Email:** `ahmed@cafeteria.com`
- **Password:** `123456`
- **Role** `user`

- **Email:** `sara@cafeteria.com`
- **Password:** `123456`
- **Role** `user`




## How to Run the Project
1. Clone the repository:
   ```bash
   git clone https://github.com/ramadan123462y/project-php-iti.git
   ```

2. Move to the project folder.

3. Put the project inside your local server directory if needed:
   - `htdocs` for XAMPP
   - `www` for WAMP
   - or the appropriate folder for Laragon

4. Import the database files in this order:
   - `seeder.sql`

5. Make sure Apache and MySQL are running.

6. Open the project from the **public** folder.

Example:
```text
http://localhost/project-php-iti/public/
```

---

## Important Notes
- The project entry point is inside the **`public/`** folder.
- Make sure Apache rewrite is working if the project depends on routing rules.
- Import **`schema.sql` first**, then **`seeder.sql`**.
- If the database name or credentials are different on your machine, update the configuration file before running the project.

---

## For the TA / Instructor
To run the project successfully:
1. Import `seeder.sql`
2. Start Apache and MySQL
3. Open the project from `/public`
4 . Test using any of the provided accounts

---

## Repository
GitHub Repository:  
`https://github.com/ramadan123462y/project-php-iti`
