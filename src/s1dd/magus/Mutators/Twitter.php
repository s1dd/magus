<?php namespace S1dd\Magus\Mutators;

class Twitter extends MutatorBase {

   public static function twitter($url) {

    if (mb_substr($url, 0, 4) !== 'http') $url = 'https://' . $url;

    $name = ltrim(parse_url($url, PHP_URL_PATH), '/');

    return [
      'url' => TWITTER_PREFIX . $name,
      'name' => $name
    ];
  } 
}
