<?php
    require_once "Controller/Route.php";
    $route = new Route("ViewController@getIndex");
    // Dang ky tai khoan
    $route->get("site", "dangky", "ViewController@getSignupPage");
    $route->post("action", "dangky", "ActionController@signupAction");
    // Dang nhap
    $route->get("site", "dangnhap", "ViewController@getLoginPage");
    $route->post("action", "dangnhap", "ActionController@loginAction");
    $route->get("action", "dangnhap", "ViewController@getIndex");
    $route->get("action", "logout", "ActionController@logoutAction");
    
    /// 
    $route->get("link", "manage-home", "HostViewController@getHomePage");

    $route->get("link", "manage-room", "HostViewController@getManageRoomPage");


    //// API
    $route->post("api", "add_room", "ApiController@addRoomAction");
    $route->post("api", "get_room", "ApiController@getRoomAction");

    $route->process();
?>