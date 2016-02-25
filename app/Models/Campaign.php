<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Campaign extends Model
	{
		protected $fillable = ['title','link','active'];
		
	    public function images() {
			return $this->morphMany('\App\Models\Image', 'imageable');
		}
	}
