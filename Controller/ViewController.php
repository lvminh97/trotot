<?php
require_once "Controller.php";
class ViewController extends Controller{

    public function __construct(){
        parent::__construct();
    }
    //// COMMON
    public function getIndex(){
        // if($this->accountObj->checkLoggedIn() == "Role_None") $user = null;
        // else $user = $this->accountObj->getItemByToken(getCookie("tt_tkn"));
        // getView("homepage", array('title' => 'Trọ Tốt',
        //                             'user' => $user));
        // return null;                                  
        $this->getRoomListForCustomerPage(null);  
    }
    public function getSignupPage(){
        if($this->accountObj->checkLoggedIn() == "Role_None")
            getView("signup", array('title' => 'Trọ Tốt - Đăng ký',
                                    'user' => null));
        else nextpage("./.");
        return null;
    }
    public function getLoginPage(){
        if($this->accountObj->checkLoggedIn() == "Role_None")
            getView("login", array('title' => 'Trọ Tốt - Đăng nhập',
                                    'user' => null));
        else nextpage("./.");
        return null;
    }

    //// CUSTOMER
    public function getRoomListForCustomerPage($data){
        if($this->accountObj->checkLoggedIn() == "Role_None") $user = null;
        else $user = $this->accountObj->getItemByToken(getCookie("tt_tkn"));
        $roomList = $this->roomObj->getAvailableList($data);
        getView("roomlist", array('title' => "Trọ tốt - Danh sách phòng",
                                    'user' => $user,
                                    'roomList' => $roomList,
                                    'url_param' => $data));
        return null;                                
    }

    public function getRoomPage($data){
        if($this->accountObj->checkLoggedIn() == "Role_None") $user = null;
        else $user = $this->accountObj->getItemByToken(getCookie("tt_tkn"));
        $room = $this->roomObj->getItemWithPost($data['id']);
        $host = getController("AccountController@getUserInfor", array('token' => getCookie("tt_tkn"), 'user_id' => $room['host']))['user'];
        getView("room", array('title' => "Trọ tốt - Xem phòng",
                                'user' => $user,
                                'room' => $room,
                                'host' => $host));
        return null;
    }

    public function getRoomDemoPage($data){
        if($this->accountObj->checkLoggedIn() == "Role_None") $user = null;
        else $user = $this->accountObj->getItemByToken(getCookie("tt_tkn"));
        $room = $this->roomObj->getItemWithPost($data['id'], "no");
        $host = getController("AccountController@getUserInfor", array('token' => getCookie("tt_tkn"), 'user_id' => $room['host']))['user'];
        getView("room.demo", array('title' => "Trọ tốt - Xem phòng",
                                    'user' => $user,
                                    'room' => $room,
                                    'host' => $host));
        return null;
    }

