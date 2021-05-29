<?php
require_once "functions.php";
require_once "DB.php";

class Bill extends DB{

	public function __construct(){
		parent::__construct();
	}

	public function addItem(){
		
	}

	public function getItem($id){
		$bill = $this->select("bill", "*", "bill_id='$id'");
		if(count($bill) == 0) return null;
		
	}
}
?>