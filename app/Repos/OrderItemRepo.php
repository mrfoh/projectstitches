<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;

	class OrderItemRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\OrderItem";
	    }

	    /**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\OrderItemPresenter";
	    }
	}