<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;

	class TransactionRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\Transaction";
	    }

	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\TransactionPresenter";
	    }

	    public function byReference($ref) {

	    	$models = $this->model->where('ref','=', $ref)->get();

	    	return $this->parserResult($models[0]);
	    }
	}