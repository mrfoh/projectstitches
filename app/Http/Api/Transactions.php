<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use Illuminate\Http\Request;
	use App\Repos\TransactionRepo;

	class Transactions extends Controller {
		use RequestUser;

		protected $repo;

		public function __construct(TransactionRepo $repo) {
			$this->middleware('jwt.auth', ['except' => ['completed']]);
			$this->repo = $repo;
		}

		public function index() {

		}

		public function get($ref) {

		}

		public function create(Request $request) {
			$this->validate($request, [
				'ref' => 'required',
				'amount' => 'required'
			]);

			$user = $this->requestUser();

			$attributes = $request->all();
			$attributes['user_id'] = $user->id;

			$transaction = $this->repo->create($attributes);

			return $transaction;
		}

		public function update(Request $request, $reference) {

			$transaction = $this->repo->skipPresenter()->byReference($reference);

			$attributes = $request->all();

			$update = $this->repo->skipPresenter(false)->update($attributes, $transaction->id);

			return $update;
		}

		public function completed(Request $request) {

			$reference = $request->input('trxref');
			$update = NULL;

			if($reference) {

				$transaction = $this->repo->skipPresenter()->byReference($reference);

				$update = $this->repo->update(['status'=>"successful"], $transaction->id);
			}

			return view('transactioncomplete', ['transaction' => $update]);
		}
	}