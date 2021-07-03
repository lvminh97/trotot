<?php
require_once "functions.php";
require_once "DB.php";

class Transfer extends DB{

	public function __construct(){
		parent::__construct();
	}

	// Status: pending, approve, reject

	public function addItem($data){
		$data['transfer_id'] = "null";
		return $this->insert("transfer", $data);
	}

	public function getItem($id){
		$tmp = $this->select("transfer", "*", "transfer_id='$id'");
		if(count($tmp) == 0) return null;
		return $tmp[0];
	}

	public function getReceiveList($host_id){
		return $this->select("transfer", "*", "host_receive='$host_id' AND status='pending'", "transfer_id ASC");
	}

	public function updateStatus($transfer_id, $data){
		return $this->update("transfer", $data, "transfer_id='$transfer_id'");
	}
}
?>