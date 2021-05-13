<?php
function setTimeZone(){
    date_default_timezone_set('asia/ho_chi_minh');
}

function sessionInit(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function getView($view, $data = null){
    $viewParams = $data;
    require_once "View/$view.view.php";
}

function getTemplate($template, $data = null){
    $viewParams = $data;
    require_once "View/Template/$template.template.php";
}

function getModal($modal, $data = null){
    $viewParams = $data;
    require_once "View/Modal/$modal.modal.php";
}

function notice_and_nextpage($mess, $link){
    echo "<html><head>"
        ."<meta charset=\"UTF-8\">"
        ."<title>Thông báo</title></head>"
        ."<body>"
            ."<script>"
                ."alert(\"$mess\");"
                ."window.location=\"$link\";"
            ."</script>"
        ."</body>"
        ."</html>";
}

function notice($mess){
    echo "<script>alert(\"$mess\");</script>";
}

function nextpage($link){
    ob_start();
    header("location: $link");
    ob_flush();
}

function debug($var){
    echo "<script>console.log('$var');</script>";
}

function _hash($data){
    return sha1(sha1($data));
}

function randString($length){
    $chars="abcdefghijklmnopqrstuvwxyz0123456789";
    $str="";
    for($i = 0; $i < $length; $i++)
        $str .= $chars[rand(0,35)];
    return $str;
}

function echo_max_len($str, $len){
    if(strlen($str) <= $len){
        echo $str;
    }
    else {
        echo substr($str, 0, $len)."...";
    }
}

function timeCompare($time1, $time2){
    if($time1 > $time2) return 1;
    elseif($time1 < $time2) return -1;
    else return 0;
}

function getSession($key){
    sessionInit();
    if(!isset($_SESSION[$key])) return null;
    return $_SESSION[$key];
}

function setSession($key, $value){
    sessionInit();
    $_SESSION[$key] = $value;
}

function getCookie($key){
    if(!isset($_COOKIE[$key])) return null;
    return $_COOKIE[$key];
}

function removeCookie($key){
    if(isset($_COOKIE[$key])){
        setcookie($key, "", time() - 86400);
    }
}
?>