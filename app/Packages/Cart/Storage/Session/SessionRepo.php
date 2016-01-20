<?php
	
	namespace App\Packages\Cart\Storage\Session;

	use App\Packages\Cart\Storage\StorageInterface;
	use Illuminate\Session\Store as Session;

	class SessionRepo implements StorageInterface {

		protected $session;

		protected $name;

		public function __construct(Session $session) {
			$this->session = $session;
		}

		public function setIdentifier($identifier) {
			$this->name = $identifier;
		}

		public function get() {
			return $this->session->get($this->name);
		}

		public function has($key) {
			return $this->session->has($key);
		}

		public function insert($data) {
			$this->session->push($name, $data);
		}

		public function put($key, $data) {
			return $this->session->put($key, $data);
		}

		public function update($key, $quantity) {

		}

		public function delete($key) {

		}

		public function destroy() {
			$this->session->put($this->name, []);
		}
	}