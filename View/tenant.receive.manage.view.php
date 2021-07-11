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
                        <div class="col-md-6">
                            <!-- <button class="btn btn-primary" onclick="searchBill()"><i class="fa fa-search"></i></button> -->
                        </div>
                        <div class="col-md-6">
                            <!-- <button class="btn btn-success" style="width: 200px;" data-toggle="modal" data-target="#createBillModal"><i class="fa fa-plus"></i> Tạo hóa đơn</button> -->
                        </div>
                        <div class="col-md-12" style="margin-top: 40px;">
                            <input type="hidden" id="transfer-id">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="25%">Người gửi</th>
                                        <th width="25%">Khách thuê</th>
                                        <th width="20%">Trạng thái</th>
                                        <th width="20%"></th>
                                    </tr>
                                </thead>
                                <tbody id="receive_list">
                                <?php
                                $room_pos = 0;
                                foreach($viewParams['receiveList'] as $item) { ?>
                                    <tr id="<?php echo $item["transfer_id"] ?>">
                                        <td><?php echo $item['host_transfer']['fullname'] ?></td>
                                        <td><?php echo $item['tenant']['fullname'] ?></td>
                                        <td><?php echo ($item['receive_status'] == "pending" ? "Chờ phản hồi" : "Chấp nhận") ?></td>
                                        <td>
                                            <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#viewTransferModal">Xem chi tiết</button> -->
                                            <button class="btn btn-success" data-toggle="modal" data-target="#approveTransferModal" onclick="document.getElementById('transfer-id').value=this.parentElement.parentElement.id; document.getElementById('receive-room').value='<?php echo $item['room_receive'] ?>';"><i class="fa fa-check"></i> Chấp nhận</button>
                                            <button class="btn btn-danger" data-toggle="modal" data-target="#rejectTransferModal" onclick="document.getElementById('transfer-id').value=this.parentElement.parentElement.id"><i class="fa fa-times"></i> Từ chối</button>
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
            <?php //getModal("transfer.view", $viewParams) ?>
            <?php getModal("transfer.approve", $viewParams) ?>
            <?php getModal("transfer.reject", $viewParams) ?>
<?php getTemplate("footer", $viewParams) ?>