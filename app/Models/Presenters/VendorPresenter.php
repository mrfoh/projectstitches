<?php

namespace App\Models\Presenters;

use App\Models\Transformers\VendorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ImagePresenter
 *
 * @package namespace App\Models\Presenters;
 */
class VendorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VendorTransformer();
    }
}
