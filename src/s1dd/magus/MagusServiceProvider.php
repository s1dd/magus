<?php namespace S1dd\Magus;

use Illuminate\Support\ServiceProvider;

class MagusServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot() {

		$this->package('s1dd/magus', 's1dd/magus');

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
  public function register() {

    $this->app->bindShared('magus', function() {

      return new Magus;

    });

  }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['magus'];
	}

}
