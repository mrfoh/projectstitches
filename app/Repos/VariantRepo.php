<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;
	use App\Models\Image;
	use App\Models\Product;

	class VariantRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\Variant";
	    }

	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\VariantPresenter";
	    }
	}