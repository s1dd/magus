<?php namespace S1dd\Magus\Mutators;

use \Carbon\Carbon;

class Client extends MutatorBase {

  public static function planId($value) {
    switch (strtolower($value)) {
      case 'basic plan':
        return 1;
      case 'value plan':
        return 2;
      case 'premium plan':
        return 3;
      default:
        return null; 
    } 
  }

  public static function startDate($value) {
    return (new Carbon($value))->toDateString($value);
  }

}
