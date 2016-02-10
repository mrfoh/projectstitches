<?php
	namespace App\Models\Presenters;

	use Prettus\Repository\Presenter\FractalPresenter;
	use App\Models\Transformers\TransactionTransformer;

	class TransactionPresenter extends FractalPresenter {

	    /**
	     * Prepare data to present
	     *
	     * @return \League\Fractal\TransformerAbstract
	     */
	    public function getTransformer()
	    {
	        return new TransactionTransformer();
	    }
	}