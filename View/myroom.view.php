<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <div class="container">
        <?php getTemplate("topbar", $viewParams) ?>
        <?php getTemplate("menu", $viewParams) ?>
        <div style="min-height: 1000px; margin-top: 100px; margin-bottom: 60px;">
            <!-- <div style="text-align: center">
                <span style="font-size: 28px; font-weight: bolder; color: blue;">Phòng của tôi </span>
            </div> -->
            <div class="form-inline">
                <label>Chọn danh sách phòng: </label>
                <select class="form-control" style="margin-left: 40px;" onchange="roomTypeFilter(this.value)">
                    <option value="0">Đang thuê</option>
                    <option value="1">Đã từng thuê</option>
                    <option value="2">Đang gửi yêu cầu thuê</option>
                </select>
            </div>
            <div id="my-room-list" style="margin-top: 60px;">
            <?php 
            foreach($viewParams['roomList'] as $room) { 
            if($room['status'] == "renting") $class = "my-room-item-renting";
            elseif($room['status'] == "return") $class = "my-room-item-return";
            elseif($room['status'] == "pending") $class = "my-room-item-pending";
            else continue;
            ?>
                <div class="<?php echo $class ?>" style="padding-top: 15px; padding-bottom: 15px; border-bottom: solid 1px grey;">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="my-room-item-title"><a href="?site=my_room_detail&id=<?php echo $room['room_id'] ?>">
                                <?php echo $room['name'] ?> - <?php echo getFullAddress($room) ?></a>
                            </div>
                            <div>
                            <?php
                                $status = array('renting' => "Đang thuê",
                                                'return' => "Đã trả phòng",
                                                'pending' => "Đang chờ phê duyệt");    
                            ?>
                                <span>Tình trạng: </span><span><?php echo $status[$room['status']] ?></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <!-- <button class="btn btn-primary">Xem phòng</button> -->
                            <?php
                            if($room['status'] == "renting"){ ?>
                            <button class="btn btn-success" onclick="viewMyBill(this)">Xem hóa đơn</button>
                            <button class="btn btn-danger" onclick="returnRoom('<?php echo $room['room_id'] ?>')">Trả phòng</button>
                            <?php
                            } ?> 
                        </div>
                        <div class="col-md-12" style="display: none; margin-top: 25px;">
                            <?php
                            if($viewParams['billList'][$room['room_id']] !== null){ ?>
                            <div class="row" style="margin-bottom: 18px;">
                                <div class="col-md-5" style="font-size: 18px; font-weight: bolder;">Hóa đơn tháng <?php echo date("m/Y") ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="font-weight: bold;">Chi phí</div>
                                <div class="col-md-2" style="font-weight: bold;">Giá tiền (VND)</div>
                                <div class="col-md-1" style="font-weight: bold;">Số lượng</div>
                            </div>
                            <?php
                                $total = 0;
                                $bill = $viewParams['billList'][$room['room_id']];
                                foreach($bill['bill'] as $bill_item){ 
                                    $total += $bill_item['price'] * $bill_item['number'];
                                    ?>
                                <div class="row">
                                    <div class="col-md-2"><?php echo $bill_item['title'] ?></div>
                                    <div class="col-md-2"><?php echo $bill_item['price'] ?></div>
                                    <div class="col-md-1"><?php echo $bill_item['number'] ?></div>
                                </div>
                            <?php 
                                } ?>
                                <div class="row" style="margin-top: 20px; font-weight: bold; color: red;">
                                    <div class="col-md-2">Tổng tiền</div>
                                    <div class="col-md-2"><?php echo $total." VND" ?></div>
                                </div>
                            <?php 
                            } else{ ?>
                            <div class="row" style="margin-bottom: 18px;">
                                <div class="col-md-5" style="font-size: 18px; font-weight: bolder;">Chưa có hóa đơn tháng này</div>
                            </div>
                            <?php
                            } ?>
                        </div>
                    </div>
                </div>
            <?php 
            } ?>
            </div>
            <script>roomTypeFilter(0)</script>
        </div>
<?php getTemplate("footer", $viewParams) ?>