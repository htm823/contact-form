# Contact Form

A contact management system built with PHP and MySQL.

Users can submit enquiries through the public contact form. Administrators can sign in using a demo account to view, search, and manage submitted enquiries locally.

## Preview

The application is not deployed.  
Please refer to the GIF below to see the application flow.

The preview demonstrates:

- Public contact form submission
- Administrator login
- Enquiry list management
- Enquiry details view
- Read/Unread status update
- Search, sorting, and pagination features

### Public Contact Form

### Administrator Login

## Features

### Public

- Submit enquiries through a contact form
- Form validation
- Responsive design

### Administration

- Secure administrator sign-in
- Session-based authentication
- Password hashing with `password_hash()`
- Password verification with `password_verify()`
- View a list of submitted enquiries
- View enquiry details
- Search enquiries by name, email address, or telephone number
- Sort enquiries by submission date
- Pagination
- Read/Unread status management

**Note:** The administration pages are not yet responsive.

## Tech Stack

- HTML
- PHP
- MySQL
- Bootstrap
- JavaScript
- jQuery
- [yubinbango.js](https://github.com/yubinbango/yubinbango)

## Security

- Passwords are securely stored using `password_hash()`.
- Authentication is performed using `password_verify()`.
- Prepared statements are used to prevent SQL injection.
- User input is escaped before output to mitigate XSS attacks.
- Administrative pages are protected by session-based authentication.

## Demo Account

User registration is intentionally unavailable, as this project is intended solely as a personal portfolio.

Use the following credentials to sign in to the administration pages:

**Email**

```text
test1234@gmail.com
```

**Password**

```text
test1234
```

To see the read/unread status in action, first submit a new enquiry using the public contact form. Then sign in to the administration pages and open the newly submitted enquiry. This makes it easier to observe how the read/unread status changes.

## Local Development

1. Clone this repository.
2. Import `database/mails.sql` and `database/users.sql` into MySQL.
3. Configure the database connection in `config/init.php`.
4. Start Apache and MySQL.
5. Access the application through your local development environment.

## Future Improvements

- Add user registration
- Introduce automated testing with PHPUnit
- Improve the database design through further normalisation
- Make the administration pages fully responsive

## Licence

This project is provided for portfolio and evaluation purposes only.

The source code may not be copied, modified, distributed, or used in other projects without prior written permission.