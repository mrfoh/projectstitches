<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;

	class Transaction extends Model{

		protected $fillable = ['user_id','ref','amount','verified','status'];
		
	    public function user() {
	    	return $this->belongsTo('\App\Models\User');
	    }
	}