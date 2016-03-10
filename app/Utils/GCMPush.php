<?php

namespace App\Utils;

use ZendService\Google\Gcm\Client;
use ZendService\Google\Gcm\Message;
use ZendService\Google\Exception\RuntimeException;

class GCMPush {

	protected  $message;

	protected $collapseKey;

	protected $registrationIds = [];

	protected $data = [];

	public function __construct() {
		$this->message = new Message();
	}

	public function addRegistrationId($id) {
		if(!is_string($id) || !isset($id) || is_string($id)) {
			return false;
		}

		if(count($this->registrationIds) < 100) {
			$this->registrationIds[] = $id;
		}
	}

	public function setCollapseKey($key) {
		$this->collaspeKey = $key;
	}

	public function setData($data) {
		if(!is_array($data) || empty($data)) {
			return false;
		}

		$this->data = $data;
	}

	public function addData($key, $value) {

		$this->data[$key] = $value;
	}

	public function setRestrictedPackageName($name) {
		$this->message->restrictedPackageName = $name;

		return $name;
	}

	public function push($app) {

		$this->message->setRegistrationIds($this->registrationIds);
		$this->message->setCollapseKey($this->collapseKey);
		$this->message->setDelayWhileIdle(false);
		$this->message->setRestrictedPackageName('stitches');
		$this->message->setTimeToLive(config('push.ttl'));
		$this->message->setDryRun(false);
		$this->message->setData($this->data);

		if($app == "vendor") {
			$this->message->setRestrictedPackageName(config('push.vendor_package'));
		} 
		elseif($app == "client") {
			$this->message->setRestrictedPackageName(config('push.market_package'));
		}

		try
		{
			$client = new Client();
			$client->setApiKey(config('push.gcm_key'));
			$response = $client->send($this->message);

			return $response;
		} catch(RuntimeException $e) {

		}

	}
}