<?php
    require_once "Controller/Route.php";
    $route = new Route("ViewController@getIndex");
    // Dang ky tai khoan
    $route->get("site", "signup", "ViewController@getSignupPage");
    $route->post("action", "signup", "ActionController@signupAction");
    // Dang nhap
    $route->get("site", "login", "ViewController@getLoginPage");
    $route->post("action", "login", "ActionController@loginAction");
    $route->get("action", "login", "ViewController@getIndex");
    $route->get("action", "login", "ActionController@logoutAction");
    
    /// VIEW FOR CUSTOMER
    $route->get("site", "room_list", "ViewController@getRoomListForCustomerPage");
    $route->get("site", "post", "ViewController@getPostPage");

    /// VIEW FOR HOST
    $route->get("link", "manage-home", "ViewController@getHostHomePage");
    $route->get("link", "manage-room", "ViewController@getManageRoomPage");
    $route->get("link", "manage-post", "ViewController@getManagePostPage");

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