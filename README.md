# Laravel Commando

[![Build](https://api.travis-ci.org/vkovic/laravel-commando.svg?branch=master)](https://travis-ci.org/vkovic/laravel-commando)
[![Downloads](https://poser.pugx.org/vkovic/laravel-commando/downloads)](https://packagist.org/packages/vkovic/laravel-commando)
[![Stable](https://poser.pugx.org/vkovic/laravel-commando/v/stable)](https://packagist.org/packages/vkovic/laravel-commando)
[![License](https://poser.pugx.org/vkovic/laravel-commando/license)](https://packagist.org/packages/vkovic/laravel-commando)

### Collection of handy Laravel `artisan` commands that most projects needs

Handy `artisan` commands that may find place in most of the Laravel projects regardless of the project type.

How often you wanted to perform some basic tasks like create or drop database, dump database or load from `.sql` dump, or to see which fields (and field types) are present in your models? Continue reading and I promise to easy this, and many more tasks to you :beers:

---

## Compatibility

The package is compatible with Laravel versions `5.5`, `5.6`, `5.7` and `5.8`.

> Because some commands rely on raw console commands (like `db:dump` which uses `mysqldump`), currently only MySql database and Linux environments are supported. Package is designed to easily support multiple OS-es and database types, and it should be easy implementation, so if anyone is interested to help, please feel free to contribute.

## Installation

Install the package via composer:

```bash
composer require vkovic/laravel-commando
```

## Available commands

> Package is in early stage so there is limited number of commands. I'm planning to add more, so if you have some suggestion you can require feature via issues page (click on `Issues -> New issue -> Feature request`)

###### Model related

- [**model**:list](#model-list)
- [**model**:fields](#model-fields)

###### Database related

- [**db**:exist](#db-exist)
- [**db**:create](#db-create)
- [**db**:drop](#db-drop)
- [**db**:dump](#db-dump)
- [**db**:import-dump](#db-import-dump)
- [**db**:summon](#db-summon)

---

<a name="model-list"/>

## model:list

Show all models and some basic info.

*(model class, table name, table count, scope count, soft deleted count)*

```bash
php artisan model:list
```

#### Usage example

```bash
~$ php artisan model:list

+------------------------------------------+---------------------------+-------------+-------------+--------------+
| Model                                    | Table                     | Table count | Scope count | Soft deleted |
+------------------------------------------+---------------------------+-------------+-------------+--------------+
| App\Models\Admin\Admin                   | admins                    | 3           | 3           |              |
| App\Models\Admin\Attribute               | attributes                | 148         | 148         |              |
| App\Models\Admin\Brand                   | brands                    | 152         | 152         |              |
| App\Models\Admin\Category                | categories                | 70          | 70          |              |
|                                          |                           |             |             |              |
| App\Models\Admin\Newsletter              | newsletter                | 452         | 452         |              |
| App\Models\Admin\Product                 | products                  | 4485        | 4485        | 0            |
| App\Models\Admin\RedirectRule            | redirect_rules            | 2632        | 2632        |              |
| App\Models\Admin\Slide                   | slides                    | 2           | 2           |              |
| App\Models\Admin\User                    | users                     | 2644        | 2644        |              |
| App\Models\Admin\Warranty                | warranties                | 9           | 9           |              |
|                                          |                           |             |             |              |
| App\Models\Attribute                     | attributes                | 148         | 148         |              |
| App\Models\Brand                         | brands                    | 152         | 152         |              |
| App\Models\Category                      | categories                | 70          | 70          |              |
| App\Models\Product                       | products                  | 4485        | 3079        | 0            |
| App\Models\User                          | users                     | 2644        | 2644        |              |
| App\Models\Warranty                      | warranties                | 9           | 9           |              |
+------------------------------------------+---------------------------+-------------+-------------+--------------+
```

<a name="model-list"/>

## model:fields

Show model fields info.

*(field name, field type, default value, nullable, casts, and guarded / fillable)*

```bash
php artisan model:fields <model>
```

Arguments:
- `model` <small>optional</small>: Model to show fields from (e.g. `"App\User"`). If omitted, list of all models will be shown to choose from.

#### Usage example

```bash
~$ php artisan model:fields

 Choose model to show the fields from::
  [1] App\Models\Brand
  [2] App\Models\Category
  [3] App\Models\Product
  [4] App\Models\Warranty
 > 4

 Model: `App\Models\Warranty`
+------------+----------------------+----------+---------+-------+---------+----------+
| Field      | Type                 | Nullable | Default | Casts | Guarded | Fillable |
+------------+----------------------+----------+---------+-------+---------+----------+
| id         | int(10) unsigned     |          |         | int   | YES     |          |
| name       | varchar(255)         |          |         |       |         |          |
| length     | smallint(5) unsigned |          |         |       |         |          |
| created_at | timestamp            | YES      |         |       |         |          |
| updated_at | timestamp            | YES      |         |       |         |          |
+------------+----------------------+----------+---------+-------+---------+----------+
```

<a name="db-exist"/>

## db:exist

Check if database exists

```bash
php artisan db:exist <database>
```

###### Arguments:
- `database` <small>optional</small>: Database name to check. If omitted it'll check for default db (defined in `.env`).

#### Usage example

```bash
~$ php artisan db:exist

 ! [NOTE] Database `laravel_commando` exists

```

<a name="db-create"/>

## db:create

Create database

```bash
php artisan db:create <database>
```

Arguments:
- `database` <small>optional</small>: Database to create. If omitted, name from `.env` will be used.

#### Usage example

```bash
~$ php artisan db:exist

 [OK] Database `laravel_commando` created successfully

```

<a name="db-drop"/>

## db:drop

Drop database

```bash
php artisan db:drop <database>
```

Arguments:
- `database` <small>optional</small>: Database to drop. If omitted, name from `.env` will be used

#### Usage example

```bash
~$ php artisan db:drop

 Do you really wish to drop `laravel_commando` database? (yes/no) [no]:
 > yes

 [OK] Database `laravel_commando` dropped successfully

```

<a name="db-dump"/>

## db:dump

Dump database to `.sql` file

```bash
php artisan db:dump <database> <--dir>
```

Arguments:
- `database` <small>optional</small>: Database to dump. If omitted, name from `.env` will be used.

Options:
- `--dir`: Directory for dump creation. If omitted default filesystem dir will be used.

#### Usage example

```bash
~$ php artisan db:dump

 [OK] Database `laravel_commando` dumped successfully

 Destination: `/var/www/html/storage/app/laravel_commando-2019-08-03-22-16-03.sql`

```

<a name="db-import-dump"/>

## db:import-dump

Import dump from `.sql` file

```bash
php artisan db:import-dump <database> <--dir>
```

Arguments:
- `database` <small>optional</small>: Database to import dump to. If omitted, name from `.env` will be used.

Options:
- `--dir`: Directory for dump lookup. If omitted default filesystem dir will be used.

#### Usage example

```bash
~$ php artisan db:import-dump

 Lookup dir: /var/www/html/storage/app

 Choose dump to be imported: [laravel_commando-2019-08-03-20-17-24.sql]:
  [1] laravel_commando-2019-08-03-20-17-24.sql
  [2] laravel_commando-2019-07-23-12-48-28.sql
  [3] laravel_commando-2019-07-07-22-09-06.sql
 > 2

 Database 'laravel_commando' exist. What should we do: [I changed my mind, I don`t want to import dump]:
  [0] I changed my mind, I don`t want to import dump
  [1] Import dump over existing database `laravel_commando`
  [2] Recreate `laravel_commando` database (!!! CAUTION !!!) and than import dump
 > 2

 [OK] Dump file imported successfully

```

<a name="db-summon"/>

## db:summon

Drop default database, than perform migrate followed with the seed.

Useful in early stages of development when we changing models (migrations and seeds) a lot.

```bash
php artisan db:summon
```

---

## Contributing

If you plan to modify this Laravel package you should run tests that comes with it.
Easiest way to accomplish this would be with `Docker`, `docker-compose` and `phpunit`.

First, we need to initialize Docker containers:

```bash
docker-compose up -d
```

After that, we can run tests and watch the output:

```bash
docker-compose exec app vendor/bin/phpunit
```