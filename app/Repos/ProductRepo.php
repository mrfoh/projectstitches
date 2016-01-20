<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;
	use App\Models\Image;
	use App\Models\Product;

	class ProductRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\Product";
	    }

	    public function presenter()
	    {
	        return "App\\Models\\Presenters\\ProductPresenter";
	    }

	    public function attachImages($id, Array $media_ids) {
	    	$product = $this->model->find($id);
	    	$media = Image::whereIn('id', $media_ids)->get();

	    	foreach($media as $image) {
	    		$product->images()->save($image);
	    	}

	    	return true;
	    }

	    public function attachImage($id, $media_id) {
	    	$product = $this->model->find($id);
	    	$media = Image::find($media_id);

	    	$product->images()->save($media);

	    	return true;
	    }

	    /**
	    * Retrieve products in category
	    * @param integer $id
	    * Category id
	    * @param string $sortBy
	    * Field to sort by
	    * @param string $sortOrder
	    * Order in which to sort (asc - ascending | desc - descending)
	    **/
	    public function inCategory($id, $sortBy, $sortOrder) {

	    	$models = $this->model->where('category_id','=',$id)
	    						  ->orderBy($sortBy, $sortOrder)
	    						  ->get();

	    	$this->resetModel();

	    	 return $this->parserResult($models);
	    }
	}