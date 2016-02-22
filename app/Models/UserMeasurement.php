<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Prettus\Repository\Contracts\Transformable;

	class UserMeasurement extends Model implements Transformable {

		protected $table = "user_measurements";

		protected $fillable = ['user_id','name','measurements'];

		public function setMeasurementsAttribute($value) {
			$this->attributes['measurements'] = json_encode($value);
		}

		public function getMeasurementsAttribute($value) {
			return json_decode($value, true);
		}

		public function user() {
			return $this->belongsTo('\App\Models\User', 'user_id');
		}

		public function transform() {
			return [
				'id' => $this->id,
				'name' => $this->name,
				'measurements' => $this->measurements,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			];
		}
	}