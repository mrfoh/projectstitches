<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone', 'gcm_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addresses() {
        return $this->hasMany('\App\Model\UserAddress');
    }

    public function vendors() {
        return $this->belongsToMany('\App\Models\Vendor', 'vendor_users', 'user_id', 'vendor_id');
    }

    public function isVendorUser($id) {

        foreach($this->vendors as $vendor) {
            if($vendor->id == $id) {
                return true;
            }

            return false;
        }
    }
}
