<?php namespace S1dd\Magus\Mutators;

class Facebook extends MutatorBase {

  public static function facebook($url) {

    // Uniforming $url argument
    if (mb_substr($url, 0, 4) !== 'http') $url = 'https://' . $url;

    $name = self::url_to_name($url);

    $id = \FacebookApi::getId($name);

    return [
      'url' => FACEBOOK_PREFIX . $name,
      'name' => $name,
      'id' => $id,
      'token' => \FacebookApi::getToken($id),
    ];
  }

  private static function url_to_name($url) {
    $path = explode('/', parse_url($url, PHP_URL_PATH));
    
    foreach ($path as $name) {
      if ($name !== 'pages' &&
          $name !== 'timeline' &&
          preg_match(FACEBOOK_REGEXP, $name) &&
          strlen($name) >= FACEBOOK_MINIMUM_USERNAME_LENGTH) {
        $selection = trim($name);
      }
    } 

    return $selection;
  }
}
