<?php namespace S1dd\Magus;

use Illuminate\Support\Facades\Facade;

/**
 * @see S1dd\Magus\Magus
 */
class MagusFacade extends Facade {
  
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'magus'; }

}
