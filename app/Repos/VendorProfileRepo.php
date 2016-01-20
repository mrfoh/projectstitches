<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;
	use App\Models\User;

	class VendorProfileRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\VendorProfile";
	    }

	    public function presenter()
	    {
	        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";
	    }
	}