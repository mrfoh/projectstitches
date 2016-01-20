<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use JWTAuth;
	use Image;
	use App\Repos\Traits\Pageable;
	use App\Repos\ImageRepo as Collection;

	class Media extends Controller {

		use Pageable;

		protected $collection;

		public function __construct(Collection $collection) {
			//set middleware
			$this->middleware('jwt.auth', ['except' => ['index']]);
			$this->collection = $collection;
		}

		public function index(Request $request) {
			//models per page
			$perPage = $request->input('perpage', 20);
			//current page
			$page = $request->input('page', 1);
			//sort by
			$sortBy = $request->input('sort_by', 'created_at');
			//sort order
			$sortOrder = $request->input('sort_order', 'desc');
			//fetch models
			$media = $this->collection->scopeQuery(function ($query) use ($sortBy, $sortOrder) {
				return $query->orderBy($sortBy, $sortOrder);
			})->all();
			
			$data = $media['data'];

			return $this->paginateData($data, count($data), $page, $perPage);

		}

		public function upload(Request $request) {
			$this->validate($request, [
				'image' => 'required|mimes:jpeg,png|max:2024'
			]);

			$file = $request->file('image');
			//create filename from timestamp and filename
			$name = time()."_".$file->getClientOriginalName();
			//upload path
			$path = public_path('content/'.$name);
			//upload file
			$img = Image::make($file)->save($path);

			//get user
			$user = JWTAuth::parseToken()->authenticate();

			//attributes
			$attrs = [
				"user_id" => $user->id,
				"path" => 'content/'.$name,
				"mime" => $img->mime(),
				"size"=> $img->filesize(),
			];

			$image = $this->collection->create($attrs);

			return $image;
		}
	}