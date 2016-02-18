<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;
	use App\Repos\VendorOrderRepo;
	use App\Models\User;
	use App\Models\OrderItem;
	use Illuminate\Foundation\Bus\DispatchesJobs;
	use App\Jobs\CreateVendorOrder;

	class OrderRepo extends BaseRepository {

		use DispatchesJobs;

		protected $vendorOrderRepo;
		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\Order";
	    }

	    /**
	     * Specify Presenter class name
	     *
	     * @return string
	    */
	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\OrderPresenter";
	    }

	    private function generateOrderno() {

	    	$timestamp = date("Ymdhia");
	    	$prefix = "PR";

	    	$rand = strtoupper(substr(uniqid(sha1(time())),0,5));

	    	return strtoupper($prefix.$timestamp.$rand);
	  	}

	  	private function cartTotal($items) {

	  		$total = 0;
	  		foreach($items as $item) {
	  			$total = $total + $item['price'];
	  		}

	  		return $total;
	  	}

	    public function make($items, User $user, $paid, $method, $address_id) {
	    	
	    	$this->model->order_no = $this->generateOrderno();
	    	$this->model->user_id = $user->id;
	    	$this->model->user_address_id = $address_id;
	    	$this->model->total = $this->cartTotal($items);
	    	$this->model->paid = $paid;
	    	$this->model->method = $method;

	    	$model = $this->model;
	    	$model->save();

	    	$model->items()->createMany($items);

	    	$this->dispatch(new CreateVendorOrder($model));

	    	return $this->parserResult($model);
	    }
	}