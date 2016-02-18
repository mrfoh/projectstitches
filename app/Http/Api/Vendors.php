<?php
	namespace App\Http\Api;

	use Image;
	use Gate;
	use Validator;
	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use Illuminate\Http\Request;
	use App\Repos\UserRepo as Users;
	use App\Repos\ProductRepo;
	use App\Repos\VendorRepo;
	use App\Repos\VendorOrderRepo;
	use App\Repos\VendorProfileRepo;
	use App\Repos\Traits\Pageable;

	class Vendors extends Controller {

		use Pageable, RequestUser;

		protected $vendors;

		protected $users;

		protected $orders;

		public function __construct(VendorRepo $vendors, Users $users, VendorOrderRepo $orders) {
			//set middleware
			$this->middleware('jwt.auth', ['except' => ['index']]);
			//set repositories
			$this->vendors = $vendors;
			$this->users = $users;
			$this->orders = $orders;
		}

		/**
		* Retrieve vendor model(s)
		* @param Illuminate\Http\Request $request
		* @param integer $id
		**/
		public function index(Request $request, $id = null) {

			if(is_null($id))
			{
				//models per page
				$perPage = $request->input('perpage', 20);
				//current page
				$page = $request->input('page', 1);
				//fetch models
				$vendors = $this->vendors->all();
				$data = $vendors['data'];

				return $this->paginateData($data, count($data), $page, $perPage);
			}
			else
			{
				return $this->vendors->find($id);
			}
		}

		public function products(Request $request, ProductRepo $products, $id) {

			//models per page
			$perPage = $request->input('per_page', 30);
			//current page
			$page = $request->input('page', 1);
			//sort by
			$sortBy = $request->input('sort_by', 'name');
			//sort order
			$sortOrder = $request->input('sort_order', 'desc');
			//models
			$models = $products->scopeQuery(function ($query) use ($id, $sortBy, $sortOrder) {
				return $query->where('vendor_id','=', $id)
							 ->orderBy($sortBy, $sortOrder);
			})->all();

			return $this->paginateData($models['data'], count($models['data']), $page, $perPage);
		}

		/**
		* Retrieve vendors orders
		 * @param Illuminate\Http\Request $request
		 * @param integer $id
		*/
		public function orders(Request $request, $id) {
			//models per page
			$perPage = $request->input('per_page', 30);
			//current page
			$page = $request->input('page', 1);
			//sort by
			$sortBy = $request->input('sort_by', 'created_at');
			//sort order
			$sortOrder = $request->input('sort_order', 'desc');
			//models
			$models = $this->orders->scopeQuery(function($query) use ($id, $sortBy, $sortOrder) {
				return $query->where('vendor_id','=', $id)->orderBy($sortBy, $sortOrder);
			})->all();

			return $this->paginateData($models['data'], count($models['data']), $page, $perPage);
		}

		/**
		* Create a new vendor
		**/
		public function create(Request $request) {
			//validate request
			$this->validate($request, [
				'name' => 'required',
				'segment' => 'required|in:female,male,unisex',
				'phone' => 'required',
				'address' => 'required',
				'description' => 'max:400',

			]);
			//request attributes
			$attrs = $request->all();
			//get user
			$user = $this->requestUser();
			//create vendor
			$vendor = $this->vendors->make($attrs, $user);
			//TODO: fire event

			return $vendor;
		}

		/**
		* @param Illuminate\Http\Request $request
		* @param integer $id
		**/
		public function update(Request $request, VendorProfileRepo $vendorProfiles, $id) {
			//check for existence (throws ModelNotFoundException)
			$check = $this->vendors->skipPresenter()->find($id);

			//validate request
			$this->validate($request, [
				'segment' => 'in:female,male,unisex',
				'description' => 'max:400'
			]);

			//request attributes
			$attrs = $request->all();

			//Authorization
			$this->authorize('update', $check);

			if(isset($attrs['profile'])) {
				$profile = $vendorProfiles->update($attrs['profile'], $check->profile->id);
			}

			$vendor = $this->vendors->skipPresenter(false)->update($attrs, $id);

			return $vendor;
		}

		/**
		* Uploads a vendor's logo
		* @param Illuminate\Http\Request $request
		* @param integer $id
		**/
		public function uploadLogo(Request $request, $id) {
			//vendor
			$vendor = $this->vendors->skipPresenter()->find($id);

			//validate request
			$validation = Validator::make($request->all(), [
				'logo' => 'required|mimes:jpeg,png|max:2024'
			]);

			//return validation error
			if($validation->fails()) {
				$messages = $validation->messages();
				return response()->json($messages, 422);
			}

			//Authorization
			$this->authorize('update', $vendor);

			$file = $request->file('logo');
			//create filename from timestamp and filename
			$name = time()."_".$file->getClientOriginalName();
			//upload path
			$path = public_path('content/'.$name);
			//upload file
			$img = Image::make($file)->save($path);
			//server path
			$serverPath = config('app.url')."/content/".$name;

			//update vendor
			$this->vendors->update(['logo' => $serverPath], $vendor->id);

			return response()->json(['path' => $serverPath], 200);
		}
	}
