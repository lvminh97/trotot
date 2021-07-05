<?php
require_once "Controller.php";

class PostController extends Controller{
    
	public function __construct(){
		parent::__construct();
	}

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
        return $resp;
    }
    
    public function getPostAction($data){
        $resp = array('code' => "");
        $post = $this->postObj->getItem($data['id']);
        if($post !== null){
            $resp['code'] = "OK";
            $resp['post'] = $post;
        }
        else $resp['code'] = "NotFound";
        return $resp;
    }

    public function getPostListAction($data){
        $resp = array("code" => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Host") $resp['code'] = "NotAuthorize";
        else {
            //
        }
        return $resp;
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
        return $resp;
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
        return $resp;
    }

    public function approvePostAction($data){
        $resp = array('code' => "");
        if(isset($data['token'])) $token = $data['token'];
        else $token = getCookie("tt_tkn");
        if($this->accountObj->checkLoggedIn($token) != "Role_Admin") {
            $resp['code'] = "NotAuthorize";
            return $resp;
        }
        $user = $this->accountObj->getItemByToken($token);
        if($data['cmd'] == "approve" && $this->postObj->setApproval($data['id'], "yes") === true)
            $resp['code'] = "OK";
        elseif($data['cmd'] == "delete" && $this->postObj->deleteItem($data['id']) === true)
            $resp['code'] = "OK";
        else 
            $resp['code'] = "Fail";
        
        return $resp;
    }
}
?>