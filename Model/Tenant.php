<?php
require_once "functions.php";
require_once "DB.php";

class Tenant extends DB{

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

	public function rent($data){
		return $this->insert("room", array("room_id" => "null",
											"host" => $data['user_id'],
											"name" => $data["name"],
											"price" => $data["price"],
											"area" => $data["area"],
											"loc_number" => $data["number"],
											"loc_alley" => $data["alley"],
											"loc_street" => $data["street"],
											"loc_subdistrict" => $data["subdistrict"],
											"loc_district" => $data["district"],
											"loc_province" => $data["province"]));
	}

	public function updateItem($data, $files){
		$image = "";
		if(isset($data["image_name"])){
			foreach($data["image_name"] as $img){
				if($image != "") $image .= ";";
				$image .= $img;
			}
		}
		if(isset($files["image"])){
			for($i = 0; $i < count($files["image"]["name"]); $i++){
				if($image != "") $image .= ";";
				$image .= basename($files["image"]["name"][$i]);
				move_uploaded_file($files["image"]["tmp_name"][$i], "./Resource/Images/".basename($files["image"]["name"][$i]));
			}
		}
		return $this->update("room", 
							array("name" => $data["name"],
									"images" => $image,
									"area" => $data["area"],
									"price" => $data["price"],
									"loc_number" => $data["number"],
									"loc_alley" => $data["alley"],
									"loc_street" => $data["street"],
									"loc_subdistrict" => $data["subdistrict"],
									"loc_district" => $data["district"],
									"loc_province" => $data["province"]), 
							"room_id='{$data['id']}'");
	}

	public function deleteItem($room_id){
		// $room = $this->getItem($room_id);
		// if($room !== null){
		// 	$imgList = explode(";", $room["images"]);
		// 	foreach($imgList as $img){
		// 		if($img != "") unlink("./Resource/Images/".$img);
		// 	}
		// }
		// return $this->delete("room", "room_id='$room_id'");
	}

	public function getListByUser($user_id){
		// return $this->getList("host='$user_id'", "room_id ASC");
	}
}
?>