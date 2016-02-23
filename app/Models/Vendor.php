<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Vendor extends Model {

		protected $fillable = ['name','description','segment','logo'];

		public function profile() {
			return $this->hasOne('\App\Models\VendorProfile');
		}

		public function users() {
			return $this->belongsToMany('\App\Models\User', 'vendor_users');
		}

		public function orders() {
			return $this->hasMany('\App\Models\Order');
		}

		public function products() {
			return $this->hasMany('\App\Models\Product');
		}
	}