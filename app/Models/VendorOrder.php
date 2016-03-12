<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use App\Events\VendorOrderCreated;
	use App\Events\OrderStatusUpdate;

	class VendorOrder extends Model {

		protected $table = "vendor_orders";

		protected $fillable = ['vendor_id','order_id','no','total','status'];

		protected $with = ['items','order'];

		public function getCreatedAtAttribute($value)
	    {
	        $value = date('U', strtotime($value));
	        return $value * 1000;
	    }

		public function vendor() {
			return $this->belongsTo('\App\Models\Vendor', 'vendor_id');
		}

		public function order() {
			return $this->belongsTo('\App\Models\Order', 'order_id');
		}

		public function items() {
			return $this->hasMany('\App\Models\VendorOrderItem', 'vendor_order_id');
		}

		protected static function boot() 
		{
			parent::boot();

			static::created(function($order) {
				event(new VendorOrderCreated($order));
			});

			static::updated(function($order) {
				if($order->status != "pending")
					event(new OrderStatusUpdate($order));
			});
		}
	}