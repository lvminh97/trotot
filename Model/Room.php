<?php
require_once "functions.php";
require_once "DB.php";

class Room extends DB{

	public function __construct(){
		parent::__construct();
	}

	public function getList($cond = "1", $order_by = ""){
		return $this->select("room", "*", $cond, $order_by);
	}

	public function getItem($room_id){
		$tmp = $this->select("room", "*", "room_id='$room_id'");
		if(count($tmp) == 0) return null;
		return $tmp[0];
	}

	public function addItem($data, $files){
		$image = "";
		if(isset($files["image"])){
			for($i = 0; $i < count($files["image"]["name"]); $i++){
				if($image != "") $image .= ";";
				$image .= basename($files["image"]["name"][$i]);
				move_uploaded_file($files["image"]["tmp_name"][$i], "./Resource/Images/".basename($files["image"]["name"][$i]));
			}
		}
		return $this->insert("room", array("room_id" => "null",
											"host" => $data['user_id'],
											"name" => $data["name"],
											"images" => $image,
											"price" => $data["price"],
											"area" => $data["area"],
											"loc_number" => $data["number"],
											"loc_alley" => $data["alley"],
											"loc_street" => $data["street"],
											"loc_subdistrict" => $data["subdistrict"],
											"loc_district" => $data["district"],
											"loc_province" => $data["province"]));
		}

	public function deleteItem($room_id){
		return $this->delete("room", "room_id='$room_id'");
	}

	public function checkHost($room_id, $user_id){
		$tmp = $this->select("room", "*", "host='$user_id' AND room_id='$room_id'");
		return count($tmp) == 1;
	}

	public function getListByUser($user_id){
		return $this->getList("host='$user_id'", "room_id ASC");
	}
}
?>