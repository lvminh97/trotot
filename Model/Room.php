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

	public function getAvailableList(){
		return $this->select("room JOIN post", 
								"*", 
								"room.room_id NOT IN (SELECT room_id FROM rent WHERE status='renting') AND room.room_id=post.room_id AND post.approval='yes'",
								"post.post_id DESC",
								"room.room_id");
	}

	public function getItem($room_id){
		$tmp = $this->select("room", "*", "room_id='$room_id'");
		if(count($tmp) == 0) return null;
		return $tmp[0];
	}

	public function getItemWithPost($room_id){
		$tmp = $this->select("room JOIN post", "*", "room.room_id='$room_id' AND room.room_id=post.room_id AND post.approval='yes'", "post.post_id DESC LIMIT 1");
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
		$room = $this->getItem($room_id);
		if($room !== null){
			$imgList = explode(";", $room["images"]);
			foreach($imgList as $img){
				if($img != "") unlink("./Resource/Images/".$img);
			}
		}
		return $this->delete("room", "room_id='$room_id'");
	}

	public function checkHost($room_id, $user_id){
		$tmp = $this->select("room", "*", "host='$user_id' AND room_id='$room_id'");
		return count($tmp) == 1;
	}

	public function checkAvailable($room_id){
		// $currentTime = date("Y-m-d H:i:s");
		$tmp = $this->select("rent", "*", "room_id='$room_id' AND status='renting'");
		if(count($tmp) > 0) return false;
		return true;	
	}

	public function getListByHost($user_id){
		return $this->getList("host='$user_id'", "room_id ASC");
	}

	public function getListByTenant($user_id){
		return $this->select("room JOIN rent", "*", "room.room_id=rent.room_id AND rent.user_id='$user_id'", "rent.begin_time DESC");
	}
}
?>