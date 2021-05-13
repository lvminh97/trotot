<?php
require_once "Controller.php";
class HostViewController extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function getHomePage(){
        if($this->accountObj->checkLoggedIn() != "Role_Host") return;
        $user = $this->accountObj->getItem(getSession('TT_uid'));
        getView("home.manage", array('title' => "Trọ Tốt - Manage",
                                        'user' => $user));
    }

    public function getManageRoomPage(){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => "null"));
        }
        else{
            $user = $this->accountObj->getItem(getSession('TT_uid'));
            getView("room.manage", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user));
        }
    }

}
?>