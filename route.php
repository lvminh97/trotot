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


    //// ROOM API
    $route->post("api", "add_room", "ApiController@addRoomAction");
    $route->post("api", "get_room", "ApiController@getRoomAction");
    $route->post("api", "get_room_list", "ApiController@getRoomListAction");
    $route->post("api", "update_room", "ApiController@updateRoomAction");
    $route->post("api", "delete_room", "ApiController@deleteRoomAction");
    //// POST API
    $route->post("api", "add_post", "ApiController@addPostAction");
    $route->post("api", "get_post", "ApiController@getPostAction");
    $route->post("api", "get_post_list", "ApiController@getPostListAction");
    $route->post("api", "update_post", "ApiController@updatePostAction");
    $route->post("api", "delete_post", "ApiController@deletePostAction");
    ////
    $route->process();
?>