<?php namespace S1dd\Magus;

use Config;

class Magus {

  public function parse(\Symfony\Component\HttpFoundation\File\UploadedFile $file) {

    ini_set("auto_detect_line_endings", "1"); 

    $handle = fopen($file->getRealPath(), 'r');

    $fields = fgetcsv($handle);
    
    while (($row = fgetcsv($handle)) != false) {

      for ($i = 0; $i < count($fields); $i++) {
        $rowData[$fields[$i]] = $row[$i];
      }

      $data[] = $rowData;
    }

    return (count($data) === 1) ? $data[0] : $data;
  }

  public function parseString($string) {

    dd(call_user_func(Config::get('s1dd/magus::test')));

    // DEBUG

    // return $this->mutate('facebook', 'facebook');

    ini_set("auto_detect_line_endings", "1"); 

    $rows = str_getcsv($string, "\r\n");

    foreach ($rows as $row) {
      $csv[] = str_getcsv($row);
    }

    for ($i = 1; $i < count($csv); $i++) {
      $response[] = array_combine(head($csv), $csv[$i]);
    }


    return (count($response) === 1) ? $response[0] : $response;

  }

  public function import($type, array $data = null) {

    $data = array_change_key_case($data);

    if (is_string($type)) $type = studly_case($type);

    $fieldmap = \Fieldmap::ofType($type)->get()->toArray();

    foreach ($fieldmap as $field) {

      if (isset($data[$field['value']])) {

        $resolvedFields[$field['key']] = $this->mutate($field['key'], $data[$field['value']]);

      }

    }


    // resolving string $type out of IoC container
    return \App::make($type)->create($resolvedFields);
  }

  private function mutate($key, $value) {

    // TODO: dynamically load classes instead of using an array
    if (in_array($key, ['facebook', 'foursquare', 'google', 'twitter', 'yelp'])) {
      return call_user_func(__NAMESPACE__.'\Mutators\\'.studly_case($key).'::'.$key, $value);
    }
    else {
      return call_user_func(__NAMESPACE__.'\Mutators\Client::' . studly_case($key), $value);
    }

  }

}
