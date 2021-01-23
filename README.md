# Laravel CRUD Api

Simple CRUD using Laravel Resource API with Laravel 8.x

## Install with Composer

```
    $ composer install
```

## Create Sqlite Database

```
    see .env.example DB settings
```

## Set Environment

```
    $ cp .env.example .env
```

## Set the application key

```
   $ php artisan key:generate
```

## Run migrations and seeds

```
   $ php artisan migrate --seed
```

## To execute

```
   $ php artisan serve
```

```
    Create - POST - {localhost}/api/posts?title={newTitle}&description={newDescription}
    Read - GET (all)- {localhost}api/posts
    GET (byID) - {localhost}/api/posts/{id}
    Update - PUT - {localhost}/api/posts/{id}?title={updatedTitle}&description={updatedTitle}
    Delete - DELETE - {localhost}/api/posts/{id}
```
