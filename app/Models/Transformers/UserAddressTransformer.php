<?php

namespace App\Models\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\UserAddress;

/**
 * Class UserAddresPresenterTransformer
 * @package namespace App\Models\Transformers;
 */
class UserAddressTransformer extends TransformerAbstract
{

    /**
     * Transform the \UserAddresPresenter entity
     * @param \UserAddresPresenter $model
     *
     * @return array
     */
    public function transform(UserAddress $model)
    {
        return [
            'id'         => (int) $model->id,
            'user_id'   => $model->user_id,
            'name' => $model->name,
            'contact_name' => $model->contact_name,
            'contact_phone' => $model->contact_phone,
            'street' => $model->street,
            'city' => $model->city,
            'is_default' => (bool) $model->is_default,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
