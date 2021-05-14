<?php
if(!defined('__CONTROLLER__')) define('__CONTROLLER__', 'true');
require_once "Model/Account.php";
require_once "Model/Token.php";
require_once "Model/Room.php";

class Controller{
    protected $accountObj;
    protected $tokenObj;
    protected $roomObj;

    public function __construct(){
        $this->accountObj = new Account;
        $this->tokenObj = new Token;
        $this->roomObj = new Room;
        //
        sessionInit();
        setTimeZone();
    }
}
?>