<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Repos\UserRepo;
	use App\Repos\UserMeasurementRepo;
	use App\Http\Api\Traits\RequestUser;

	class Users extends Controller {

		use RequestUser;

		protected $repo;

		public function __construct(UserRepo $repo) {
			//set middleware
			$this->middleware('jwt.auth');
			$this->repo = $repo;
		}

		/**
		* Update user model
		* @param Illuminate\Http\Request $request
		* @param integer $id
		* @return json
		**/
		public function update(Request $request, $id) {
			//validate request
			$this->validate($request, ['email' => "email"]);

			//attrs
			$attrs = $request->all();

			//get user
			$user = $this->repo->skipPresenter()->find($id);

			//authorize request
			$this->authorize('update', $user);

			//update user
			$user = $this->repo->update($attrs, $id);

			return $user;
		}

		/**
		* Retrieve UserMeasurements models assoicated with User
		* @param App\Repos\UserMeasurementRepo $measurements
		* @param integer $id
		* @return json
		**/
		public function measurements(UserMeasurementRepo $measurements, $id) {

			return $measurements->user($id);
		}
	}