<?php
require_once "functions.php";
require_once "DB.php";

class Bill extends DB{

	public function __construct(){
		parent::__construct();
	}

	public function addItem($data){
		$res = true;
		$res = $res && $this->insert("bill", array('bill_id' => 'null',
													'room_id' => $data['room_id'],
													'time' => $data['time'],
													'status' => "pending"));
		if($res === true) $bill_id = $this->getBillId($data['room_id'], $data['time']);
		else return false;							
		for($i = 0; $i < count($data['titleList']); $i++){
			$res = $res && $this->insert("bill_detail", array('bill_id' => $bill_id,
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
						'room_id' => $bill[0]['room_id'],
						'time' => $bill[0]['time'],
						'status' => $bill[0]['status']);
		for($i = 0; $i < count($bill); $i++){
			unset($bill[$i]['bill_id']);
			unset($bill[$i]['room_id']);
			unset($bill[$i]['time']);
			unset($bill[$i]['status']);
		}						
		$resp['bill'] = $bill;
		return $resp;	
	}

	public function updateItem($bill_id, $data){
		return $this->update("bill", $data, "bill_id='$bill_id'");
	}

	public function deleteItem($bill_id){
		return $this->delete("bill_detail", "bill_id='$bill_id'") && $this->delete("bill", "bill_id='$bill_id'");
	}

	public function getBillId($room_id, $time){
		$tmp = $this->select("bill", "bill_id", "room_id='$room_id' AND time='$time'");
		if(count($tmp) > 0) return $tmp[0]['bill_id'];
		return null;
	}

	public function getListByHostAndTime($user_id, $time){
		$tmp = $this->select("bill JOIN bill_detail", "*",
								"bill.bill_id=bill_detail.bill_id AND bill.room_id IN (SELECT room_id FROM room WHERE host='$user_id') AND time LIKE '$time%'",
								"bill.room_id ASC");
		$resp = array();
		foreach($tmp as $bill){
			if(!isset($resp[$bill['bill_id']])){
				$resp[$bill['bill_id']] = array('bill_id' => $bill['bill_id'],
											'room_id' => $bill['room_id'],
											'status' => $bill['status'],
											'bill' => array());
			}
			$resp[$bill['bill_id']]['bill'][] = array('title' => $bill['title'],
												'price' => $bill['price'],
												'number' => $bill['number']);
		}
		return $resp;
	}

	public function getListByRoomAndTime($room_id, $year, $month = "all"){
		if($month == "all"){
			return $this->select("bill JOIN bill_detail", "*",
								"bill.bill_id=bill_detail.bill_id AND bill.room_id='$room_id' AND bill.time LIKE '{$year}-%'",
								"bill.room_id ASC");
		}
		else{
			return $this->select("bill JOIN bill_detail", "*",
								"bill.bill_id=bill_detail.bill_id AND bill.room_id='$room_id' AND bill.time LIKE '{$year}-{$month}-%'",
								"bill.room_id ASC");
		}
	}
}
?>