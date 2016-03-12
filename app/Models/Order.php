<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	/*
	* Order Model
	*/
	class Order extends Model {

		protected $fillable = ['order_no', 'user_id', 'user_address_id', 'total', 'paid', 'method'];

		protected $with = ['user', 'address'];

		public function getCreatedAtAttribute($value)
	    {
	        $value = date('U', strtotime($value));
	        return $value * 1000;
	    }

		public function items() {
			return $this->hasMany('\App\Models\OrderItem');
		}

		public function user() {
			return $this->belongsTo('\App\Models\User');
		}

		public function address() {
			return $this->belongsTo('\App\Models\UserAddress', 'user_address_id');
		}
	}