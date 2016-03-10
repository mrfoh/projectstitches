<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;
	use App\Models\User;
	use App\Models\VendorProfile;

	class VendorRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\Vendor";
	    }

	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\VendorPresenter";
	    }

	    private function profileAttrs(array $attrs, $vendor) {

	    	$attributes = [
	    		'vendor_id' => $vendor->id,
	    		'phones' => [
	    			['number' => $attrs['phone']['number'], 'default' => true]
	    		],
	    		//address
	    		'addresses' => [
		    		[
		    			'street' => $attrs['address']['street'],
		    			'city' => $attrs['address']['city'],
		    			'default' => true
		    		]
		    	]
	    	];

	    	return $attributes;
	    }

	    /**
	    * Create a new vendor
	    * @param Array $attrs
	    * @param App\Models\User $user
	    **/
	    public function make(Array $attrs, User $user) {

	    	$this->skipPresenter();
	    	$model = $this->model->create($attrs);
	    	$this->resetModel();

	    	$profileAttrs = $this->profileAttrs($attrs, $model);
	    	$profile = new VendorProfile($profileAttrs);
	    	$model->profile()->save($profile);

	    	$user->vendors()->attach($model->id);
	    	$this->skipPresenter(false);

	    	return $this->parserResult($model);
	    }

	    public function users($id) {

	    	return $this->model->with('users')->find($id);
	    }
	}