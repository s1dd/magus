# Magus

===

Import CSV and JSON data into Laravel models, with the use of mutators to manipulate data before data is stored in the database.


## Installation

Add ```s1dd/magus``` to the ```repositories``` section of your ```composer.json```.

```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/s1dd/magus"
    }
  ]
}


```

Add the Service Provider to your ```app/config/app.php```:

```
'providers' => [

  ...
  'S1dd\Magus\MagusServiceProvider',
  ...
];
```

...and as an alias so that it can be used as a Facade:

```
'aliases' => [
  ...
  'Magus' => 'S1dd\Magus\MagusFacade',
  ...
];
```

## Configuration

If you would like to add mutators to Magus, publish the configuration, and supply an array whose values are Closures.

```
$ php artisan config:publish s1dd/magus
```

The configuration file is located at:

```
app/config/packages/s1dd/magus
```

## License

This project is licensed under the MIT license.
