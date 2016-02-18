<?php

namespace App\Models\Presenters;

use App\Models\Transformers\VendorOrderTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class VendorOrderPresenter
 *
 * @package namespace App\Models\Presenters;
 */
class VendorOrderPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VendorOrderTransformer();
    }
}
