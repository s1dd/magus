<?php namespace S1dd\Magus;

use Illuminate\Support\Facades\Facade;

class MagusFacade extends Facade {
  
  protected static function getFacadeAccessor() { return 'magus'; }

}
