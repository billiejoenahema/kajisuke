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
  - [php](https://hub.docker.com/_/php):8.1-fpm-bullseye
  - [composer](https://hub.docker.com/_/composer):2.2

### web container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.20

### db container

- Base image
  - [mysql/mysql-server](https://hub.docker.com/r/mysql/mysql-server):8.0

## architecture

- Laravel 9
- Vue 3.2
- Vuex
- Vue-router
- Docker
- nginx 1.2
- MySQL 8.0

## authentication

Sanctum with Cookie.
