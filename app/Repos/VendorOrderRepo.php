<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;
	use App\Models\VendorOrderItem;

	class VendorOrderRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\VendorOrder";
	    }

	    /**
	     * Specify Presenter class name
	     *
	     * @return string
	    */
	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\VendorOrderPresenter";
	    }

	    private function generateOrderno() {

	    	$timestamp = date("Ymdhia");
	    	$prefix = "CH";

	    	$rand = strtoupper(substr(uniqid(sha1(time())),0,5));

	    	return strtoupper($prefix.$timestamp.$rand);
	  	}

	  	public function make($id, $order_id, $total) {

	  		$this->model->order_id = $order_id;
	  		$this->model->vendor_id = $id;
	  		$this->model->no = $this->generateOrderno();
	  		$this->model->total = $total;

	  		$model = $this->model;
	  		$model->save();

	  		return $model;
	  	}

	  	public function addItems($items) {
	  		
	  		VendorOrderItem::insert($items);
	  	}
	}