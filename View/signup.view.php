<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <div class="container">
        <?php getTemplate("topbar", $viewParams) ?>
        <?php getTemplate("menu", $viewParams) ?>
        <div class="row" style="margin-top: 40px; margin-bottom: 60px;">
            <div class="col-12">
                <h3 style="text-align: center;">Đăng ký tài khoản</h3>
                <hr>
            </div>
        </div>
        <div class="row" style="margin-bottom: 100px;">
            <div class="col-xl-3 col-lg-3 col-md-1 col-sm-1"></div>
            <div class="col-xl-6 col-lg-6 col-md-10 col-sm-10">
                <div class="form" id="signup-form">
                    <div>
                        <label>Họ và tên (*)</label>
                        <input type="text" class="form-control" id="signup-fullname" required>
                    </div>
                    <div>
                        <label>Số điện thoại (*)</label>
                        <input type="text" class="form-control" id="signup-mobile" required>
                    </div>
                    <div>
                        <label>Email </label>
                        <input type="text" class="form-control" id="signup-email">
                    </div>
                    <div>
                        <label>Tên đăng nhập (*)</label>
                        <input type="text" class="form-control" id="signup-username" required>
                    </div>
                    <div>
                        <label>Mật khẩu (*) </label>
                        <input type="password" class="form-control" id="signup-password" required>
                    </div>
                    <div>
                        <label>Xác nhận mật khẩu (*) </label>
                        <input type="password" class="form-control" id="signup-password2" required>
                    </div>
                    <div class="form-group" style="margin-top: 10px;">
                        <label>Loại tài khoản: </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="signup-type-tenant" name="signup-type-tenant" checked> Người thuê &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="signup-type-host" name="signup-type-tenant"> Chủ trọ
                    </div>

                    <button class="btn btn-success btn-block" style="margin-top: 30px;" onclick="signup()"><i class="fa fas fa-user-plus"></i> Đăng ký tài khoản</button>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-1 col-sm-1"></div>
        </div>
        <?php getTemplate("footer", $viewParams) ?>