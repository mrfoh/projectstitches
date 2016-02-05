<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use Illuminate\Http\Request;
	use JWTAuth;
	use Auth;
	use Tymon\JWTAuth\Exceptions\JWTException;
	use App\Repos\UserRepo as Users;

	class Accounts extends Controller {

		use RequestUser;

		protected $users;

		public function __construct(Users $users) {
			$this->users = $users;
			$this->middleware('jwt.auth', ['only' => ['changePassword']]);
		}

		private function customClaims($user, $request, $vendor = false) {

			$claims = [
				'vendor_id' => ($vendor) ? $user->vendors[0]->id : null,
				'device' => ($request->header('Request-device')) ? $request->header('Request-device') : 'not-set'
			];

			return $claims;
		}

		/**
		* Authenticate user
		* @param Illuminate\Http\Request $request
		**/
		public function auth(Request $request) {

			$this->validate($request, [
				'email' => 'required|email',
				'password' => 'required'
			]);

			// grab credentials from the request
	        $credentials = $request->only('email', 'password');

	        try {

	        	if(!Auth::once($credentials)) {
	        		return response()->json(['error' => 'Incorrect email or password'], 403);	
	       		}

	       		$vendorLogin = $request->input('vendor', false);

	        	$user = Auth::user();

	        	if($vendorLogin)
	        	{
	        		if(!$user->vendors) {	
	        			return response()->json(['error' => 'Incorrect email or password'], 403);
	        		}

	        		$vendor = $user->vendors[0]->transform();
	        		$token = JWTAuth::fromUser($user, $this->customClaims($user, $request, $vendorLogin));
	        	}
	        	else {
	        		$token = JWTAuth::fromUser($user, $this->customClaims($user, $request, $vendorLogin));
	        	}

	        } catch (JWTException $e) {
	            // something went wrong whilst attempting to encode the token
	            return response()->json(['error' => 'could_not_create_token'], 500);
	        }

	        // all good so return the token
	        return response()->json(compact('token','user','vendor'));
		}

		/**
		* Create a new user account
		**/
		public function create(Request $request) {
			//validate request
			$this->validate($request, [
				'email' => 'required|email|unique:users,email',
				'password' => 'required|min:6'
			]);

			//user credentials
			$credentials = $request->only('name','email','password');
			$credentials['password'] = \Hash::make($credentials['password']);

			//create user
			$user = $this->users->create($credentials);

			/*
			* fire an event which will send analytics data for storage and trigger email sending
			*/
			
			try {
				//create token from user object
	            $token = JWTAuth::fromUser($user, $this->customClaims($user, $request, false));
	        } catch (JWTException $e) {
	            // something went wrong whilst attempting to encode the token
	            return response()->json(['error' => 'could not create_token'], 500);
	        }

	        // all good so return the token
	        return response()->json(compact('token', 'user'));
		}

		public function changePassword(Request $request) {
			//validate request
			$this->validate($request, [
				'current' => 'required',
				'update' => 'required|min:6'
			]);

			//user
			$user = $this->requestUser();

			//check current password
			if(!\Hash::check($request->input('current'), $user->password)) {
				return response()->json(['current' => ['Incorrect password']], 422);
			}

			$this->users->update(['password' => \Hash::make($request->input('update'))], $user->id);

			return response()->json(['message'=>"Password change successful"], 200);
		}

		/*
		* Logs user out
		**/
		public function logout() {

			$token = JWTAuth::getToken();
			JWTAuth::invalidate($token);

			return response()->json(['message'=>"Logout successful"], 200);
		}
	}