<?php
require_once "Controller.php";

class RentController extends Controller{

    public function __construct(){
        parent::__construct();
    }

	/*
    Function: rent a room
    Role: Tenant
    -----
    Param1: token 
    Param2: room_id
    */
    public function rentAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Tenant") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        if($this->roomObj->getItem($data['room_id']) === null) {
            $resp['code'] = "NotExistRoom";
            return $resp;
        }
        $checkAvailable = $this->roomObj->checkAvailable($data['room_id']);
        // $checkRent
        if($checkAvailable === true){
            $user = $this->accountObj->getItemByToken($token);
            $data['user_id'] = $user['user_id'];
            if($this->rentObj->addItem($data) === true){
                $resp['code'] = "OK";
            }
            else $resp['code'] = "Fail";
        }
        else $resp['code'] = "RoomNotAvailable";
        return $resp;
    }

    /*
    Function: cancel renting a room
    Role: Tenant
    -----
    Param1: token 
    Param2: rent_id
    */
    public function cancelRentAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Tenant") {
            $resp['code'] = "NotAuthorize";
            return $resp; 
        }
        $user = $this->accountObj->getItemByToken($token);
        if($this->roomObj->getItem($data['room_id']) === null) {
            $resp['code'] = "NotExistRoom";
            return $resp;
        }
        $checkTenant = $this->rentObj->getRecentItem($user['user_id'], $data['room_id']);
        if($checkTenant !== null && ($checkTenant['status'] == "renting" || $checkTenant['status'] == "pending")){
            if($this->rentObj->updateStatus($data['rent_id'], "cancel") === true)
                $resp['code'] = "OK";
            else 
                $resp['code'] = "Fail";
        }
        else $resp['code'] = "NoRent";
        return $resp;
    }
    
    /* 
    Function: set the status of rent item
    Role: Host
    -----
    Param1: token 
    Param2: rent_id
    Param3: status
    */
    public function setRentStatusAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $user = $this->accountObj->getItemByToken($token);
        $rent = $this->rentObj->getItem($data['rent_id']);
        if($rent === null) { 
            $resp['code'] = "WrongID"; 
            return $resp; 
        }
        if($this->roomObj->checkHost($rent['room_id'], $user['user_id']) === false){
            $resp['code'] = "NotAllow";
            return $resp;
        }
        if($this->rentObj->updateStatus($data['rent_id'], "reject") === true){
            $resp['code'] = "OK";
        }
        else $resp['code'] = "Fail";
        return $resp;
    }
}
?>