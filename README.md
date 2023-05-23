# Project Documentation

Welcome to the project documentation! This document provides an overview of the project's folder structure, functions, and other important details.

## Folder Structure

The project follows the following folder structure:

1. `actions/`
   - This directory contains PHP files that handle specific actions or requests, such as form submissions or API endpoints.

2. `assets/`
   - The assets directory stores static files like images, stylesheets, JavaScript files, and other resources used in the project.

3. `functions/`
   - The functions directory contains reusable PHP functions or classes that provide common functionality or utilities used throughout the project. Below is a list of available functions:

   - `loggedin()`: Checks if a user is logged in. Returns `true` if logged in, `false` otherwise.
   - `usertype()`: Retrieves the user type from the session. Returns the user type if available, `false` otherwise.
   - `is_super_admin()`: Checks if the user is a super admin. Returns `true` if the user is a super admin, `false` otherwise.
   - `username()`: Retrieves the username from the session. Returns the username if available, `false` otherwise.
   - `superadmin_only()`: Redirects to the index page if the user is not a super admin.
   - `loggedin_only()`: Redirects to the index page if the user is not logged in.
   - `success($message)`: Displays a success message styled with Bootstrap.
   - `fail($message)`: Displays an error message styled with Bootstrap.

4. `gradeforms/`
   - The gradeforms directory contains forms or templates related to grading or evaluation processes.

5. `includes/`
   - This directory holds PHP files that are included or required by other scripts. It typically includes files like headers, footers, or other shared components.

6. `index.php`
   - The main entry point of the project. It may serve as the homepage or the starting point of the application.
