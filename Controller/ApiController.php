<?php
require_once "Controller.php";
class ApiController extends Controller{

    public function __construct(){
        parent::__construct();
    }
    // ACCOUNT
    public function getUserInfor($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) == "Role_None") $resp['code'] = "NotAuthorize";
        else{
            if(isset($data['user_id'])){
                $user = $this->accountObj->getItem($data['user_id']);
                $resp['type'] = "user";
            }
            else{
                $user = $this->accountObj->getItemByToken($token);
                $resp['type'] = "own";
            }
            if($user !== null){
                $resp['code'] = "OK";
                if($resp['type'] == "own"){
                    unset($user['user_id']);
                    unset($user['password']);
                }
                elseif($resp['type'] == "user"){
                    unset($user['user_id']);
                    unset($user['username']);
                    unset($user['password']);
                }
                $resp['user'] = $user;
            }
            else $resp['code'] = "NotFound";
        }
        return $resp;
    }
    public function updateUserInfor($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) == "Role_None") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            $data['user_id'] = $user['user_id'];
            if($this->accountObj->updateItem($data) === true){
                $resp['code'] = "OK";
            }
        }
        return $resp;
    }
    public function changePassword($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) == "Role_None") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            $data['user_id'] = $user['user_id'];
            if(_hash($data['oldpass']) != $user['password']) $resp['code'] = "WrongPassword";
            else if(strlen($data['newpass']) < 8) $resp['code'] = "ShortPassword";
            else if($data['newpass'] != $data['newpass2']) $resp['code'] = "MismatchPassword";
            else if($this->accountObj->changePassword($data) === true) $resp['code'] = "OK";
            else $resp['code'] = "Fail";
        }
        return $resp;
    }
    // ROOM
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
    // POST
    public function addPostAction($data){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else 
        {
            $user = $this->accountObj->getItemByToken($token);
            $data['user_id'] = $user['user_id'];
            if($this->postObj->addItem($data) === true) $resp['code'] = "OK";
            else $resp['code'] = "Fail";
        }
        return $resp;
    }
    public function getPostAction($data){
        $resp = array('code' => "");
        $post = $this->postObj->getItem($data['post_id']);
        if($post !== null){
            $resp['code'] = "OK";
            $resp['post'] = $post;
        }
        else $resp['code'] = "NotFound";
        return $resp;
    }
    public function getPostListAction($data){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else {
            //
        }
        return $resp;
    }
    public function updatePostAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            if($this->postObj->checkAuthor($data['id'], $user['user_id']) === true){
                if($this->postObj->updateItem($data) === true){
                    $resp["code"] = "OK";
                }
                else $resp["code"] = "Fail";
            }
            else $resp['code'] = "NotAllow";
        }
        return $resp;
    }
    public function deletePostAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            if($this->postObj->checkAuthor($data['id'], $user['user_id']) === true){
                if($this->postObj->deleteItem($data['id']) === true){
                    $resp["code"] = "OK";
                }
                else $resp["code"] = "Fail";
            }
            else $resp['code'] = "NotAllow";
        }
        return $resp;
    }
    // TENANT - RENT
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
    /*
    Function: create a bill for a room
    Role: Host
    -----
    Param1: token 
    Param2: room_id
    Param3: time
    Param4: titleList
    Param5: priceList
    Param6: numList
    */
    public function createBillAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $host = $this->accountObj->getItemByToken($token);
        $room = $this->roomObj->getItem($data['room_id']);
        if($room === null){
            $resp['code'] = "NotExistRoom";
            return $resp;
        }
        if($this->roomObj->checkHost($data['room_id'], $host['user_id']) === false){
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $tenant_id = $this->rentObj->getTenantId($data['room_id'], $data['time']);
        if($tenant_id === null){
            $resp['code'] = "NoTenant";
            return $resp;
        }
        $data['user_id'] = $tenant_id;
        if($this->billObj->addItem($data) === true) $resp['code'] = "OK";
        else $resp['code'] = "Fail";
        return $resp;
    }
    /*
    Function: get bill of a room
    Role: Host & Tenant
    -----
    Param1: token 
    Param2: room_id
    Param3: time
    */
    public function getBillAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        $checkLog = $this->accountObj->checkLoggedIn($token);
        if($checkLog != "Role_Host" && $checkLog != "Role_Tenant") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $user = $this->accountObj->getItemByToken($token);
        $room = $this->roomObj->getItem($data['room_id']);
        if($room === null){
            $resp['code'] = "NotExistRoom";
            return $resp;
        }
        $checkHost = $this->roomObj->checkHost($data['room_id'], $user['user_id']);
        $tenant_id = $this->rentObj->getTenantId($data['room_id'], $data['time']);
        if($checkHost === false && $tenant_id != $user['user_id']){
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $bill_id = $this->billObj->getBillId($data['room_id'], $data['time']);
        if($bill_id === null){
            $resp['code'] = "NotExistBill";
            return $resp;
        }
        $resp['code'] = "OK";
        $resp['bill'] = $this->billObj->getItem($bill_id);
        return $resp;
    }
}
?>