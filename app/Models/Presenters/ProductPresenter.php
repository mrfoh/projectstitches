<?php
	namespace App\Models\Presenters;

	use Prettus\Repository\Presenter\FractalPresenter;
	use App\Models\Transformers\ProductTransformer;

	class ProductPresenter extends FractalPresenter {

	    /**
	     * Prepare data to present
	     *
	     * @return \League\Fractal\TransformerAbstract
	     */
	    public function getTransformer()
	    {
	        return new ProductTransformer();
	    }
	}