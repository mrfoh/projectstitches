<?php

namespace App\Models\Presenters;

use App\Models\Transformers\VariantTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class VariantPresenter
 *
 * @package namespace App\Models\Presenters;
 */
class VariantPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VariantTransformer();
    }
}
