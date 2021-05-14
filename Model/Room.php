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

	// public function getItem($)

	public function addItem($data, $files){
		$image = "";
		if(isset($files["image"])){
			for($i = 0; $i < count($files["image"]["name"]); $i++){
				if($image != "") $image .= ";";
				$image .= basename($files["image"]["name"][$i]);
				move_uploaded_file($files["image"]["tmp_name"][$i], "./Resource/Images/".basename($files["image"]["name"][$i]));
			}
		}
		$this->insert("room", array("room_id" => "null",
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
}
?>