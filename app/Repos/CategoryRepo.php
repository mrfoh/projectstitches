<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;

	class CategoryRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\Category";
	    }

	    public function presenter()
	    {
	        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";
	    }
	}