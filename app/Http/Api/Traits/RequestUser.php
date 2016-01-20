<?php
	namespace App\Http\Api\Traits;

	use JWTAuth;

	trait RequestUser {

		public function requestUser() {
			$user = JWTAuth::parseToken()->authenticate();

			return $user;
		}
	} 