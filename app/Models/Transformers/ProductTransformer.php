<?php
	namespace App\Models\Transformers;

	use League\Fractal\TransformerAbstract;
	use App\Models\Product;
	use App\Models\Transformers\ImageTransformer;
	use App\Models\Transformers\VariantTransformer;

	class ProductTransformer extends TransformerAbstract {

		/**
	     * List of resources to include by default
	     *
	     * @var array
	     */
	    protected $defaultIncludes = ['images', 'variants'];

	    /**
	     * Include Images
	     * @param App\Models\Product $product
	     * @return League\Fractal\ItemCollection
	     */
	    public function includeImages(Product $product)
	    {
	        $images = $product->images;

	        return $this->collection($images, new ImageTransformer());
	    }

	     /**
	     * Include Variants
	     * @param App\Models\Product $product
	     * @return League\Fractal\ItemCollection
	     */
	    public function includeVariants(Product $product)
	    {
	    	$variants = $product->variants;

	    	return $this->collection($variants, new VariantTransformer());
	    }

	    /**
	     * Transform model collection
	     * @param App\Models\Product $product
	     * @return League\Fractal\ItemCollection
	     */
		public function transform(Product $product)
	    {
	        return 
	        [
	        	'id' => $product->id,
	        	'name' => $product->name,
	        	'description' => $product->description,
	        	'price' => (int) $product->price,
	        	'category' => [
	        		'id' => $product->category->id,
	        		'segment' => $product->category->segment,
	        		'name' => $product->category->name,
	        		'slug' => $product->category->slug
	        	],
	        	'vendor' => [
	        		'id' => $product->vendor->id,
	        		'name' => $product->vendor->name,
	        	],
	        	'tailored' => (bool) $product->tailored,
	        	'publish' => (bool) $product->publish,
	        	'created_at' => $product->created_at,
	        	'updated_at' => $product->updated_at  
	        ];
	    }
	}