<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;

	class ImageRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\Image";
	    }

	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\ImagePresenter";
	    }
	}