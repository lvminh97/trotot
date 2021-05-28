<?php
require_once "functions.php";
require_once "DB.php";

class Rent extends DB{

	public function __construct(){
		parent::__construct();
	}

	// public function getList($cond = "1", $order_by = ""){
	// 	return $this->select("tenant", "*", $cond, $order_by);
	// }

	// public function getItem($room_id){
	// 	$tmp = $this->select("tenant", "*", "room_id='$room_id'");
	// 	if(count($tmp) == 0) return null;
	// 	return $tmp[0];
	// }

	// status: pending, renting, cancel, reject, prevent

	public function addItem($data){
		return $this->insert("tenant", array('user_id' => $data['user_id'],
												'room_id' => $data['room_id'],
												'begin_time' => "0000-00-00",
												'end_time' => "9999-12-31",
												'status' => "pending"));
	}

	public function cancel($user_id, $room_id, $begin_time){
		return $this->update("tenant", array('status' => "cancel"), "user_id='$user_id' AND room_id='$room_id' AND begin_time='$begin_time'");
	}

	public function getRecentItem($user_id, $room_id){
		$tmp = $this->select("tenant", "*", "user_id='$user_id' AND room_id='$room_id'", "begin_time DESC LIMIT 1");
		if(count($tmp) == 1) return $tmp[0];
		else return null;
	}

	// public function updateItem($data, $files){

	// }

	// public function deleteItem($room_id){

	// }

}
?>