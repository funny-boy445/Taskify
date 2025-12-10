# Todo - App

This is a simple yet functional To-Do application built with PHP and MySQL. It allows users to manage their tasks effectively by adding, completing, and deleting them. Additionally, the app sends email notifications whenever a new task is created, using PHPMailer.

---

## Features
- Add new tasks to your to-do list.
- Mark tasks as completed.
- Delete tasks from the list.
- View tasks separately: open tasks and completed tasks.
- Get an email notification each time a new task is added.

---

## Requirements
To run this application, you need the following:
- **PHP**: Version 7.4 or higher.
- **MySQL**: For the database.
- **Web server**: Such as XAMPP, WAMP, or MAMP.
- **Composer**: To manage dependencies (optional if already configured).

---

## Installation

### 1. Clone the Repository
Clone this project to your local machine using the following commands:

- SSH:
```bash
git clone git@github.com:hatim-ayyad/taskify-app.git
```
- HTTPS:
```bash
git clone https://github.com/hatim-ayyad/taskify-app.git
```

```bash
cd taskify-app
```

### 2. Install Dependencies
Use Composer to install required libraries:

```bash
composer install
```

### 3. Set Up the Database
1. **Run the database setup script**:
   Execute the following command to create the database and tables automatically:
   ```bash
   php setup_database.php
   ```
   This will:
   - Create a database named `taskify_db`.
   - Create a table named `taskify_db` with the necessary structure.
   - Create a users table to manage user accounts.
---

### 4. Configure the Database
1. Open the `db.php` file in the root directory.
2. Update the database credentials if necessary:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'taskify_db');
   ```

---

### 5. Configure PHPMailer
1. **Set your email credentials**:
   Open the `send_mailer.php` file and update the following:
   ```php
   $mail->Host       = 'smtp.gmail.com'; // Update to your SMTP server
   $mail->Username   = 'your-email@gmail.com'; // Your email address
   $mail->Password   = 'your-app-password';   // Gmail app password (not your regular password)
   ```
2. **Gmail users**:
   - Use a Gmail-specific app password if using a Gmail account. You can generate an app password in your Google account security settings: [Generate App Password](https://support.google.com/accounts/answer/185833?hl=en).
   - Enable "Less secure app access" in your Gmail account if necessary (not recommended for production environments).

---

### 6. Start the Application
1. Place the project in your web server's root directory (e.g., `htdocs` for XAMPP).
2. Start your web server.
3. Access the app in your browser:
   ```
   http://localhost/taskify-app/index.php
   ```

---

## Usage
1. **Add a Task**:
   - Enter a task name in the input box and click "Add Task."
   - An email notification will be sent to the specified address.

2. **Complete a Task**:
   - Click the "Complete" button next to the task.

3. **Delete a Task**:
   - Click the "Delete" button to remove a task.

---

## Troubleshooting
- **Database Connection Error**: If you see an error about the database connection, ensure you've run the `setup_database.php` script and updated the credentials in `db.php`.
- **Email Sending Error**: Check the following:
   - SMTP server settings in `send_mailer.php` are correct.
   - Email credentials are valid (use an app password for Gmail).
   - Port 587 is open on your server.
- **No Tasks Displayed**: Ensure the `tasks` table has been created correctly in your database.

---

## License
This project is open-source and available under the MIT License.
