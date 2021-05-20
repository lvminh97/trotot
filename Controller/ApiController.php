<?php
require_once "Controller.php";
class ApiController extends Controller{

    public function __construct(){
        parent::__construct();
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
                    // for($i = 0; $i < count($post); $i++){
                    //     $post[$i]['room'] = $this->roomObj->getItem($post[$i]['room_id']);
                    // }
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
}
?>