<?php
require_once "functions.php";
require_once "DB.php";

class Account extends DB{

	public function __construct(){
		parent::__construct();
	}

	private function genID(){
		$user_id = randString(20);
		$check_id = $this->getList("user_id='$user_id'");
		while(count($check_id) > 0){
			$user_id = randString(20);
			$check_id = $this->getList("user_id='$user_id'");
		}
		return $user_id;
	}

	public function getList($cond = "1", $order = ""){
		$list = $this->select("account", "*", $cond, $order);
		return $list;
	}

	public function getItem($user_id){
		$tmp = $this->getList("user_id='$user_id'");
		if(count($tmp) == 1) return $tmp[0];
		else return null;
	}

	public function getItemByToken($token){
		$tmp = $this->select("account JOIN token", "*", "token.token='$token' AND token.user_id=account.user_id", "token.valid_time DESC LIMIT 1");
		if(count($tmp) == 0) return null;
		$user = $tmp[0];
		unset($user['token']);
		unset($user['valid_time']);
		return $user;
	}

	// public function checkExist($username){
	// 	$list = $this->select("account", "*", "username='$username'");
	// 	return count($list) == 1;
	// }

	public function login($username, $password){
		$check = $this->getList("username='$username' AND password='$password'");
		if(count($check) == 1){
			return $check[0];
		}
		else{
			return null;
		}
	}

	public function checkLoggedIn($token = null){
		if($token === null) $token = getCookie("tt_tkn");
		if($token === null) return "Role_None";
		$check = $this->select("account JOIN token", "*", "token.user_id=account.user_id AND token.token='$token'", "token.valid_time DESC LIMIT 1");
		if(count($check) == 0) return "Role_None";
		$user = $check[0];
		if(timeCompare($user['valid_time'], date("Y-m-d H:i:s")) == -1){
			removeCookie("tt_tkn");
			return "Role_None";
		}
		return $user['role'];
	}

	public function signup($username, $password, $fullname, $mobile, $email, $role){
		$user_id = $this->genID();
		$data = array('user_id' => $user_id,
						'username' => $username,
						'password' => $password,
						'fullname' => $fullname,
						'email' => $email,
						'mobile' => $mobile,
						'role' => ($role == "011" ? "Role_Tenant" : "Role_Host"));
		return $this->insert("account", $data);
	}

	public function updateItem($data){
		return $this->update("account", array('fullname' => $data['fullname'],
												'mobile' => $data['mobile'],
												'email' => $data['email']),
										"user_id='{$data['user_id']}'");
	}

	public function checkUsername($username){
		return count($this->getList("username='$username'")) == 0;
	}

	public function checkPassword($password, $password2){
		if(strlen($password) < 8)
			return 1; // password is too short
		elseif($password != $password2)
			return 2; // password is mismatch
		else
			return 0; // OK
	}

	public function changePassword($data){
		return $this->update("account", array('password' => _hash($data['newpass'])), "user_id='{$data['user_id']}'");
	}

	public function removeItem($user_id){
		$this->delete("account", "user_id='$user_id'");
	}
}
?>