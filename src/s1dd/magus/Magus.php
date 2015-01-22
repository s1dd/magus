<?php namespace S1dd\Magus;

use Config;

class Magus {

  /**
   * Parses CSV into an associative array.
   * 
   * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $file
   * @return array 
   */
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

  /**
   * Parses a CSV string into an associative array.
   * 
   * @param  string $string 
   * @return array
   */
  public function parseString($string) {

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


  /**
   * Parses a JSON string into an associative array.
   * 
   * @param  string $string
   * @return array
   */
  public function parseJson($string) {

    return json_decode($string, true);

  }

  /**
   * Creates models with data from an associative array
   * 
   * @param  string $type
   * @param  array  $data
   * @return object 
   */
  public function import($type, array $data = null) {

    $data = array_change_key_case($data);

    if (is_string($type)) $type = studly_case($type);

    $config = Config::get('s1dd/magus::fieldmaps.maps');

    $resolvedFields = [];

    if ( isset($config[$type]) ) $fieldmap = $config[$type];
    else                         $fieldmap = [];

    foreach ($fieldmap as $key => $field) {

      $key = strtolower($key);

      if (isset($data[$key])) {

        $resolvedFields[$field] = $this->mutate([
          'from' => $key,
          'value'   => $data[$key],
          'type' => $type
        ]);

      }

    }

    // resolving string $type out of IoC container
    return \App::make($type)->create($resolvedFields);
  }

  /**
   * Modifies input based on Closures from config.php,
   * and mappings from fieldmaps.php
   * 
   * @param  array  $options
   * @return mixed
   */
  private function mutate(array $options) {

    $config = array_change_key_case(Config::get('s1dd/magus::' . $options['type'] ));

    if ( isset($config[$options['from']]) ) {

      $closure = $config[$options['from']];

      return call_user_func($closure, $options['value']);

    }
    else return head($options['value']);

  }

}
