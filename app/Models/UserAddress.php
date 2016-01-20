<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class UserAddress extends Model {

		protected $table = "user_addresses";

		public function user() {
			return $this->belongsTo('\App\Models\Users');
		}
	}