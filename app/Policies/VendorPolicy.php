<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Vendor;
use App\Models\User;

class VendorPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Vendor $vendor) {
        //authorized user id
        $authorizedUsers = [];
        //get vendor users
        $vendorUsers = $vendor->users;

        foreach($vendorUsers as $vendorUser) {
            $authorizedUsers[] = $vendorUser->id;
        }

        return in_array($user->id, $authorizedUsers);
    }
}
