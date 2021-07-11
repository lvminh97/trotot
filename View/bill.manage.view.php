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
                    <?php 
                    $year = explode("-", $viewParams['time'])[0];
                    $month = explode("-", $viewParams['time'])[1]; ?>
                        <div class="col-md-2">
                            <select id="bill-month-search" class="form-control">
                                <option value="01" <?php echo ($month == "01" ? "selected" : "") ?>>Tháng 1</option>
                                <option value="02" <?php echo ($month == "02" ? "selected" : "") ?>>Tháng 2</option>
                                <option value="03" <?php echo ($month == "03" ? "selected" : "") ?>>Tháng 3</option>
                                <option value="04" <?php echo ($month == "04" ? "selected" : "") ?>>Tháng 4</option>
                                <option value="05" <?php echo ($month == "05" ? "selected" : "") ?>>Tháng 5</option>
                                <option value="06" <?php echo ($month == "06" ? "selected" : "") ?>>Tháng 6</option>
                                <option value="07" <?php echo ($month == "07" ? "selected" : "") ?>>Tháng 7</option>
                                <option value="08" <?php echo ($month == "08" ? "selected" : "") ?>>Tháng 8</option>
                                <option value="09" <?php echo ($month == "09" ? "selected" : "") ?>>Tháng 9</option>
                                <option value="10" <?php echo ($month == "10" ? "selected" : "") ?>>Tháng 10</option>
                                <option value="11" <?php echo ($month == "11" ? "selected" : "") ?>>Tháng 11</option>
                                <option value="12" <?php echo ($month == "12" ? "selected" : "") ?>>Tháng 12</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="bill-year-search" class="form-control" value="<?php echo $year ?>">
                                <option value="2020" <?php echo ($year == "2020" ? "selected" : "") ?>>2020</option>
                                <option value="2021" <?php echo ($year == "2021" ? "selected" : "") ?>>2021</option>
                                <option value="2022" <?php echo ($year == "2022" ? "selected" : "") ?>>2022</option>
                                <option value="2023" <?php echo ($year == "2023" ? "selected" : "") ?>>2023</option>
                                <option value="2024" <?php echo ($year == "2024" ? "selected" : "") ?>>2024</option>
                                <option value="2025" <?php echo ($year == "2025" ? "selected" : "") ?>>2025</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary" onclick="searchBill()"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-md-5">
                            <button class="btn btn-success" style="width: 200px;" data-toggle="modal" data-target="#createBillModal"><i class="fa fa-plus"></i> Tạo hóa đơn</button>
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
                                foreach($viewParams['billList'] as $bill) { ?>
                                    <tr id="<?php echo $bill["bill_id"] ?>">
                                        <td><?php echo $bill['room_id'] ?></td>
                                        <td><?php echo $viewParams['roomList'][$bill['room_id']]['name'] ?></td>
                                        <td><?php echo getFullAddress($viewParams['roomList'][$bill['room_id']]) ?></td>
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