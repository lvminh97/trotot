<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php getTemplate("sidebar.manage", $viewParams); ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php getTemplate("topbar.manage", $viewParams); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-6" style="margin-top: 40px; padding-left: 50px; padding-right: 50px;">
                            <div style="margin-bottom: 30px; font-size: 20px; font-weight: bold;">Thông tin phòng</div>
                            <div>
                                <?php $room = $viewParams['room'] ?>
                                <div class="form-group">
                                    <label>Tên phòng</label>
                                    <input type="text" class="form-control" disabled value="<?php echo $room['name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" class="form-control" disabled value="<?php echo getFullAddress($room) ?>">
                                </div>
                                <div class="form-group">
                                    <label>Giá thuê</label>
                                    <input type="text" class="form-control" disabled value="<?php echo number_format($room['price'], 0, ".", ",")." VND" ?>">
                                </div>
                                <div class="form-group">
                                    <label>Diện tích</label>
                                    <input type="text" class="form-control" disabled value="<?php echo $room['area']." m2" ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top: 40px; padding-left: 50px; padding-right: 50px;">
                            <div style="margin-bottom: 30px; font-size: 20px; font-weight: bold;">Thông tin người thuê</div>
                            <?php 
                            $tenant = $viewParams['tenant'];
                            // print_r($tenant);
                            if($tenant !== null){ ?>
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control" disabled value="<?php echo $tenant['fullname'] ?>">
                            </div>
                            <div class="form-group">
                                <label>SĐT</label>
                                <input type="text" class="form-control" disabled value="<?php echo $tenant['mobile'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" disabled value="<?php echo $tenant['email'] ?>">
                            </div>
                            <?php
                            } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Lịch sử thuê phòng</a></li>
                                <li><a data-toggle="tab" href="#menu1">Lịch sử hóa đơn</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <h3>HOME</h3>
                                    <p>Some content.</p>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <h3>Menu 1</h3>
                                    <p>Some content in menu 1.</p>
                                </div>
                                <div id="menu2" class="tab-pane fade">
                                    <h3>Menu 2</h3>
                                    <p>Some content in menu 2.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
            <?php getModal("room.add", $viewParams) ?>
            <?php getModal("room.update", $viewParams) ?>
<?php getTemplate("footer", $viewParams) ?>