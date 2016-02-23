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

	    private function generateOrderno($id) {

	    	$timestamp = date("Ymdhia");
	    	$prefix = "CH";

	    	$rand = strtoupper(substr(uniqid(sha1($id)),0,5));

	    	return strtoupper($prefix.$timestamp.$rand);
	  	}

	  	public function makeMany($orders) {

	  		foreach($orders as $order) {
	  			$order['no'] = $this->generateOrderno($order['vendor_id']);
	  			$data[] = $this->model->create($order);
	  		}

	  		return $data;
	  	}

	  	public function addItems($items) {
	  		
	  		VendorOrderItem::insert($items);
	  	}
	}