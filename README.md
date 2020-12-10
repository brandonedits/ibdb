# Book Review
> CMS built on the TraversyMVC PHP framework.

## Supported Features

- Registration / Login capabilit
- CRUD capability for books and book reviews
- Search books by title, author, genre, or ISBN
- Moderator accounts to approve book additions
- 1-5 star rating on books.
- Like or dislike book reviews

## Login Credentials

- email: admin@gmail.com
- password: 123

## Deployment Instructions

URLROOT needs to be defined to to correctly display the front end.

[1] Add database book_review in XAMPP or your preferred program

[2] import book_review.sql to new db

[3] Open app/config/config.php in notepad

[4] Edit line 13 to point to project directory ('http://localhost/project').

[3] Start web application