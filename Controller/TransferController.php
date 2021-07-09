<?php
require_once "Controller.php";

class TransferController extends Controller{
    
	public function __construct(){
		parent::__construct();
	}

	public function transferAction($data){
		$resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        $checkLog = $this->accountObj->checkLoggedIn($token);
        if($checkLog != "Role_Host") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $host = $this->accountObj->getItemByToken($token);
		// Kiem tra nguoi nhan con phong trong khong
        $roomList = $this->roomObj->getListByHost($data['host']);
		$cnt = 0;
		foreach($roomList as $room){
			if($this->rentObj->getTenantId($room['room_id'], date("Y-m-d")) === null)
				$cnt++;
		}
		if($cnt == 0){
			$resp['code'] = "NoEmptyRoom";
			return $resp;
		}
		$buf = array('tenant' => $data['tenant'],
						'host_transfer' => $host['user_id'],
						'host_receive' => $data['host'],
						'room_transfer' => $data['room'],
						'room_receive' => '0',
						'tenant_status' => 'pending',
						'receive_status' => 'pending',
						'tenant_feedback' => '',
						'receive_feedback' => '');
		if($this->transferObj->addItem($buf) === true)
			$resp['code'] = "OK";
		else
			$resp['code'] = "Fail";
		return $resp;
    }

    public function approveAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        $checkLog = $this->accountObj->checkLoggedIn($token);
        if($checkLog != "Role_Host") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $host = $this->accountObj->getItemByToken($token);
        $roomList = $this->roomObj->getListByHost($host['user_id']);
		if($data['status'] == "approve"){
			$cnt = 0;
			foreach($roomList as $room){
				if($this->rentObj->getTenantId($room['room_id'], date("Y-m-d")) === null)
					$cnt++;
			}
			if($cnt == 0){
				$resp['code'] = "NoEmptyRoom";
				return $resp;
			}
			$buf = array('status' => $data['status'], 'feedback' => $data['feedback'], 'room_receive' => $data['room_id']);
			$transfer = $this->transferObj->getItem($data['id']);
			if($this->rentObj->transferRoom($transfer['tenant'], $transfer['room_transfer'], $data['room_id']) === false){
				$resp['code'] = "Fail";
				return $resp;
			}
		}
		elseif($data['status'] == "reject"){
			$buf = array('status' => $data['status'], 'feedback' => $data['feedback']);
		}
		if($this->transferObj->updateStatus($data['id'], $buf) === true)
			$resp['code'] = "OK";
		else
			$resp['code'] = "Fail";
		return $resp;
    }
}
?>