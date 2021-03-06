<?php
require_once "functions.php";
require_once "DB.php";

class Post extends DB{

	public function __construct(){
		parent::__construct();
	}

	public function getList($cond = "1", $order_by = ""){
		return $this->select("post JOIN room", "*", "post.room_id=room.room_id AND ".$cond, $order_by);
	}

	public function getItem($post_id){
		$tmp = $this->select("post", "*", "post_id='$post_id'");
		if(count($tmp) == 0) return null;
		return $tmp[0];
	}

	public function addItem($data){
		return $this->insert("post", array("post_id" => "null",
											"author" => $data['user_id'],
											"title" => $data["title"],
											"time" => date("Y-m-d H:i:s"),
											"room_id" => $data["room_id"],
											"content" => $data["content"],
											"approval" => "no"));
	}

	public function updateItem($data){
		return $this->update("post", 
							array("title" => $data["title"],
									"room_id" => $data["room_id"],
									"content" => $data["content"],
									"time" => date("Y-m-d H:i:s"),
									"approval" => "no"), 
							"post_id='{$data['id']}'");
	}

	public function deleteItem($post_id){
		return $this->delete("post", "post_id='$post_id'");
	}

	public function rejectItem($post_id, $feedback){
		return $this->update("post", array('approval' => "reject", 'feedback' => $feedback), "post_id='$post_id'");
	}

	public function checkAuthor($post_id, $user_id){
		$tmp = $this->select("post", "*", "author='$user_id' AND post_id='$post_id'");
		return count($tmp) == 1;
	}

	public function getListByUser($user_id){
		return $this->getList("post.author='$user_id'", "post.post_id DESC");
	}

	public function setApproval($post_id, $approval){
		return $this->update("post", array("approval" => $approval), "post_id='$post_id'");
	}
}
?>