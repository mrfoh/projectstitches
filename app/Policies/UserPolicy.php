<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Http\Api\Traits\RequestUser;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization, RequestUser;

    protected $request;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    public function update(User $user) {
       $requestUser = $this->requestUser();
       if($user->id != $requestUser->id) {
        return false;
       }

       return true;
    }
}
