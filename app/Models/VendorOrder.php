<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class VendorOrder extends Model {

		protected $table = "vendor_orders";

		protected $fillable = ['vendor_id','order_id','no','total','status'];

		public function vendor() {
			return $this->belongsTo('\App\Models\Vendor', 'vendor_id');
		}

		public function order() {
			return $this->belongsTo('\App\Models\Order', 'order_id');
		}

		public function items() {
			return $this->hasMany('\App\Models\VendorOrderItem', 'vendor_order_id');
		}
	}