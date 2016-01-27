<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Variant extends Model {

	    protected $fillable = ['product_id','name','value','parent_id','price','qty','track'];

	    protected $touches = ['product'];

	    public function setTrackAttribute($value) {
	    	$this->attributes['track'] = (int) $value;
	    }

	    public function product() {
	    	return $this->belongsTo('\App\Models\Product');
	    }

	    public function children() {
	    	return $this->hasMany('\App\Models\Variant','parent_id');
	    }

	    public function parent() {
	    	return $this->belongsTo('\App\Models\Variant','parent_id');
	    }
	}
