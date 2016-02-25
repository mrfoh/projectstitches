<?php

    namespace App\Models\Transformers;

    use League\Fractal\TransformerAbstract;
    use App\Models\Transformers\ImageTransformer;
    use App\Models\Campaign;

    /**
     * Class ImageTransformer
     * @package namespace App\Models\Transformers;
     */
    class CampaignTransformer extends TransformerAbstract
    {

        /**
         * List of resources to include by default
         *
         * @var array
         */
        protected $defaultIncludes = ['images'];

        /**
         * Include Images
         * @param App\Models\Product $product
         * @return League\Fractal\ItemCollection
         */
        public function includeImages(Campaign $campaign)
        {
            $images = $campaign->images;

            return $this->collection($images, new ImageTransformer());
        }

        /**
         * Transform the \Image entity
         * @param \Image $model
         *
         * @return array
         */
        public function transform(Campaign $model)
        {
            return [
                'id'         => $model->id,
                'title' => $model->title,
                'link' => $model->link,
                'active' => (bool) $model->active,
                'uploaded_at' => $model->created_at,
                'updated_at' => $model->updated_at
            ];
        }
    }
