# Magus

Import CSV and JSON data into Laravel models, with the use of mutators to manipulate data before data is stored in the database.

## Installation

Add ```s1dd/magus``` to the ```repositories``` section of your ```composer.json```.

```json
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

```php
'providers' => [
  ...
  'S1dd\Magus\MagusServiceProvider',
  ...
];
```

...and as an alias so that it can be used as a Facade:

```php
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

The configuration files are at:

```
app/config/packages/s1dd/magus/config.php
app/config/packages/s1dd/magus/fieldmaps.php
```

## Usage

The only prerequisite is that the configuration **must** be published, and the model to populate must already exist.

If we wanted to populate a ```Client``` model, which contains a ```name```, ```fname```, and ```lname```, and we had a CSV string that houses this data in a different format, i.e.:

```
First Name,Last Name\rSidd,Sridharan
```

We would first need to **parse** the string into an associative array, and then import this array into the database:

```php
$dataString = "First Name,Last Name\rSidd,Sridharan";
$data = Magus::parseString($dataString);

Magus::import('client', $data);
```

First, Magus checks the user-supplied ```fieldmaps.php``` in order to map CSV columns to their respective database columns. Then, Magus resolves the first parameter from the IoC container so it can be used as if it was a model. It then invokes the ```create``` method to insert it into the database after the input has been "mutated."

### Fieldmaps

As described earlier, fieldmaps.php is simply a mapping from CSV column names to database column names. An example:

```php
return [
  'map' => [
    'Client' => [
      'Name' => 'name',
      'First Name' => 'fname',
      'Last Name' => 'lname'
    ]
  ]
];
```

### Mutators

Mutators are a powerful part of Magus that allow for data manipulation prior to saving. In order to declare a Mutator, open up ```config.php```, and add a key for the model which will be updated. Then, for each field that needs to be manipulated, declare a sub-key that points to a closure. To provide a clearer picture:

```php
return [

  'Client' => [

    'First Name' => function($value) {
      return strtoupper($value);
    },

    'Last Name' => function($value) {
      return strtolower($value);
    },
  ]

]
```

## License

This project is licensed under the MIT license.
