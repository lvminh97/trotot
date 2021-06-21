<?php
require_once "functions.php";
require_once "DB.php";

class Rent extends DB{

	public function __construct(){
		parent::__construct();
	}

	// status: 
	// - pending: gui request va cho phe duyet 
	// - renting: duoc chap nhan request va dang thue phong do 
	// - deny: tu choi yeu cau thue phong
	// - return: tra phong
	// - reject: duoi khoi phong
	// - block: cam thue phong 
	// - repair: dang sua chua phong

	public function addItem($data){
		$time = date("Y-m-d H:i:s");
		return $this->insert("rent", array('rent_id' => "null",
											'user_id' => $data['user_id'],
											'room_id' => $data['room_id'],
											'begin_time' => $time,
											'end_time' => "9999-12-31",
											'status' => "pending"));
	}

	public function getItem($rent_id){
		$tmp = $this->select("rent", "*", "rent_id='$rent_id'");
		if(count($tmp) > 0) return $tmp[0];
		else return null;
	}

	public function getRecentItem($user_id, $room_id){
		$tmp = $this->select("rent", "*", "user_id='$user_id' AND room_id='$room_id'", "begin_time DESC LIMIT 1");
		if(count($tmp) == 1) return $tmp[0];
		else return null;
	}

	public function getTenantId($room_id, $time){
		$tmp = $this->select("rent", "*", "room_id='$room_id' AND (status='renting' OR status IN ('cancel', 'reject', 'prevent') AND end_time>'$time'");
		if(count($tmp) == 0) return null;
		return $tmp[0]['user_id'];
	}

	public function updateStatus($rent_id, $status){
		return $this->update("rent", array('status' => "$status"), "rent_id='$rent_id'");
	}

	public function checkRentRequest($user_id, $room_id){
		$tmp = $this->select("rent", "*", "user_id='$user_id' AND room_id='$room_id' AND (status='pending' OR status='prevent')");
		if(count($tmp) > 0) return false;
		return true;
	}

	public function getCurrentStatus($room_id){
		return $this->getTenantId($room_id, date("Y-m-d")) === null ? "available" : "renting";	
	}
}
?>