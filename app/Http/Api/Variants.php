<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Repos\VariantRepo;
	use App\Repos\ProductRepo;

	class Variants extends Controller {

		protected $variants;

		public function __construct(VariantRepo $variants) {
			//set middleware
			$this->middleware('jwt.auth', ['except' => ['get']]);
			$this->variants = $variants;
		}

		public function get($id) {

			return $this->variants->findWhere(['product_id'=>$id]);
		}

		public function create(Request $request, $id) {
			$this->validate($request, [
				'options' => 'array',
				'price' => 'integer',
				'qty' => 'integer'
			]);

			$attrs = $request->all();
			$attrs['product_id'] = $id;

			$variant = $this->variants->create($attrs);

			return $variant;
		}

		public function update(Request $request, ProductRepo $products, $id, $vid) {
			$product = $products->find($id);
			
			$this->validate($request, [
				'options' => 'array',
				'price' => 'integer',
				'qty' => 'integer'
			]);

			$attrs = $request->all();

			$variant = $this->variants->update($attrs, $vid);

			return $variant;
		}

		public function delete($id, $vid) {
			//check
			$check = $this->variants->find($vid);
			//delete
			$this->variants->delete($vid);

			return response()->json(['message'=>"success"], 200);
		}
	}