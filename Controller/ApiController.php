<?php
require_once "Controller.php";
class ApiController extends Controller{

    public function __construct(){
        parent::__construct();
    }
    // ROOM
    public function addRoomAction($data, $files){
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") return null;
        else $user = $this->accountObj->getItemByToken($token);
        //
        $resp = array();
        $data['user_id'] = $user['user_id'];
        $this->roomObj->addItem($data, $files);
        $resp['code'] = "OK";
        echo json_encode($resp);
    }
    public function getRoomAction($data){
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") return null;
        else $user = $this->accountObj->getItemByToken($token);
        //
        $resp = array();
        $data['user_id'] = $user["user_id"];
        $room = $this->roomObj->getItem($data);
        $resp["code"] = "OK";
        $resp["room"] = $room;
        echo json_encode($resp);
    }


}
?>