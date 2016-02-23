<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use App\Models\Traits\HashId;

	class Product extends Model {

		protected $fillable = ['name','vendor_id', 'category_id', 'description', 'price', 'tailored', 'publish'];

	    public function setPriceAttribute($value)
	    {
	        $this->attributes['price'] = (float) $value;
	    }

		public function images() {
			return $this->morphMany('\App\Models\Image', 'imageable');
		}
		
		public function category() {
			return $this->belongsTo('\App\Models\Category');
		}

		public function vendor() {
			return $this->belongsTo('\App\Models\Vendor', 'vendor_id');
		}

		public function variants() {
			return $this->hasMany('\App\Models\Variant');
		}

		public function items() {
			return $this->belongsToMany('\App\Models\OrderItem');
		}
	}