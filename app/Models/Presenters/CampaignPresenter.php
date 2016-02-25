<?php
	
	namespace App\Models\Presenters;

	use App\Models\Transformers\CampaignTransformer;
	use Prettus\Repository\Presenter\FractalPresenter;

	/**
	 * Class CampaignPresenter
	 *
	 * @package namespace App\Models\Presenters;
	 */
	class CampaignPresenter extends FractalPresenter
	{
	    /**
	     * Transformer
	     *
	     * @return \League\Fractal\TransformerAbstract
	     */
	    public function getTransformer()
	    {
	        return new CampaignTransformer();
	    }
	}
