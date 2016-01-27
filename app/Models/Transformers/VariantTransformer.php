<?php

namespace App\Models\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Variant;

/**
 * Class VariantTransformer
 * @package namespace App\Models\Transformers;
 */
class VariantTransformer extends TransformerAbstract
{

    /**
     * Transform the \Variant entity
     * @param \Variant $model
     *
     * @return array
     */
    public function transform(Variant $model)
    {
        return [
            'id'         => (int) $model->id,
            'options' => $model->options,
            'qty' => (int) $model->qty,
            'track' => (bool) $model->track,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
