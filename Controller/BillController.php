<?php
require_once "Controller.php";

class BillController extends Controller{
    
	public function __construct(){
		parent::__construct();
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