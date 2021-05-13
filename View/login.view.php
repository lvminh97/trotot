<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <div class="container">
        <?php getTemplate("topbar", $viewParams) ?>
        <?php getTemplate("menu", $viewParams) ?>
        <div class="row" style="margin-top: 40px; margin-bottom: 60px;">
            <div class="col-12">
                <h3 style="text-align: center;">Đăng nhập</h3>
                <hr>
            </div>
        </div>
        <div class="row" style="margin-bottom: 180px;">
            <div class="col-xl-3 col-lg-3 col-md-1 col-sm-1"></div>
            <div class="col-xl-6 col-lg-6 col-md-10 col-sm-10">
                <div class="form" id="signup-form">
                    <div>
                        <label>Tên đăng nhập (*)</label>
                        <input type="text" class="form-control" id="login-username" required>
                    </div>
                    <div>
                        <label>Mật khẩu (*)</label>
                        <input type="password" class="form-control" id="login-password" required>
                    </div>

                    <button class="btn btn-primary btn-block" style="margin-top: 30px;" onclick="login()"><i class="fa fas fa-sign-in-alt"></i> Đăng nhập ngay</button>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-1 col-sm-1"></div>
        </div>
        <?php getTemplate("footer", $viewParams) ?>