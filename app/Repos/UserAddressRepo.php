<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;

	class UserAddressRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\UserAddress";
	    }

	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\UserAddressPresenter";
	    }

	    public function makeDefault($id, $user_id) {

	    	$addresses = [];
	    	$models = $this->model->where('user_id','=',$user_id)->get();
	    	foreach ($models as $model) {
	    		if($model->id != $id)
	    			$addresses[] = $model->id;
	    	}

	    	$this->model->whereIn('id',$addresses)->update(['is_default'=>false]);

	    	return $this->update(['is_default'=>true], $id);
	    }
	}