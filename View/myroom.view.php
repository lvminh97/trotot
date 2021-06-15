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
            <div style="margin-top: 60px;">
                <div class="my-room-item-renting">
                    <div>Phòng 1 - Số 35, ngõ 176, Lê Trọng Tấn</div>
                </div>
                <div class="my-room-item-renting">
                    <div>Phòng 2 - Số 35, ngõ 176, Lê Trọng Tấn</div>
                </div>
                <div class="my-room-item-return">
                    <div>Phòng 3 - Số 35, ngõ 176, Lê Trọng Tấn</div>
                </div>
                <div class="my-room-item-return">
                    <div>Phòng 4 - Số 35, ngõ 176, Lê Trọng Tấn</div>
                </div>
                <div class="my-room-item-pending">
                    <div>Phòng 5 - Số 35, ngõ 176, Lê Trọng Tấn</div>
                </div>
            </div>
        <?php 
        // print_r($viewParams['roomList']);
        ?>
        </div>
<?php getTemplate("footer", $viewParams) ?>