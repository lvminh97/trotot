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
                        <div class="col-md-3">
                            <!-- <button class="btn btn-primary" onclick="searchBill()"><i class="fa fa-search"></i></button> -->
                        </div>
                        <div class="col-md-5">
                            <!-- <button class="btn btn-success" style="width: 200px;" data-toggle="modal" data-target="#createBillModal"><i class="fa fa-plus"></i> Tạo hóa đơn</button> -->
                        </div>
                        <div class="col-md-12" style="margin-top: 40px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Phòng</th>
                                        <th width="30%">Địa chỉ</th>
                                        <th width="20%">Trạng thái</th>
                                        <th width="25%"></th>
                                    </tr>
                                </thead>
                                <tbody id="bill_list">
                                <?php
                                $room_pos = 0;
                                foreach($viewParams['billList'] as $bill) { ?>
                                    <tr id="<?php echo $bill["bill_id"] ?>">
                                        <td><?php echo $bill['room_id'] ?></td>
                                        <?php 
                                        while(true){
                                            if($viewParams['roomList'][$room_pos]['room_id'] == $bill['room_id']) break;
                                            if($room_pos + 1 < count($viewParams['roomList'])) $room_pos++;
                                            else break;
                                        }?>
                                        <td><?php echo $viewParams['roomList'][$room_pos]['name'] ?></td>
                                        <td><?php echo getFullAddress($viewParams['roomList'][$room_pos]) ?></td>
                                        <td><?php echo ($bill['status'] == "pending" ? "Chưa thanh toán" : "Đã thanh toán") ?></td>
                                        <td>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#viewBillModal" onclick="viewBill(this.parentElement.parentElement.id)">Xem chi tiết</button>
                                        <?php
                                        if($bill['status'] == "pending"){ ?>
                                            <button class="btn btn-success" onclick="updateBill(this.parentElement.parentElement.id, 'paid')">Đã thanh toán</button>
                                        <?php
                                        } else { ?>
                                            <button class="btn btn-warning" onclick="updateBill(this.parentElement.parentElement.id, 'pending')">Chưa thanh toán</button>
                                        <?php 
                                        } ?>
                                            <button class="btn btn-danger" onclick="deleteBill(this.parentElement.parentElement.id)"><i class="fa fa-trash"></i> Xóa</button>    
                                        </td>
                                    </tr>
                                <?php 
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
            <?php getModal("bill.create", $viewParams) ?>
            <?php getModal("bill.view", $viewParams) ?>
<?php getTemplate("footer", $viewParams) ?>