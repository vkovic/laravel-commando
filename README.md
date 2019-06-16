# Laravel Commandos

[![Build](https://api.travis-ci.org/vkovic/laravel-commandos.svg?branch=master)](https://travis-ci.org/vkovic/laravel-commandos)
[![Downloads](https://poser.pugx.org/vkovic/laravel-commandos/downloads)](https://packagist.org/packages/vkovic/laravel-commandos)
[![Stable](https://poser.pugx.org/vkovic/laravel-commandos/v/stable)](https://packagist.org/packages/vkovic/laravel-commandos)
[![License](https://poser.pugx.org/vkovic/laravel-commandos/license)](https://packagist.org/packages/vkovic/laravel-commandos)

### Title

Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus adipisci amet aperiam atque consequatur, debitis
dignissimos distinctio dolorem ea eveniet expedita explicabo facilis fuga, hic in ipsam itaque, laboriosam laborum
maiores nesciunt placeat quia repellat reprehenderit sed suscipit tenetur vel voluptate? Aliquam consectetur
consequuntur ex hic laboriosam veritatis. Assumenda doloremque illo laboriosam laborum molestias recusandae sint tenetur
vero? Accusantium aliquid at autem cum cumque, delectus dolorum enim eos et facilis harum hic iste itaque necessitatibus
nihil, odit porro quas, recusandae saepe sint temporibus vel vero. Consectetur, consequuntur cum cumque deleniti
dignissimos ea enim, magnam mollitia, nisi quam sit tempore veritatis.

---

## Compatibility

The package is compatible with Laravel versions `5.5`, `5.6`, `5.7` and `5.8`, and PHP versions 7.1, 7.2 and 7.3

## Installation

Install the package via composer:

```bash
composer require vkovic/laravel-commandos
```

## Usage

### Subtitle

Code example

```php
// File: app/ExampleClass.php

namespace App\CustomCasts;

use Vkovic\LaravelCustomCasts\CustomCastBase;

class ExampleClass
{
    public function setAttribute($value)
    {
        return ucwords($value);
    }

    public function castAttribute($value)
    {
        return $this->getTitle() . ' ' . $value;
    }

    protected function getTitle()
    {
        return ['Mr.', 'Mrs.', 'Ms.', 'Miss'][rand(0, 3)];
    }
}
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