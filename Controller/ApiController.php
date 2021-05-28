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
    public function rentAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Tenant") $resp['code'] = "NotAuthorize";
        else{
            if($this->roomObj->getItem($data['room_id']) === null) $resp['code'] = "NotExistRoom";
            elseif($this->roomObj->checkAvailable($data['room_id']) === true){
                $user = $this->accountObj->getItemByToken($token);
                $data['user_id'] = $user['user_id'];
                if($this->rentObj->addItem($data) === true){
                    $resp['code'] = "OK";
                }
                else $resp['code'] = "Fail";
            }
            else $resp['code'] = "RoomNotAvailable";
        }
        return $resp;
    }
    public function cancelRentAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Tenant") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            if($this->roomObj->getItem($data['room_id']) === null) $resp['code'] = "NotExistRoom";
            else{
                $checkTenant = $this->rentObj->getRecentItem($user['user_id'], $data['room_id']);
                if($checkTenant !== null && $checkTenant['status'] == "renting"){
                    if($this->rentObj->updateStatus($data['rent_id'], "cancel") === true)
                        $resp['code'] = "OK";
                    else 
                        $resp['code'] = "Fail";
                }
                else $resp['code'] = "NoRent";
            }
        }
        return $resp;
    }
    public function approveRentAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            // if()
        }
    }
    public function rejectRentAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            
        }
    }

    public function preventRentAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            // if()
        }
    }
}
?>