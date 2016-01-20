<?php 
	namespace App\Packages\Cart;

	use Illuminate\Support\ServiceProvider;
	use Illuminate\Session\Store as Session;

	class CartServiceProvider extends ServiceProvider {

		/**
		 * Register the service provider.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->app->bind('App\Packages\Cart\Storage\StorageInterface', function($app) {
				return new Storage\Session\SessionRepo($app['Illuminate\Session\Store']);
			});
		}
	}