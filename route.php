<?php
    require_once "Controller/Route.php";
    $route = new Route("ViewController@getIndex");
    // Dang ky tai khoan
    $route->get("site", "signup", "ViewController@getSignupPage");
    $route->post("action", "signup", "AccountController@signupAction");
    // Dang nhap
    $route->get("site", "login", "ViewController@getLoginPage");
    $route->post("action", "login", "AccountController@loginAction");
    $route->get("action", "login", "ViewController@getIndex");
    $route->get("action", "logout", "AccountController@logoutAction");
    /// VIEW FOR CUSTOMER
    $route->get("site", "room_list", "ViewController@getRoomListForCustomerPage");
    $route->get("site", "room", "ViewController@getRoomPage");
    $route->get("site", "room_demo", "ViewController@getRoomDemoPage");
    $route->get("site", "post", "ViewController@getPostPage");
    $route->get("site", "my_room", "ViewController@getMyRoomManagePage");
    $route->get("site", "my_room_detail", "ViewController@getMyRoomDetailPage");

    /// VIEW FOR HOST
    $route->get("link", "manage-home", "ViewController@getHostHomePage");
    $route->get("link", "manage-room", "ViewController@getManageRoomPage");
    $route->get("link", "manage-room-detail", "ViewController@getManageRoomDetailPage");
    $route->get("link", "manage-post", "ViewController@getManagePostPage");
    $route->get("link", "manage-bill", "ViewController@getManageBillPage");
    $route->get("link", "manage-rent", "ViewController@getManageRentPage");
    $route->get("link", "manage-transfer", "ViewController@getManageTransferTenantPage");
    $route->get("link", "manage-receive", "ViewController@getManageReceiveTenantPage");
    $route->get("link", "statistic", "ViewController@getManageStatisticPage");

    // VIEW FOR ADMIN
    $route->get("link", "approve-post", "ViewController@getApprovePostPage");
    $route->get("link", "manage-host", "ViewController@getManageHostPage");

    //// ACCOUNT API
    $route->post("api", "get_user_infor", "AccountController@getUserInfor");
    $route->post("api", "update_user_infor", "AccountController@updateUserInfor");
    $route->post("api", "change_password", "AccountController@changePassword");
    $route->post("api", "search_host", "AccountController@searchHostAction");
    $route->post("api", "delete_host", "AccountController@deleteHostAction");
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
    $route->post("api", "approve_post", "PostController@approvePostAction");
    //// RENT API
    $route->post("api", "rent", "RentController@rentAction");
    $route->post("api", "cancel_rent", "RentController@cancelRentAction");
    $route->post("api", "set_rent_status", "RentController@setRentStatusAction");
    $route->post("api", "approve_rent", "RentController@approveRentAction");
    $route->post("api", "get_rent_pending_list", "RentController@getRentPendingListAction");
    $route->post("api", "get_tenant", "RentController@getTenantAction");
    $route->post("api", "kick_tenant", "RentController@kickTenantAction");
    $route->post("api", "return_room", "RentController@returnRoomAction");
    //// TRANSFER API
    $route->post("api", "transfer_tenant", "TransferController@transferAction");
    $route->post("api", "approve_transfer", "TransferController@approveAction");
    $route->post("api", "get_transfer_room_list", "TransferController@getTransferRoomListAction");
    $route->post("api", "tenant_approve_transfer", "TransferController@tenantApproveTransferAction");
    $route->post("api", "delete_transfer", "TransferController@deleteTransferAction");
    //// BILL API
    $route->post("api", "create_bill", "BillController@createBillAction");
    $route->post("api", "get_bill", "BillController@getBillAction");
    $route->post("api", "delete_bill", "BillController@deleteBillAction");
    $route->post("api", "update_bill_status", "BillController@updateBillStatusAction");

    $route->process();
?>