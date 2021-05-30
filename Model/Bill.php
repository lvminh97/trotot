<?php
require_once "functions.php";
require_once "DB.php";

class Bill extends DB{

	public function __construct(){
		parent::__construct();
	}

	public function addItem($data){
		$res = true;
		$res = $res & $this->insert("bill", array('bill_id' => 'null',
													'user_id' => $data['user_id'],
													'room_id' => $data['room_id'],
													'time' => $data['time']));
		if($res === true) $bill_id = $this->getBillId($data['room_id'], $data['time']);
		else return false;								
		for($i = 0; $i < count($data['titleList']); $i++){
			$res = $res & $this->insert("bill_detail", array('bill_id' => $bill_id,
															'title' => $data['titleList'][$i],
															'price' => $data['priceList'][$i],
															'number' => $data['numList'][$i]));
		}
		return $res;
	}

	public function getItem($id){
		$bill = $this->select("bill JOIN bill_detail", "*", "bill.bill_id=bill_detail.bill_id AND bill.bill_id='$id'");
		if(count($bill) == 0) return null;
		$resp = array('bill_id' => $bill[0]['bill_id'],
						'user_id' => $bill[0]['user_id'],
						'room_id' => $bill[0]['room_id'],
						'time' => $bill[0]['time']);
		for($i = 0; $i < count($bill); $i++){
			unset($bill[$i]['bill_id']);
			unset($bill[$i]['user_id']);
			unset($bill[$i]['room_id']);
			unset($bill[$i]['time']);
		}						
		$resp['bill'] = $bill;
		return $resp;	
	}

	public function getBillId($room_id, $time){
		$tmp = $this->select("bill", "bill_id", "room_id='$room_id' AND time='$time'");
		if(count($tmp) > 0) return $tmp[0]['bill_id'];
		return null;
	}
}
?>