<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <div class="container">
        <?php getTemplate("topbar", $viewParams) ?>
        <?php getTemplate("menu", $viewParams) ?>
        <div class="row" style="min-height: 1000px; margin-top: 100px; margin-bottom: 60px;">
            <div class="col-xl-9 col-lg-9 col-md-9">
            <?php 
            foreach($viewParams['roomList'] as $room){ ?>
                <div class="room-item-row" style="margin-top: 20px; margin-bottom: 20px;">
                    <a href="?site=room&id=1" class="title"><?php echo $room['name'] ?></a>
                    <br>
                    <span>Địa chỉ: <?php echo getFullAddress($room) ?></span>
                </div>
            <?php
            } ?>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3">
                Tìm kiếm phòng
                <div class="form-group">
                    <label>Tỉnh/Thành phố</label>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
<?php getTemplate("footer", $viewParams) ?>