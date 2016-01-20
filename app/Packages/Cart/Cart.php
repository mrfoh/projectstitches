<?php
	namespace App\Packages\Cart;

	use App\Packages\Cart\Storage\StorageInterface as Storage;
	use JWTAuth;

	class Cart {

		/**
		* Session class instance
		*
		* @var Illuminate\Session\Store
		*/
		protected $storage;

		/**
		* Current cart instance
		*
		* @var string
		*/
		protected $instance;

		public function __construct(Storage $storage) {
			$user = JWTAuth::parseToken()->authenticate();

			$this->instance = "cart.user.".$user->id;

			$this->storage = $storage;
			$this->storage->setIdentifier($this->instance);

			$cart = $this->storage->get();
		}
	}