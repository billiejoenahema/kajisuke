# KajiSuke

## Introduction

This application manages the schedule of housework chores that are not done every day.

## Container structures

```bash
├── app
├── web
└── db
```

### app container

- Base image
  - [php](https://hub.docker.com/_/php):8.2-fpm-buster
  - [composer](https://hub.docker.com/_/composer):2.2

### web container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.20

### db container

- Base image
  - [mysql/mysql-server](https://hub.docker.com/r/mysql/mysql-server):8.0

## architecture

- Laravel 11.16.0
- PHP 8.2.7
- Vue 3.2
- Vuex 4.0
- Vue-router 4.0
- Docker
- nginx 1.2
- MySQL 8.0

## authentication

Sanctum with Cookie.
