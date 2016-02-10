<?php

namespace App\Models\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Image;

/**
 * Class ImageTransformer
 * @package namespace App\Models\Transformers;
 */
class ImageTransformer extends TransformerAbstract
{

    /**
     * Transform the \Image entity
     * @param \Image $model
     *
     * @return array
     */
    public function transform(Image $model)
    {
        return [
            'id'         => $model->id,
            'path'       => config('app.url')."/".$model->path,
            'size'       => $model->size,
            'featured'    => (bool) $model->featured,
            'uploaded_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
