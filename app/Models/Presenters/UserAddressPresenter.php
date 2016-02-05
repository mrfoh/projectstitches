<?php

namespace App\Models\Presenters;

use App\Models\Transformers\UserAddressTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserAddresPresenterPresenter
 *
 * @package namespace App\Models\Presenters;
 */
class UserAddressPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserAddressTransformer();
    }
}
