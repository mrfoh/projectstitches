<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Prettus\Repository\Contracts\Transformable;

	class Vendor extends Model implements Transformable {

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

		public function transform() {
			
			return [
				'id' => $this->id,
				'name' => $this->name,
				'logo' => $this->logo,
				'description' => $this->description,
				'segment' => $this->segment,
				'profile' => ($this->profile) ? [
					'profile_photo' => $this->profile->profile_photo,
					'phones' => $this->profile->phones,
					'addresses' => $this->profile->addresses,
					'facebook' => $this->profile->facebook,
					'twitter' => $this->profile->twitter,
					'instagram' => $this->profile->instagram
				] : null,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			];
		}
	}