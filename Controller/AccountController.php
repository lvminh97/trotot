<?php
require_once "Controller.php";
class AccountController extends Controller{

    public function __construct(){
        parent::__construct();
    }
    
    public function signupAction($data){
        $resp = array();
        // cac lenh kiem tra data
        if($this->accountObj->checkUsernameExist($data['username'])) $resp['code'] = "UsernameExist"; 
        // cac lenh thuc hien insert vao db
        else{
            $this->accountObj->signup($data['username'], 
                                    _hash($data['password']), 
                                    $data['fullname'],
                                    $data['mobile'],
                                    $data['email'],
                                    $data['role']);
            $resp['code'] = "OK";
        }
        return $resp;
    }

    public function loginAction($data){
        $resp = array('code' => '');
        $loginData = $this->accountObj->login($data['username'], _hash($data['password']));
        if($loginData !== null){
            //
            $token = $this->tokenObj->check($loginData['user_id']);
            if($token === null){
                $token = $this->tokenObj->addItem($loginData['user_id']);
            }
            setcookie("tt_tkn", $token, time() + 864000);
            $resp['code'] = "OK";
            $resp['token'] = $token;
        }
        else{
            $resp['code'] = "Fail";
        }
        return $resp;
    }

    public function logoutAction(){
        removeCookie("tt_tkn");
        nextpage("./?site=login");
    }

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
                    unset($user['password']);
                }
                elseif($resp['type'] == "user"){
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

    public function searchHostAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        $checkLog = $this->accountObj->checkLoggedIn($token);
        if($checkLog != "Role_Host") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        // $host = $this->accountObj->getItemByToken($token);
        $name = trim($data['name']);
        $mobile = trim($data['mobile']);
        $list = $this->accountObj->getList("(fullname LIKE '%$name%' OR mobile='$mobile') AND role='Role_Host'");
        for($i = 0; $i < count($list); $i++){
            unset($list[$i]['username']);
            unset($list[$i]['password']);
            unset($list[$i]['role']);
        }
        $resp['code'] = "OK";
        $resp['host'] = $list;
        return $resp;
    }

    public function deleteHostAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        $checkLog = $this->accountObj->checkLoggedIn($token);
        if($checkLog != "Role_Admin") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        if($this->accountObj->deleteItem($data['id']) === true)
            $resp['code'] = "OK";
        else    
            $resp['code'] = "Fail";
        return $resp;
    }
}
?>