    public function getMyRoomManagePage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Tenant") return null;
        else $user = $this->accountObj->getItemByToken(getCookie("tt_tkn"));
        $roomList = $this->roomObj->getListByTenant($user['user_id']);
        for($i = 0; $i < count($roomList); $i++){
            $checkTransfer = $this->transferObj->checkTransferByTenantAndRoom($user['user_id'], $roomList[$i]['room_id']);
            if($checkTransfer !== null){
                $roomList[$i]['transfer_id'] = $checkTransfer['transfer_id'];
            }
        }
        $billList = array();
        foreach($roomList as $room){
            if($room['status'] == "renting"){
                $bill_id = $this->billObj->getBillId($room['room_id'], date("Y-m")."-01");
                if($bill_id !== null)
                    $billList[$room['room_id']] = $this->billObj->getItem($bill_id);
                else 
                    $billList[$room['room_id']] = null;
            }
        }
        getView("myroom", array('title' => 'Trọ tốt - Phòng của tôi',
                                'user' => $user,
                                'roomList' => $roomList,
                                'billList' => $billList));
        return null;
    }

    public function getMyRoomDetailPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Tenant") return null;
        else $user = $this->accountObj->getItemByToken(getCookie("tt_tkn"));
        $room = $this->roomObj->getItem($data['id']);
        getView("myroom.detail", array('title' => "Trọ tốt",
                                        'user' => $user,
                                        'room' => $room));
    }

    //// HOST
    public function getHostHomePage($data){
        $this->getManageRoomPage($data);                                      
    }
    public function getManageRoomPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            getView("room.manage", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'roomList' => $this->roomObj->getListByHost($user['user_id'])));
        }
        return null;
    }
    public function getManageRoomDetailPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            $room = $this->roomObj->getItem($data['id']);
            $tenant = $this->accountObj->getItem($this->rentObj->getTenantId($data['id'], date("Y-m-d")));
            $rentList = $this->rentObj->getRentList($data['id']);
            $billList = $this->billObj->getListByRoom($data['id']);
            getView("room.detail.manage", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'room' => $room,
                                            'tenant' => $tenant,
                                            'rentList' => $rentList,
                                            'billList' => $billList));
        }
        return null;
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
                                            'roomList' => $this->roomObj->getListByHost($user['user_id']),
                                            'postList' => $this->postObj->getListByUser($user['user_id'])));
        }
        return null;
    }

    public function getManageRentPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            $roomList = $this->roomObj->getListByHost($user['user_id']);
            for($i = 0; $i < count($roomList); $i++){
                $roomList[$i]['status'] = $this->rentObj->getCurrentStatus($roomList[$i]['room_id']);
                $roomList[$i]['request'] = $this->rentObj->getPendingList($roomList[$i]['room_id']);
            }
            getView("rent.manage", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'roomList' => $roomList));
        }
        return null;
    }

    public function getManageTransferTenantPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            $transferList = $this->transferObj->getTransferList($user['user_id']);
            for($i = 0; $i < count($transferList); $i++){
                $transferList[$i]['tenant'] = $this->accountObj->getItem($transferList[$i]['tenant']);
                $transferList[$i]['host_receive'] = $this->accountObj->getItem($transferList[$i]['host_receive']);
            }
            getView("tenant.transfer.manage", array('title' => "Trọ Tốt - Danh sách yêu cầu gửi khách trọ",
                                            'user' => $user,
                                            'transferList' => $transferList));
        }
        return null;
    }

    public function getManageReceiveTenantPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            $receiveList = $this->transferObj->getReceiveList($user['user_id']);
            for($i = 0; $i < count($receiveList); $i++){
                $receiveList[$i]['tenant'] = $this->accountObj->getItem($receiveList[$i]['tenant']);
                $receiveList[$i]['host_transfer'] = $this->accountObj->getItem($receiveList[$i]['host_transfer']);
            }
            $roomList = $this->roomObj->getListByHost($user['user_id']);
            for($i = 0; $i < count($roomList); $i++){
                if($this->rentObj->getTenantId($roomList[$i]['room_id'], date("Y-m-d")) === null)
                    $roomList[$i]['status'] = "available";
                else
                    $roomList[$i]['status'] = "notavailable";
                
            }
            getView("tenant.receive.manage", array('title' => "Trọ Tốt - Danh sách yêu cầu nhận khách trọ",
                                            'user' => $user,
                                            'receiveList' => $receiveList,
                                            'roomList' => $roomList));
        }
        return null;
    }

    public function getManageBillPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            $roomList = array();
            foreach($this->roomObj->getListByHost($user['user_id']) as $room){
                $roomList[$room['room_id']] = $room;
            }
            if(isset($data['y']) && isset($data['m'])) $time = $data['y']."-".$data['m'];
            else $time = date("Y-m");
            $billList = $this->billObj->getListByHostAndTime($user['user_id'], $time);
            getView("bill.manage", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'roomList' => $roomList,
                                            'billList' => $billList,
                                            'time' => $time));
        }
        return null;
    }

    public function getManageStatisticPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Host"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            if(isset($data['y']) && isset($data['m'])) $time = $data['y']."-".$data['m'];
            else $time = date("Y-m");
            $roomList = $this->roomObj->getListByHost($user['user_id']);
            $moneyList = array();
            foreach($roomList as $room){
                $billList = $this->billObj->getListByRoomAndTime($room['room_id'], explode("-", $time)[0], explode("-", $time)[1]);
                // print_r($billList);
                $total = 0;
                foreach($billList as $bill) $total += $bill['price'] * $bill['number'];
                $moneyList[$room['room_id']] = $total;
            }
            getView("statistic.manage", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'roomList' => $roomList,
                                            'moneyList' => $moneyList,
                                            'time' => $time));
        }
        return null;
    }

    //// ADMIN
    public function getApprovePostPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Admin"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            $postList = $this->postObj->getList("post.approval='no'", "post.time");
            getView("post.approve.admin", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'postList' => $postList));
        }
        return null;
    }

    public function getManageHostPage($data){
        if($this->accountObj->checkLoggedIn() != "Role_Admin"){
            getView("login", array('title' => "Trọ Tốt - Đăng nhập",
                                    'user' => null));
        }
        else{
            $user = $this->accountObj->getItemByToken(getCookie('tt_tkn'));
            $hostList = $this->accountObj->getList("role='Role_Host'");
            getView("host.manage.admin", array('title' => "Trọ Tốt - Manage",
                                            'user' => $user,
                                            'hostList' => $hostList));
        }
        return null;
    }
}
?>