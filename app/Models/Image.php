<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;

	class Image extends Model{

		use SoftDeletes;

		protected $fillable = ['user_id','path','mime','size'];
		/**
	     * Get all of the owning imageable models.
	     */
	    public function imageable()
	    {
	        return $this->morphTo();
	    }

	    public function user() {
	    	return $this->belongsTo('\App\Models\User');
	    }
	}