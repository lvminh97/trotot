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
            ?>
                <div class="<?php echo $class ?>">
                    <div class="my-room-item-title"><a href="?site=my_room_detail&id=<?php echo $room['room_id'] ?>">
                        <?php echo $room['name'] ?> - <?php echo getFullAddress($room) ?></a>
                    </div>
                    <div>
                        <span>Tình trạng: </span><span>Đang thuê</span>
                    </div>
                </div>
            <?php 
            } ?>
            </div>
            <script>roomTypeFilter(0)</script>
        </div>
<?php getTemplate("footer", $viewParams) ?>