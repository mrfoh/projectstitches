<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Prettus\Repository\Contracts\Transformable;

	class Category extends Model implements Transformable {

		protected $fillable = ['name','slug','parent_id','segment'];

		public function products() {
			return $this->hasMany('\App\Models\Product');
		}

		public function transform() {
			
			return [
				'id' => (int) $this->id,
				'segment' => $this->segment,
				'name' => $this->name,
				'slug' => $this->slug,
				'product_count' => count($this->products),
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			];
		}
	}