<?php

namespace App\Models\Presenters;

use App\Models\Transformers\OrderItemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ImagePresenter
 *
 * @package namespace App\Models\Presenters;
 */
class OrderItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrderItemTransformer();
    }
}
