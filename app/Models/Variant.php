<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Variant extends Model {

	    protected $fillable = ['product_id','options','price','qty','track'];

	    protected $touches = ['product'];

	    public function setOptionsAttribute($value) {
	        $this->attributes['options'] = json_encode($value);
	    }

	    public function getOptionsAttribute($value) {
	    	return json_decode($value, true);
	    }

	    public function product() {
	    	return $this->belongsTo('\App\Models\Product');
	    }

	}
