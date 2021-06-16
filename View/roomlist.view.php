<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <div class="container">
        <?php getTemplate("topbar", $viewParams) ?>
        <?php getTemplate("menu", $viewParams) ?>
        <div class="row" style="min-height: 1000px; margin-top: 100px; margin-bottom: 60px;">
            <div class="col-xl-8 col-lg-8 col-md-8">
            <?php 
            foreach($viewParams['roomList'] as $room){ ?>
                <div class="room-item row">
                    <div class="col-md-3">
                    <?php 
                        $image = convertToListImage($room['images'])[0];
                    ?>
                        <img src="<?php echo $image ?>" style="width: auto; max-width: 90%; height: 150px;">
                    </div>
                    <div class="col-md-9">
                        <a href="?site=room&id=<?php echo $room['room_id'] ?>" class="title"><?php echo $room['title'] ?></a>
                        <div class="area"><i class="fa fa-chart-area"></i> <?php echo $room['area'] ?>m<sup>2</sup></div>
                        <div class="address"><i class="fa fas fa-map-marker"></i> <?php echo getFullAddress($room) ?></div>
                    </div>
                </div>
            <?php
            } ?>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-1"></div>
            <div class="col-xl-3 col-lg-3 col-md-3">
                Tìm kiếm phòng
                <div class="form-group">
                    <label>Tỉnh/Thành phố</label>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
<?php getTemplate("footer", $viewParams) ?>