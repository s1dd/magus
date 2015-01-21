<?php namespace S1dd\Magus\Mutators;

abstract class MutatorBase {
  
  public static function __callStatic($name, $args) {
    return head($args);
  }

}
