<?php
	
	namespace App\Http\Api;

	use Image;
	use Validator;
	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use Illuminate\Http\Request;
	use App\Repos\CampaignRepo;
	use App\Repos\ImageRepo;
	
	class Campaigns extends Controller {

		use RequestUser;

		protected $repo;

		public function __construct(CampaignRepo $repo) {
			$this->repo = $repo;
		}

		public function index() {

			return $this->repo->active();
		}

		public function create(Request $request) {

			$this->validate($request, ['title' => 'required']);

			$attributes = $request->all();

			return $this->repo->create($attributes);
		}

		public function update(Request $request, $id) {

			$campaign = $this->repo->skipPresenter()->find($id);

			$attributes = $request->all();

			return $this->repo->update($attributes, $id);
		}

		public function upload(ImageRepo $imageCollection, Request $request, $id) {

			$campaign = $this->repo->skipPresenter()->find($id);

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
			$campaign->images()->save($image);

			return $imageCollection->skipPresenter(false)->find($image->id);
		}
	}