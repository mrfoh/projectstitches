<?php
	
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;

	class CampaignRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\Campaign";
	    }

	    /**
	     * Specify Presenter class name
	     *
	     * @return string
	    */
	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\CampaignPresenter";
	    }

	    public function active() {

	    	$models = $this->model->where('active','=',1)->orderBy('created_at','desc')->get();

	    	return $this->parserResult($models);
	    }
	}