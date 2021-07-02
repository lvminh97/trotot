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

	public function getPendingList($room_id){
		return $this->select("rent JOIN account", "*", "rent.room_id='$room_id' AND rent.status='pending' AND rent.user_id=account.user_id", "rent.begin_time ASC");
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
		// $tmp = $this->select("rent", "*", "room_id='$room_id' AND (status='renting' OR status IN ('cancel', 'reject', 'prevent')) AND end_time>'$time'");
		$tmp = $this->select("rent", "*", "room_id='$room_id' AND status='renting' AND end_time>'$time'");
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

	public function approveRent($rent_id){
		$resp = $this->update("rent", array('status' => 'renting',
											'begin_time' => date("Y-m-d")),
										"rent_id='$rent_id'");
		$room_id = $this->getItem($rent_id)['room_id'];
		$resp = $resp && 
				$this->update("rent", array('status' => 'deny'),
									"room_id='$room_id' AND status='pending'");
		return $resp;
	}

	public function kickTenant($room_id){
		$rent = $this->select("rent", "rent_id", "room_id='$room_id' AND status='renting'", "begin_time DESC")[0];
		if($rent === null) return false;
		$rent_id = $rent['rent_id'];
		return $this->update("rent", array('status' => 'reject'), "rent_id='$rent_id'");
	}
}
?>