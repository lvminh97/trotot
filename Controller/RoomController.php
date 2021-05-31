<?php
require_once "Controller.php";

class RoomController extends Controller{
	
	public function __construct(){
		parent::__construct();
	}

    public function addRoomAction($data, $files){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else 
        {
            $user = $this->accountObj->getItemByToken($token);
            $data['user_id'] = $user['user_id'];
            if($this->roomObj->addItem($data, $files) === true) $resp['code'] = "OK";
            else $resp['code'] = "Fail";
        }
        return $resp;
    }

    public function getRoomAction($data){
        $resp = array("code" => "");
        $room = $this->roomObj->getItem($data['room_id']);
        if($room !== null){
            $resp["code"] = "OK";
            $resp["room"] = $room;
        }
        else $resp["code"] = "NotFound";
        return $resp;
    }

    public function searchRoomAction($data){
        $resp['code'] = "";

    }

    public function getRoomListAction($data){

    }

    public function updateRoomAction($data, $files){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else {
            $user = $this->accountObj->getItemByToken($token);
            if($this->roomObj->checkHost($data['id'], $user['user_id']) === true){
                if($this->roomObj->updateItem($data, $files) === true){
                    $resp["code"] = "OK";
                }
                else $resp["code"] = "Fail";
            }
            else $resp["code"] = "NotAllow";
        }
        return $resp;
    }

    public function deleteRoomAction($data){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else {
            $user = $this->accountObj->getItemByToken($token);
            if($this->roomObj->checkHost($data['id'], $user['user_id']) === true){
                if($this->roomObj->deleteItem($data['id']) === true){
                    $resp["code"] = "OK";
                }
                else $resp["code"] = "Fail";
            }
            else $resp["code"] = "NotAllow";
        }
        return $resp;
    } 
}
?>