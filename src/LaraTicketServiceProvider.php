<?php

namespace Sdkcodes\LaraTicket;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * LaraTicketServiceProvider
 */
class LaraTicketServiceProvider extends ServiceProvider
{
	public function boot(){

		$this->publishes([
	        __DIR__.'/config/laraticket.php' => config_path('laraticket.php'),
	    ], 'config');

	    $this->mergeConfigFrom(
	        __DIR__.'/config/laraticket.php', 'laraticket'
	    );

		$this->loadRoutesFrom(__DIR__.'/routes.php');
		$this->loadMigrationsFrom(__DIR__.'/migrations');
		$this->loadViewsFrom(__DIR__.'/views', 'laraticket');

		$this->publishes([
	        __DIR__.'/views' => resource_path('views/vendor/laraticket'),
	    ], 'views');
	}

	public function register(){

	}
}