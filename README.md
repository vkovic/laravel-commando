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

The package is compatible with Laravel versions `5.5`, `5.6`, `5.7`, `5.8`, `6.x`, `7.x` and `8.x`.

> Because some commands rely on raw console commands (like `db:dump` which uses `mysqldump`), currently only MySql database and Linux environments are supported. Package is designed to easily support multiple OS-es and database types, and it should be easy implementation, so if anyone is interested to help, please feel free to contribute.

## Installation

Install the package via composer:

If your're using Laravel prior version 8, run: 
```bash
composer require vkovic/laravel-commando
```

If your're using Laravel 8, run: 
```bash
composer require vkovic/laravel-commando "^0.1"
```

## Available commands

> Package is in early stage so there is limited number of commands. I'm planning to add more, so if you have some suggestion you can require feature via issues page (click on `Issues -> New issue -> Feature request`)

###### Model related

- [**model**:list](#model-list) ~ List all application `Models` and related info
- [**model**:fields](#model-fields) ~ Show single `Model` and useful info

###### Database related

- [**db**:exist](#db-exist) ~ Check for database existance
- [**db**:create](#db-create) ~ Create database
- [**db**:drop](#db-drop) ~ Easily drop default or another db
- [**db**:dump](#db-dump) ~ Dump database to `.sql` file
- [**db**:import-dump](#db-import-dump) ~ Import db from exported `.sql`
- [**db**:summon](#db-summon) ~ create/drop | migrate | seed

---

<a name="model-list"/>

## `php artisan model:list`

Show all models and some basic info.

- Model (model class)
- Table (table used by the model)
- Table count (count of all records in the model related table)
- Scope count (count of records with all scopes applied: `$n = SomeModel::count()`
- Soft deleted (show how many soft deleted items model have)

#### Usage example

![php artisan model list command from laravel-commando package](https://raw.githubusercontent.com/vkovic/laravel-commando/master/docs/images/php_artisan_model_list.png)

<a name="model-fields"/>

## `php artisan model:fields <model>`

Show model fields info.

- Field (model field / table column)
- Type (db field type)
- Nullable (db value can be null)
- Default (default db value)
- Casts (attribute muttators)
- Guarded (field is not [mass assignable](https://laravel.com/docs/5.8/eloquent#mass-assignment))
- Fillable (field is mass assignable)

Arguments:
- `model` <small>optional</small>: Model to show fields from (e.g. `"App\User"`). If omitted, list of all models will be shown to choose from.

#### Usage example

![php artisan model fields command from laravel-commando package](https://raw.githubusercontent.com/vkovic/laravel-commando/master/docs/images/php_artisan_model_fields.png)

<a name="db-exist"/>

## `php artisan db:exist <database>`

Check if database exists

###### Arguments:
- `database` <small>optional</small>: Database name to check. If omitted it'll check for default db (defined in `.env`).

#### Usage example

![php artisan db exists command from laravel-commando package](https://raw.githubusercontent.com/vkovic/laravel-commando/master/docs/images/php_artisan_db_exist.png)

<a name="db-create"/>

## `php artisan db:create <database>`

Create database

Arguments:
- `database` <small>optional</small>: Database to create. If omitted, name from `.env` will be used.

#### Usage example

![php artisan db create command from laravel-commando package](https://raw.githubusercontent.com/vkovic/laravel-commando/master/docs/images/php_artisan_db_create.png)

<a name="db-drop"/>

## `php artisan db:drop <database>`

Drop database

Arguments:
- `database` <small>optional</small>: Database to drop. If omitted, name from `.env` will be used

#### Usage example

![php artisan db drop command from laravel-commando package](https://raw.githubusercontent.com/vkovic/laravel-commando/master/docs/images/php_artisan_db_drop.png)

<a name="db-dump"/>

## `php artisan db:dump <database> <--dir>`

Dump database to `.sql` file

Arguments:
- `database` <small>optional</small>: Database to dump. If omitted, name from `.env` will be used.

Options:
- `--dir`: Directory for dump creation. If omitted default filesystem dir will be used.

#### Usage example

![php artisan db dump command from laravel-commando package](https://raw.githubusercontent.com/vkovic/laravel-commando/master/docs/images/php_artisan_db_dump.png)

<a name="db-import-dump"/>

## `php artisan db:import-dump <database> <--dir>`

Import dump from `.sql` file

Arguments:
- `database` <small>optional</small>: Database to import dump to. If omitted, name from `.env` will be used.

Options:
- `--dir`: Directory for dump lookup. If omitted default filesystem dir will be used.

#### Usage example

![php artisan db import dump command from laravel-commando package](https://raw.githubusercontent.com/vkovic/laravel-commando/master/docs/images/php_artisan_db_import_dump.png)

<a name="db-summon"/>

## `php artisan db:summon`

Drop default database, than perform migrate followed with the seed.

Useful in early stages of development when we changing models (migrations and seeds) a lot.

#### Usage example

![php artisan db summon command from laravel-commando package](https://raw.githubusercontent.com/vkovic/laravel-commando/master/docs/images/php_artisan_db_summon.png)

---

## Contributing

If you plan to modify this Laravel package you should run tests that comes with it.
Easiest way to accomplish this would be with `Docker`, `docker-compose` and `phpunit`.

First, we need to initialize Docker containers (see `docker-composer.yaml` for details).

```bash
docker-compose up --exit-code-from app
```

After that, we can run tests and watch the output:

```bash
docker-compose run --rm app phpunit
```
