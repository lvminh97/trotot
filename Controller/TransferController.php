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
			$buf = array('receive_status' => $data['status'], 'receive_feedback' => $data['feedback']);
			$transfer = $this->transferObj->getItem($data['id']);
			if($this->rentObj->transferRoom($transfer['tenant'], $transfer['room_transfer'], $transfer['room_receive']) === false){
				$resp['code'] = "Fail";
				return $resp;
			}
		}
		elseif($data['status'] == "reject"){
			$buf = array('receive_status' => $data['status'], 'receive_feedback' => $data['feedback']);
		}
		if($this->transferObj->updateStatus($data['id'], $buf) === true)
			$resp['code'] = "OK";
		else
			$resp['code'] = "Fail";
		return $resp;
    }

	public function getTransferRoomListAction($data){
		$resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        $checkLog = $this->accountObj->checkLoggedIn($token);
		if($checkLog == "Role_None") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $user = $this->accountObj->getItemByToken($token);
		$transfer = $this->transferObj->getItem($data['transfer_id']);
		$roomList = $this->roomObj->getListByHost($transfer['host_receive']);
		$resp['code'] = "OK";
		$resp['roomList'] = array();
		for($i = 0; $i < count($roomList); $i++){
		    if($this->rentObj->getTenantId($roomList[$i]['room_id'], date("Y-m-d")) === null){
				$roomList[$i]['full_address'] = getFullAddress($roomList[$i]);
		        $resp['roomList'][] = $roomList[$i];
			}
		}
		return $resp;
	}

	public function tenantApproveTransferAction($data){
		$resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        $checkLog = $this->accountObj->checkLoggedIn($token);
		if($checkLog != "Role_Tenant") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
		$user = $this->accountObj->getItemByToken($token);
		$transfer = $this->transferObj->getItem($data['transfer_id']);
		if($user['user_id'] != $transfer['tenant']){
			$resp['code'] = "NotAllow";
			return $resp;
		}
		if($data['approve'] == "approve"){
			if($this->transferObj->updateStatus($data['transfer_id'], 
									array('room_receive' => $data['room_id'], 
										'tenant_status' => 'approve', 
										'tenant_feedback' => $data['feedback'])) === true) $resp['code'] = "OK";
			else $resp['code'] = "Fail";
		}
		else{
			if($this->transferObj->updateStatus($data['transfer_id'], 
			array('tenant_status' => 'reject', 
				'tenant_feedback' => $data['feedback'])) === true) $resp['code'] = "OK";
			else $resp['code'] = "Fail";
		}
		return $resp;
	}

	public function deleteTransferAction($data){
		$resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        $checkLog = $this->accountObj->checkLoggedIn($token);
		if($checkLog != "Role_Host") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
		$host = $this->accountObj->getItemByToken($token);
		$transfer = $this->transferObj->getItem($data['transfer_id']);
		if($host['user_id'] != $transfer['host_transfer']){
			$resp['code'] = "NotAllow";
			return $resp;
		}
		if($transfer['tenant_status'] == "approve" && $transfer['receive_status'] == "approve"){
			$resp['code'] = "CannotDeleteByApproval";
			return $resp;
		}
		if($this->transferObj->deleteItem($data['transfer_id']) === true)
			$resp['code'] = "OK";
		else	
			$resp['code'] = "Fail";
		return $resp;
	}
}
?>