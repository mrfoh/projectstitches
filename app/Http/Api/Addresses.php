<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use Illuminate\Http\Request;
	use Illuminate\Auth\Access\AuthorizationException;
	use App\Repos\UserAddressRepo;

	class Addresses extends Controller {

		use RequestUser;

		protected $repo;

		public function __construct(UserAddressRepo $repo) {
			//set middleware
			$this->middleware('jwt.auth');
			$this->repo = $repo;
		}

		public function user($id) {

			return $this->repo->scopeQuery(function ($query) use ($id) {
				return $query->where('user_id','=', $id);
			})->all();
		}

		public function read($id) {
	
			return $this->repo->skipPresenter(false)->find($id);
		}

		public function create(Request $request, $id) {
			//validate request
			$this->validate($request, [
				'name' => 'required',
				'street' => 'required',
				'city' => 'required',
			]);

			//user
			$user = $this->requestUser();

			if($user->id != $id) {
				throw new AuthorizationException;
			}

			//attributes
			$attributes = $request->all();

			//update attributes
			$attributes['user_id'] = $user->id;

			//create 
			$address = $this->repo->create($attributes);

			return $address;
		}

		public function update(Request $request, $id) {
			//address
			$address = $this->repo->skipPresenter()->find($id);
		
			//authorize
			$this->authorize('update', $address);

			//attributes
			$attributes = $request->all();

			$update = $this->repo->update($attributes, $id);

			return $update;
		}

		public function makeDefault($id) {

			$user = $this->requestUser();

			$address = $this->repo->makeDefault($id, $user->id);

			return $address;
		}

		public function delete($id) {
			//address
			$address = $this->repo->skipPresenter()->find($id);
		
			//authorize
			$this->authorize('delete', $address);

			//delete
			$this->repo->delete($id);

			return response()->json(['message'=>"Address deleted"], 200);
		}
	}