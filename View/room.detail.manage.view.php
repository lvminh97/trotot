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
                        <div class="col-md-8">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#rent_history">Lịch sử thuê phòng</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bill_history">Lịch sử hóa đơn</a></li>
                            </ul>
                            <div class="tab-content" style="margin-top: 20px; padding-left: 20px; padding-right: 20px;">
                                <div id="rent_history" class="tab-pane fade in active show">
                                    <table class="table table-stripe">
                                    <thead>
                                        <tr>
                                            <th width="30%">Thời gian</th>
                                            <th width="40%">Người thuê</th>
                                            <th width="40%">SĐT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($viewParams['rentList'] as $rent){ ?>
                                        <tr>
                                        <?php
                                        $begin = date_format(date_create($rent['begin_time']), "d/m/Y");
                                        if($rent['end_time'] != "9999-12-31")
                                            $end = date_format(date_create($rent['end_time']), "d/m/Y");
                                        else
                                            $end = "hiện tại";
                                        ?>
                                            <td><?php echo $begin." - ".$end ?></td>
                                            <td><?php echo $rent['fullname'] ?></td>
                                            <td><?php echo $rent['mobile'] ?></td>
                                        </tr>
                                    <?php
                                    } ?>
                                    </tbody>
                                    </table>
                                </div>
                                <div id="bill_history" class="tab-pane fade">
                                    <table class="table table-stripe">
                                    <thead>
                                        <tr>
                                            <th width="30%">Thời gian</th>
                                            <th width="40%">Số tiền</th>
                                            <th width="40%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    foreach($viewParams['billList'] as $bill) {?>
                                        <tr>
                                            <td><?php echo "Tháng ".date_format(date_create($bill['time']), "m/Y") ?></td>
                                            <?php
                                            $total = 0;
                                            foreach($bill['bill'] as $item){
                                                $total += $item['price'] * $item['number'];
                                            }
                                            ?>
                                            <td><?php echo number_format($total, 0, ".", ",")." VND" ?></td>
                                        </tr>
                                    <?php
                                    } ?>
                                    </tbody>
                                    </table>
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