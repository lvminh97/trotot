<?php
require_once "Controller.php";
class ActionController extends Controller{

    public function __construct(){
        parent::__construct();
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
        nextpage("./.");
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
}
?>