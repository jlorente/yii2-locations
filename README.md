Yii2 Locations (Development Phase)
==================================

A Yii2 extension that includes database tables, models and an admin module to 
store locations.

## Installation

Include the package as dependency under the composer.json file.

To install, either run

```bash
$ php composer.phar require jlorente/yii2-locations "*"
```

or add

```json
...
    "require": {
        // ... other configurations ...
        "jlorente/yii2-locations": "*"
    }
```

to the ```require``` section of your `composer.json` file and run the following 
commands from your project directory.
```bash
$ composer update
$ ./yii migrate --migrationPath=@vendor/jlorente/yii2-locations/src/migrations
```

## Usage

In construction

## License 
Copyright &copy; 2015 José Lorente Martín <jose.lorente.martin@gmail.com>.

Licensed under the MIT license. See LICENSE.txt for details.