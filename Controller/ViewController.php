<?php
require_once "Controller.php";
class ViewController extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public function getIndex(){
        if($this->accountObj->checkLoggedIn() == "Role_None") $user = null;
        else $user = $this->accountObj->getItemByToken(getCookie("tt_tkn"));
        getView("homepage", array('title' => 'Trọ Tốt',
                                    'user' => $user));
    }
    public function getSignupPage(){
        if($this->accountObj->checkLoggedIn() == "Role_None")
            getView("signup", array('title' => 'Trọ Tốt - Đăng ký',
                                    'user' => null));
        else nextpage("./.");
    }
    public function getLoginPage(){
        if($this->accountObj->checkLoggedIn() == "Role_None")
            getView("login", array('title' => 'Trọ Tốt - Đăng nhập',
                                    'user' => null));
        else nextpage("./.");
    }

    //// CUSTOMER
    public function getRoomListForCustomerPage(){
        if($this->accountObj->checkLoggedIn() == "Role_None") $user = null;
        else $user = $this->accountObj->getItemByToken(getCookie("tt_tkn"));
        getView("roomlist", array('title' => "Trọ tốt - Danh sách phòng",
                                    'user' => $user,
                                    'postList' => $this->postObj->getList()));
    }

    //// HOST
    public function getHostHomePage(){
        if($this->accountObj->checkLoggedIn() != "Role_Host") return;
        $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
        getView("home.manage", array('title' => "Trọ Tốt - Manage",
                                        'user' => $user));
    }
    public function getManageRoomPage(){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            getView("room.manage", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'roomList' => $this->roomObj->getListByUser($user['user_id'])));
        }
    }
    public function getManagePostPage(){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            getView("post.manage", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'roomList' => $this->roomObj->getListByUser($user['user_id']),
                                            'postList' => $this->postObj->getListByUser($user['user_id'])));
        }
    }
}
?>