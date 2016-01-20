<?php
	namespace App\Repos\Traits;

	use Illuminate\Pagination\LengthAwarePaginator;

	trait Pageable {

		/**
		* @param Array $data
		* data to be paginated
		* @param integer $total
		* count of items in $data
		* @param integer $page
		* current page
		* @param integer $perPage
		* item per per page
		* @access public
		**/
		public function paginateData(Array $data, $total, $page, $perPage) {
			//calculate offset
			$offset = ($page * $perPage) - $perPage;
			//process data
			$processedData = array_slice($data, $offset, $perPage, true);
			//return paginated items
			return new LengthAwarePaginator($processedData, $total, $perPage, $page);
		}
	}