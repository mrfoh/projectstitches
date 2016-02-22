<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use Illuminate\Http\Request;
	use App\Repos\Traits\Pageable;
	use App\Repos\UserMeasurementRepo;

	class UserMeasurements extends Controller {

		use Pageable, RequestUser;

		protected $repo;

		public function __construct(UserMeasurementRepo $repo) {
			//set middleware
			$this->middleware('jwt.auth');
			//set repository
			$this->repo = $repo;
		}

		private function authorizeRequest($id) {
			$user = $this->requestUser();

			if($user->id != $id) {
				throw new \Illuminate\Auth\Access\AuthorizationException();
			}
		}

		public function create(Request $request, $id) {
			//validate request
			$this->validate($request, ['name' => 'required', 'measurements' => 'required|array']);

			//model attributes
			$attributes = [
				'user_id' => $id,
				'name' => $request->input('name'),
				'measurements' => $request->input('measurements')
			];

			$this->authorizeRequest($id);

			//create model
			$userMeasurement = $this->repo->create($attributes);

			return $userMeasurement;	
		}

		public function update(Request $request, $id, $mid) {
			//validate request
			$this->validate($request, ['measurements' => 'array']);

			$measurement = $this->repo->skipPresenter()->find($mid);

			$this->authorizeRequest($measurement->id);

			$update = $this->repo->skipPresenter(false)->update($request->all(), $mid);

			return $update;
		} 

		public function delete($id, $mid) {
			$measurement = $this->repo->skipPresenter()->find($mid);

			$this->authorizeRequest($measurement->id);

			$this->repo->delete($mid);

			return response()->json(['message'=>"Measurement deleted successfully"], 200);
		}
	}
