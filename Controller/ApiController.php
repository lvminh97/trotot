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
        echo json_encode($resp);
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
        echo json_encode($resp);
    }
    public function getRoomAction($data){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else {
            $user = $this->accountObj->getItemByToken($token);
            if($this->roomObj->checkHost($data['id'], $user['user_id']) === true){
                $room = $this->roomObj->getItem($data['id']);
                if($room !== null){
                    $resp["code"] = "OK";
                    $resp["room"] = $room;
                }
                else $resp["code"] = "NotFound";
            }
            else $resp['code'] = "NotAllow";
        }
        echo json_encode($resp);
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
        echo json_encode($resp);
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
        echo json_encode($resp); 
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
        echo json_encode($resp);
    }
    public function getPostAction($data){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else {
            $user = $this->accountObj->getItemByToken($token);
            if($this->postObj->checkAuthor($data['id'], $user['user_id']) === true){
                $post = $this->postObj->getItem($data['id']);
                if($post !== null){
                    $resp['code'] = "OK";
                    $resp['post'] = $post;
                }
                else $resp['code'] = "NotFound";
            }
            else $resp['code'] = "NotAllow";
        }
        echo json_encode($resp);
    }
    public function getPostListAction($data){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else {
            //
        }
        echo json_encode($resp);
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
        echo json_encode($resp);
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
        echo json_encode($resp);
    }
    // TENANT - RENT
    public function rentAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Tenant") $resp['code'] = "NotAuthorize";
        else{
            $user = $this->accountObj->getItemByToken($token);
            if($this->tenantObj->rent($data) === true){
                $resp['code'] = "OK";
            }
            else $resp['code'] = "Fail";
        }
    }
}
?>