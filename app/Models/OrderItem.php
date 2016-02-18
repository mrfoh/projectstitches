<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class OrderItem extends Model {

		protected $table = "order_items";

		protected $fillable = ['order_id','product_id','vendor_id','qty','variant_id','measurement_id'];

		public function order() {
			return $this->belongsTo('\App\Models\Order', 'order_id');
		}

		public function product() {
			return $this->belongsTo('App\Models\Product', 'product_id');
		}

		public function vendor() {
			return $this->belongsTo('App\Models\Vendor', 'vendor_id');
		}

		public function variant() {
			return $this->belongsTo('App\Models\Variant', 'variant_id');
		}

		public function vendoritem() {
			return $this->hasOne('\App\Models\VendorOrderItem', 'order_item_id');
		}
	}