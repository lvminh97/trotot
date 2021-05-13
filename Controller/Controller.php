<?php
if(!defined('__CONTROLLER__')) define('__CONTROLLER__', 'true');
require_once "Model/Account.php";
require_once "Model/Token.php";

class Controller{
    protected $accountObj;
    protected $tokenObj;

    public function __construct(){
        $this->accountObj = new Account;
        $this->tokenObj = new Token;
        //
        sessionInit();
        setTimeZone();
    }
}
?>