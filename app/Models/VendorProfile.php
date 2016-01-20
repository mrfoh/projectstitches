<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Prettus\Repository\Contracts\Transformable;

	class VendorProfile extends Model implements Transformable {

		protected $table = "vendor_profiles";

		protected $fillable = ['vendor_id','profile_photo','phones','addresses','social'];

		protected $touches = ['vendor'];

		public function vendor() {
			return $this->belongsTo('\App\Models\Vendor');
		}

		public function setPhonesAttribute($value) {
			$this->attributes['phones'] = json_encode($value);
		}

		public function setAddressesAttribute($value) {
			$this->attributes['addresses'] = json_encode($value);
		}

		public function setSocialAttribute($value) {
			$this->attributes['social'] = json_encode($value);
		}

		public function getPhonesAttribute($value) {
			return json_decode($value, true);
		}

		public function getAddressesAttribute($value) {
			return json_decode($value, true);
		}

		public function getSocialAttribute($value) {
			return json_decode($value, true);
		}

		public function transform() {
			return [
				'profile_photo' => $this->profile_photo,
				'phones' => $this->phones,
				'addresses' => $this->addresses,
				'social' => $this->social
			];
		}
	}