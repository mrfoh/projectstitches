<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use App\Events\OrderItemStatusUpdate;
	
	class VendorOrderItem extends Model {

		protected $table = "vendor_order_items";

		protected $fillable = ['vendor_order_id','order_item_id','status'];

		public function order() {
			return $this->belongsTo('\App\Models\VendorOrder', 'vendor_order_id');
		}

		public function item() {
			return $this->belongsTo('\App\Models\OrderItem', 'order_item_id');
		}

		protected static function boot() 
		{
			parent::boot();

			static::updated(function($item) {
				if($item->status != "pending")
					event(new OrderItemStatusUpdate($item));
			});
		}
	}