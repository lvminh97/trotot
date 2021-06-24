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
    $route->get("action", "logout", "ActionController@logoutAction");
    /// VIEW FOR CUSTOMER
    $route->get("site", "room_list", "ViewController@getRoomListForCustomerPage");
    $route->get("site", "room", "ViewController@getRoomPage");
    $route->get("site", "post", "ViewController@getPostPage");
    $route->get("site", "my_room", "ViewController@getMyRoomManagePage");
    $route->get("site", "my_room_detail", "ViewController@getMyRoomDetailPage");

    /// VIEW FOR HOST
    $route->get("link", "manage-home", "ViewController@getHostHomePage");
    $route->get("link", "manage-room", "ViewController@getManageRoomPage");
    $route->get("link", "manage-post", "ViewController@getManagePostPage");
    $route->get("link", "manage-bill", "ViewController@getManageBillPage");
    $route->get("link", "manage-rent", "ViewController@getManageRentPage");

    //// ACCOUNT API
    $route->post("api", "get_user_infor", "AccountController@getUserInfor");
    $route->post("api", "update_user_infor", "AccountController@updateUserInfor");
    $route->post("api", "change_password", "AccountController@changePassword");
    //// ROOM API
    $route->post("api", "add_room", "RoomController@addRoomAction");
    $route->get("api", "get_room", "RoomController@getRoomAction");
    $route->post("api", "get_room_list", "RoomController@getRoomListAction");
    $route->post("api", "update_room", "RoomController@updateRoomAction");
    $route->post("api", "delete_room", "RoomController@deleteRoomAction");
    //// POST API
    $route->post("api", "add_post", "PostController@addPostAction");
    $route->get("api", "get_post", "PostController@getPostAction");
    $route->post("api", "get_post_list", "PostController@getPostListAction");
    $route->post("api", "update_post", "PostController@updatePostAction");
    $route->post("api", "delete_post", "PostController@deletePostAction");
    //// RENT API
    $route->post("api", "rent", "RentController@rentAction");
    $route->post("api", "cancel_rent", "RentController@cancelRentAction");
    $route->post("api", "set_rent_status", "RentController@setRentStatusAction");
    $route->post("api", "approve_rent", "RentController@approveRentAction");
    $route->post("api", "get_rent_pending_list", "RentController@getRentPendingListAction");
    //// BILL API
    $route->post("api", "create_bill", "BillController@createBillAction");
    $route->post("api", "get_bill", "BillController@getBillAction");

    $route->process();
?>