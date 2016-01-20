<?php
	namespace App\Repos;

	use Prettus\Repository\Eloquent\BaseRepository;

	class UserRepo extends BaseRepository {

		/**
	     * Specify Model class name
	     *
	     * @return string
	    */
	    public function model()
	    {
	        return "App\\Models\\User";
	    }
	}