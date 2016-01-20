<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Prettus\Repository\Contracts\Transformable;

	class Order extends Model implements Transformable {

		public function vendor() {
			return $this->belongsTo('\App\Models\Vendor');
		}

		public function user() {
			return $this->belongsTo('\App\Models\User');
		}

		public function items() {
			return $this->hasMany('\App\Models\OrderItem');
		}

		public function transform() {

			return [
			];
		}
	}