# Software Project Management System

A database-driven web application that allows users to manage software projects. The system supports user authentication and enables users to create, update, and manage their own projects, while public users can browse and search all available projects.

---

## Features

### Public Users
- View all projects
- Search projects by title or start date
- View full project details

### Registered Users
- Register a new account
- Log in and log out
- Access a personal dashboard
- Add new projects
- Edit existing projects
- Delete projects

---

## Security Features

- Password hashing using `password_hash()`
- Secure login verification using `password_verify()`
- Session-based authentication
- Authorisation checks (users can only modify their own projects)
- SQL injection protection using PDO prepared statements
- Output escaping using `htmlspecialchars()` (XSS prevention)
- Server-side input validation

---

## Technologies Used

- PHP (server-side logic)
- MySQL (database)
- PDO (secure database interaction)
- HTML5 / CSS3 (frontend)
- JavaScript (basic interactivity)
- XAMPP (local development environment)

---

## Project Structure

```

project-manager/
│
├── config/        # Database configuration
├── includes/      # Reusable components (auth, header, footer, functions)
├── public/        # Main application pages
├── sql/           # Database SQL file

```

---

## Setup Instructions (Local)

1. Install XAMPP
2. Place the project folder inside:
```

htdocs/

```
3. Start Apache and MySQL from XAMPP
4. Open phpMyAdmin
5. Create a new database (e.g. `project_db`)
6. Import the SQL file from the `sql/` folder
7. Open your browser and go to:
```

[http://localhost/project-manager/public/index.php](http://localhost/project-manager/public/index.php)

```

---

## Notes

- The system was developed as part of a university coursework project.
- It demonstrates core back-end development concepts including authentication, CRUD operations, and secure database interaction.
- No external frameworks were used to ensure full understanding of underlying technologies.

---

## Future Improvements

- Deploy application to a live server
- Improve UI/UX design
- Add image uploads for projects
- Implement REST API
- Add pagination for large datasets

