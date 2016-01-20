<?php
	namespace App\Http\Api;

	use Gate;
	use Image;
	use Validator;
	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use Illuminate\Http\Request;
	use App\Repos\ProductRepo;
	use App\Repos\ImageRepo;
	use App\Repos\Traits\Pageable;

	class Products extends Controller {

		use Pageable, RequestUser;

		protected $products;

		protected $variants;

		protected $createRules = [
			'name' => 'required',
			'vendor_id' => 'required',
			'category_id' => 'required',
			'price' => 'required|integer'
		];

		protected $updateRules = [
			'media_ids' => 'array',
			'price' => 'integer'
		];

		public function __construct(ProductRepo $products) {
			//set middleware
			$this->middleware('jwt.auth', ['except' => ['index','get']]);
			$this->products = $products;
		}
		
		public function index(Request $request) {
			//models per page
			$perPage = $request->input('perpage', 20);
			//vendor
			$vendor = (int) $request->input('vendor');
			//category
			$category = (int) $request->input('category');
			//sortby
			$sortBy = $request->input('sort_by', 'created_at');
			//sortOrder
			$sortOrder = $request->input('sort_order', 'asc');
			//current page
			$page = $request->input('page', 1);
			//fetch models
			$products = $this->products->all();
			$data = $products['data'];

			return $this->paginateData($data, count($data), $page, $perPage);
		}

		public function get($id) {
			return $this->products->find($id);	
		}

		/**
		* Create new product model
		* @param Illuminate\Http\Request $request
		**/
		public function create(Request $request) {
			//validate request
			$this->validate($request, $this->createRules);
			
			//model attributes
			$attrs = $request->all();
			
			//Authorization
			$this->authorize('create',\App\Models\Product::class);

			//create product
			$product = $this->products->create($attrs);

			return $product;	
		}

		public function update(Request $request, $id) {
			//check
			$check = $this->products->skipPresenter()->find($id);

			//validate request
			$this->validate($request, $this->updateRules);

			//Authorization
			$this->authorize('update', $check);

			//model attributes
			$attrs = $request->all();

			//create product
			$product = $this->products->skipPresenter(false)->update($attrs, $id);

			return $product;
		}

		public function delete($id) {
			$this->products->skipPresenter();
			//check
			$product = $this->products->find($id);

			//Authorization
			$this->authorize('delete', $product);

			//delete
			$this->products->delete($id);

			return response()->json(['message'=>"success"], 200);
		}

		public function addMedia(ImageRepo $imageCollection, Request $request, $id) {
			$product = $this->products->skipPresenter()->find($id);

			$validation = Validator::make($request->all(), [
				'image' => 'required|mimes:jpeg,png|max:2024'
			]);

			if($validation->fails()) {
				$messages = $validation->messages();
				return response()->json($messages, 422);
			}

			$file = $request->file('image');
			//create filename from timestamp and filename
			$name = time()."_".$file->getClientOriginalName();
			//upload path
			$path = public_path('content/'.$name);
			//upload file
			$img = Image::make($file)->save($path);

			//get user
			$user = $this->requestUser();

			//attributes
			$attrs = [
				"user_id" => $user->id,
				"path" => 'content/'.$name,
				"mime" => $img->mime(),
				"size"=> $img->filesize(),
			];

			$image = $imageCollection->skipPresenter()->create($attrs);
			$product->images()->save($image);

			return $imageCollection->skipPresenter(false)->find($image->id);
		}

		public function deleteMedia(ImageRepo $imageCollection, $id, $mid) {
			$product = $this->products->skipPresenter()->find($id);
			$image = $imageCollection->skipPresenter()->find($mid);

			$imageCollection->delete($mid);

			return response()->json(['message' => "Image deleted"], 200);
		}
	}