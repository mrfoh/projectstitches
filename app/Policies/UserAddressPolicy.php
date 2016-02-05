<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Http\Api\Traits\RequestUser;
use App\Models\User;
use App\Models\UserAddress;

class UserAddressPolicy
{
    use HandlesAuthorization, RequestUser;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function read(UserAddress $address) {
        $user = $this->requestUser();
        if($adddress->user_id != $user->id) {
            return false;
        }

        return true;
    }

    public function update(User $user, UserAddress $address) {
        if($user->id != $address->user_id) {
            return false;
        }

        return true;
    }

    public function delete(User $user, UserAddress $address) {
        if($user->id != $address->user_id) {
            return false;
        }

        return true;
    }
}
