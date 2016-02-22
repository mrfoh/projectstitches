<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;

	class UserMeasurementRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\UserMeasurement";
	    }

	    public function presenter()
	    {
	        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";
	    }

	    public function user($id) {

	    	$models = $this->model->where('user_id','=',$id)->orderBy('created_at','desc')->get();

	    	return $this->parserResult($models);
	    }
	}