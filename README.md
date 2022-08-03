# Laravel Blog System

This web application was built by laravel and it is a complete project that contains a panel for users , admin and many features, such as:

- Roles(user&editor&admin), Permissions
- Real time notification (pusher & laravel-websockets)
- All CURD operations
- Contact-us & create any other page
- Admin dashboard statistics & settings

## Tech Stack
**Client:** html, css, bootstrap, redis, livewire, vue.js

**Server:** laravel

## How to install
1- pull this project from github :-
```bash
  git clone https://github.com/mohamed1maghraby-div/laravel-blog.git
```
2- install composer :-
```bash
  composer install
```
3- install npm :-
```bash
  npm install && npm run dev
```

4- edit .env file with your credentials.

5- migrate data :-
```bash
  php artisan migrate --seed
```

6- setup redis.

7- to make notification work :-
```bash
  php artisan websockets:serve
```
```bash
  php artisan queue:work
```
<p align="center">Thanks for your interest.</p>