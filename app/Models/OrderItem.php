<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Prettus\Repository\Contracts\Transformable;

	class OrderItem extends Model implements Transformable {

		protected $table = "order_items";

		public function product() {
			return $this->hasOne('\App\Models\Product');
		}
	}