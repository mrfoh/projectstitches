<?php
	
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use Illuminate\Http\Request;
	use App\Repos\ProductRepo;
	use App\Repos\VendorRepo;
	use App\Repos\Traits\Pageable;

	class Search extends Controller {

		use RequestUser, Pageable;

		protected $vendors;

		protected $products;

		public function __construct(ProductRepo $products, VendorRepo $vendors) {
			$this->products = $products;
			$this->vendors = $vendors;
		}

		public function query(Request $request) {

			$q = $request->input('query');

			$page = $request->input('page', 1);

			$perPage = $request->input('per_page', 30);

			$section = $request->input('section', 'products');

			$vendor = $request->input('vendor', NULL);

			$sort_by = $request->input('sort_by', 'price');

			$sort_order = $request->input('sort_order','desc');

			if($section == "products") {
				$models = $this->products->scopeQuery(function ($query) use ($q, $sort_by, $sort_order, $vendor) {

					if(is_null($vendor)) {
						return $query->where('name','like', '%'.$q.'%')
								 ->orderBy($sort_by, $sort_order);
					}
					else {
						return $query->where('name','like', '%'.$q.'%')
								 ->where('vendor_id','=', $vendor)
								 ->orderBy($sort_by, $sort_order);	
					}
				})->all();
			}
			elseif($section == "vendors") {
				$models = $this->vendors->scopeQuery(function ($query) use ($q, $sort_by, $sort_order) {
					return $query->where('name','like', '%'.$q.'%');
				})->all();
			}

			return $this->paginateData($models['data'], count($models['data']), $page, $perPage);
		}
	}