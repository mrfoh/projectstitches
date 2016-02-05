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

			$product = $this->products->skipPresenter()->find($productid);

			Cart::insert(['id' => $product->id, 'name' => $product->name, 'quantity' => $qty, 'price' => $product->price]);

			return Cart::contents(true);
		}	

		/**
		* Puts an item into a cart
		**/
		public function remove($rowid) {

			Cart::instance($this->getInstance())->remove($rowid);

			return Cart::content();
		}
	}