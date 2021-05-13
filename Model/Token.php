<?php
require_once "functions.php";
require_once "DB.php";

class Token extends DB{

	public function __construct(){
		parent::__construct();
	}

    public function gen(){
        $token = randString(30);
        $check = $this->getItem($token);
        while($check !== null){
            $token = randString(30);
            $check = $this->getItem($token);
        }
        return $token;
    }

    public function check($user_id){
        $check = $this->select("token", "*", "user_id='$user_id'", "valid_time DESC LIMIT 1");
        if(count($check) == 0) return null;
        if(timeCompare($check[0]['valid_time'], date("Y-m-d H:i:s") == -1)){
            removeCookie("tt_tkn");
            return null;
        }
        else return $check[0]['token'];
    }

    public function getItem($token){
        $tmp = $this->select("token", "*", "token='$token'");
        if(count($tmp) == 1){
            return $tmp[0];
        }
        else return null;
    }

    public function addItem($user_id){
        $token = $this->gen();
        $this->insert("token", array('user_id' => $user_id,
                                        'token' => $token,
                                        'valid_time' => date("Y-m-d H:i:s", time() + 10 * 86400)));
        return $token;
    }
}
?>