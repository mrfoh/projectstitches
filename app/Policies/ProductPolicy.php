<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    use HandlesAuthorization;

    protected $request;
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function isAllowed(User $user, Product $product) {
       $vendor = $product->vendor;
       $vendorUsers = $vendor->users;

       foreach($vendorUsers as $vendorUser) {
            $authorizedUsers[] = $vendorUser->id;
       } 

       return in_array($user->id, $authorizedUsers);
    }

    /**
    * Authorize create of product model
    * @param App\Models\User $user
    **/
    public function create(User $user) {
       $vendorId = $this->request->input('vendor_id');
       return $user->isVendorUser($vendorId);
    }

    /**
    * Authorize update of product model
    * @param App\Models\User $user
    * @param App\Models\Product $product
    **/
    public function update(User $user, Product $product) {
        return $this->isAllowed($user, $product);
    }

    /**
    * Authorize deletion of product model
    * @param App\Models\User $user
    * @param App\Models\Product $product
    **/
    public function delete(User $user, Product $product) {
         return $this->isAllowed($user, $product);
    }
}
