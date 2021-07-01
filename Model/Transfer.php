<?php
require_once "functions.php";
require_once "DB.php";

class Transfer extends DB{

	public function __construct(){
		parent::__construct();
	}

	public function addItem($data){
		$data['transfer_id'] = "null";
		return $this->insert("transfer", $data);
	}
}
?>