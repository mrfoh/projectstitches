<?php
	
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class CartItem extends Model {

		protected $table = "cart_items";

		/**
	     * All of the relationships to be touched.
	     *
	     * @var array
	     */
	    protected $touches = ['cart'];

		protected $fillable = ['cart_id','product_id','qty'];

		public function cart() {
			return $this->belongsTo('\App\Models\Cart');
		}

		public function product() {
			return $this->belongsTo('\App\Models\Product');
		}
	}