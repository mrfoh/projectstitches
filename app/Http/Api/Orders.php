<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;

	class Orders extends Controller {

		public function __construct() {
			//$this->middleware('jwt.auth', ['except' => ['index','get']]);
			$this->middleware('jwt.auth');
		}
		
		public function index() {

		}

		public function get() {

		}
	}