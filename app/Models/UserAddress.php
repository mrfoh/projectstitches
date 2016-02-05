<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class UserAddress extends Model {

		protected $table = "user_addresses";

		protected $fillable = ['user_id', 'contact_name','contact_phone','name','street','city','is_default'];

		public function user() {
			return $this->belongsTo('\App\Models\Users');
		}
	}