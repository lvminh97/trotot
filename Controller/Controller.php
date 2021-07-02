<?php
if(!defined('__CONTROLLER__')) define('__CONTROLLER__', 'true');
require_once "Model/Account.php";
require_once "Model/Token.php";
require_once "Model/Room.php";
require_once "Model/Post.php";
require_once "Model/Rent.php";
require_once "Model/Bill.php";
require_once "Model/Transfer.php";

class Controller{
    protected $accountObj;
    protected $tokenObj;
    protected $roomObj;
    protected $postObj;
    protected $rentObj;
    protected $billObj;
    protected $transferObj;

    public function __construct(){
        $this->accountObj = new Account;
        $this->tokenObj = new Token;
        $this->roomObj = new Room;
        $this->postObj = new Post;
        $this->rentObj = new Rent;
        $this->billObj = new Bill;
        $this->transferObj = new Transfer;
        //
        sessionInit();
        setTimeZone();
    }
}
?>