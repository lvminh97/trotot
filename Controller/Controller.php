<?php
if(!defined('__CONTROLLER__')) define('__CONTROLLER__', 'true');
require_once "Model/Account.php";
require_once "Model/Token.php";
require_once "Model/Room.php";
require_once "Model/Post.php";
require_once "Model/Tenant.php";

class Controller{
    protected $accountObj;
    protected $tokenObj;
    protected $roomObj;
    protected $postObj;
    protected $tenantObj;

    public function __construct(){
        $this->accountObj = new Account;
        $this->tokenObj = new Token;
        $this->roomObj = new Room;
        $this->postObj = new Post;
        $this->tenantObj = new Tenant;
        //
        sessionInit();
        setTimeZone();
    }
}
?>