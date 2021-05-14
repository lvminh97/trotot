<?php
require_once "Controller.php";
class ApiController extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function addRoomAction($data, $files){
        if(isset($data['token'])) $token = $data['token'];
        else $token = null;
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") return null;
        else $user = $this->accountObj->getItemByToken($token);
        print_r($user);
    }

}
?>