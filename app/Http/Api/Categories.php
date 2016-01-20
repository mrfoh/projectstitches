<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Repos\CategoryRepo;
	use App\Repos\ProductRepo as Products;
	use App\Repos\Traits\Pageable;

	class Categories extends Controller {

		use Pageable;

		protected $categories;

		protected $products;

		public function __construct(CategoryRepo $categories, Products $products) {
			//set middleware
			$this->middleware('jwt.auth', ['except' => ['index','get']]);
			$this->categories = $categories;
			$this->products = $products;
		}

		/**
		* Retrivies Category models
		* @param Illuminate\Http\Request $request
		**/
		public function index(Request $request) {
			//models per page
			$perPage = $request->input('perpage', 20);

			//segment
			$segment = $request->input('segment', null);

			//sort by
			$sortBy = $request->input('sort_by', 'name');

			//sortOrder
			$sortOrder = $request->input('sort_order', 'asc');

			//current page
			$page = $request->input('page', 1);

			//fetch models
			$categories = $this->categories->scopeQuery(function ($query)
				use ($sortBy, $sortOrder, $segment) {
					if(!is_null($segment))
						return $query->whereSegment($segment)->orderBy($sortBy, $sortOrder);
					else
						return $query->orderBy($sortBy, $sortOrder);
			})->all();

			$data = $categories['data'];

			return $this->paginateData($data, count($data), $page, $perPage);
		}

		/**
		* Retrive Category model
		* @param integer $id
		**/
		public function get($id) {

			return $this->categories->find($id);
		}

		/**
		* Retrieve Product models associated with category
		* @param Illuminate\Http\Request $request
		* @param integer $id
		* category model id
		**/
		public function products(Request $request, $id) {
			//models per page
			$perPage = $request->input('perpage', 20);
			//sort by
			$sortBy = $request->input('sort_by', 'name');
			//sortOrder
			$sortOrder = $request->input('sort_order', 'asc');
			//current page
			$page = $request->input('page', 1);
			//products
			$products = $this->products->inCategory($id, $sortBy, $sortOrder);
			$data = $products['data'];

			return $this->paginateData($data, count($data), $page, $perPage);
		}

		/**
		* Crate Category model
		* @param Illuminate\Http\Request $request
		**/
		public function create(Request $request) {
			//validate request
			$this->validate($request, [
				'name' => 'required',
				'segment' => 'required|in:female,male,unisex',
				'parent_id' => 'exists:categories,id'
			]);
			//attributes
			$attrs = $request->all();

			if(!isset($attrs['slug']))
				$attrs['slug'] = str_slug($attrs['name']);

			//TODO: check if user can create categories
			$category = $this->categories->create($attrs);
			//TODO: fire event
			return $category;
		}

		/**
		* Update Category model
		* @param Illuminate\Http\Request $request
		* @param integer $id
		**/
		public function update(Request $request, $id) {
			//check for existence of model
			$check = $this->categories->find($id);

			//validate request
			$this->validate($request, [
				'segment' => 'in:female,male,unisex',
				'parent_id' => 'exists:categories,id'
			]);

			//attributes
			$attrs = $request->all();

			if(isset($attrs['name']) && !isset($attrs['slug']))
				$attrs['slug'] = str_slug($attrs['name']);

			//TODO: check if user can update categories
			$category = $this->categories->update($attrs, $id);
			//TODO: fire event
			return $category;
		}
	}