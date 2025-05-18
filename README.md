# CakePHP Application Skeleton

![Build Status](https://github.com/cakephp/app/actions/workflows/ci.yml/badge.svg?branch=5.x)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

A skeleton for creating applications with [CakePHP](https://cakephp.org) 5.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.



```markdown
# 📚 `/books` Endpoint – API Documentation

This endpoint returns book records with optional pagination, filtering, sorting, and eager-loaded tags. All examples assume the JSON format (`/books.json`) but work the same without the extension if the client sends `Accept: application/json`.

---

## Base URL

```

GET /books            # HTML/table view

GET /books.json       # JSON API view

```

---

## 1  Pagination

| Query Param | Type | Description                | Default |
|-------------|------|----------------------------|---------|
| `page`      | int  | Page number                | `1`     |
| `limit`     | int  | Items per page             | `10`    |

*Example*

```http
GET /books.json?page=2&limit=5

```

---

## 2 Filtering

### Category (case-insensitive, partial match)

| Query Param | Type | Description |
| --- | --- | --- |
| `category` | string | Returns books whose **category** contains the given string |

*Example*

```
GET /books.json?category=Fantasy

```

Matches “Fantasy”, “Epic Fantasy”, “Urban Fantasy”, etc.

---

## 3 Sorting

| Query Param | Type | Description |
| --- | --- | --- |
| `sort` | string | Column to sort by (`PubDate`, `title`, `category`) |
| `direction` | string | `asc` or `desc` |

*Example (newest first)*

```
GET /books.json?sort=PubDate&direction=desc

```

Multiple keys are supported:

```
GET /books.json?sort[]=PubDate&direction[]=asc&sort[]=title&direction[]=asc

```

---

## 4 Included Data

Each book record contains:

| Field | Notes |
| --- | --- |
| **Book properties** | e.g. `id`, `title`, `category`, `PubDate`, `image` |
| **`tags`** | Array of related tags (may be empty) |

The tags are eager-loaded with `contain(['Tags'])`, so one query gives you complete data.

---

## 5 Response Example

```
GET /books.json?category=Fantasy&sort=PubDate&direction=asc

```

```json
{
  "books": [
    {
      "id": 17,
      "title": "The Way of Kings",
      "category":  Fantasy",
      "PubDate": "2010-08-31",
      "image": "17001",
      "tags": [
        { "id": 3, "name": "High Fantasy" },
        { "id": 7, "name": "Series" }
      ]
    },
    ...
  ],
}


##  Source References

| Topic | CakePHP Cookbook Section |
| --- | --- |
| Pagination basics & query params | https://book.cakephp.org/4/en/controllers/components/pagination.html |
| Sorting with `sort`/`direction` | https://book.cakephp.org/4/en/controllers/components/pagination.html#sorting-data |
| Query Builder `where()` / `LIKE` | https://book.cakephp.org/4/en/orm/query-builder.html#where-conditions |
| Eager-loading with `contain()` | https://book.cakephp.org/4/en/orm/retrieving-data-and-resultsets.html#eager-loading-associations |
| JSON/automatic serialization | https://book.cakephp.org/4/en/views/json-and-xml-views.html#enabling-automatic-serialization |


## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit the environment specific `config/app_local.php` and set up the
`'Datasources'` and any other configuration relevant for your application.
Other environment agnostic settings can be changed in `config/app.php`.

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.
