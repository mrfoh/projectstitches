<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use Carbon\Carbon;
	use JWTAuth;
	use Illuminate\Http\Request;
	use App\Repos\ProductRepo;
	use Cart;

	class Carts extends Controller {

		protected $products;

		public function __construct(ProductRepo $products) {
			//set middleware
			$this->middleware('jwt.auth');

			$this->products = $products;

			Cart::associate('Product','App\Models');
		}

		protected function getInstance() {
			$user = JWTAuth::parseToken()->authenticate();
			$instance = "user.".$user->id;

			return $instance;
		}

		/**
		* Retrieve contents of cart
		* @param Illuminate\Http\Request $request
		**/
		public function get() {
			return Cart::instance($this->getInstance())->content();
		}

		/**
		* Puts an item into a cart
		* @param Illuminate\Http\Request $request
		**/
		public function put(Request $request) {

			$productid = $request->input('product_id');
			$qty = $request->input('qty');

			$this->products->skipPresenter();
			$product = $this->products->find($productid);
			$name = $product->name;

			Cart::instance($this->getInstance)->add($productid, $product->name, $qty, $product->price);

			return Cart::content();
		}	

		/**
		* Puts an item into a cart
		**/
		public function remove($rowid) {

			Cart::instance($this->getInstance())->remove($rowid);

			return Cart::content();
		}
	}