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
                        <div class="price"><i class="fa fa-dollar-sign"></i> <?php echo $room['price'] ?> VND</div>
                        <div class="address"><i class="fa fas fa-map-marker"></i> <?php echo getFullAddress($room) ?></div>
                    </div>
                </div>
            <?php
            } ?>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-1"></div>
            <div class="col-xl-3 col-lg-3 col-md-3 search-form">
                <div style="font-size: 20px; font-weight: bolder; text-align: center;">
                    Tìm kiếm phòng
                </div>
                <?php
                    if(isset($viewParams['url_param']['province'])) $province = $viewParams['url_param']['province'];
                    else $province = "";
                    if(isset($viewParams['url_param']['district'])) $district = $viewParams['url_param']['district'];
                    else $district = "";
                    if(isset($viewParams['url_param']['subdistrict'])) $subdistrict = $viewParams['url_param']['subdistrict'];
                    else $subdistrict = "";
                    if(isset($viewParams['url_param']['street'])) $street = $viewParams['url_param']['street'];
                    else $street = "";
                    if(isset($viewParams['url_param']['area1'])) $area1 = $viewParams['url_param']['area1'];
                    else $area1 = "0";
                    if(isset($viewParams['url_param']['area2'])) $area2 = $viewParams['url_param']['area2'];
                    else $area2 = "0";
                    if(isset($viewParams['url_param']['price1'])) $price1 = $viewParams['url_param']['price1'];
                    else $price1 = "0";
                    if(isset($viewParams['url_param']['price2'])) $price2 = $viewParams['url_param']['price2'];
                    else $price2 = "0";
                ?>
                <div class="form-group" style="margin-top: 20px;">
                    <label>Tỉnh/Thành phố</label>
                    <input id="search-key-province" type="text" class="form-control" value="<?php echo $province ?>">
                </div>
                <div class="form-group" style="margin-top: 10px;">
                    <label>Quận/Huyện</label>
                    <input id="search-key-district" type="text" class="form-control" value="<?php echo $district ?>">
                </div>
                <div class="form-group" style="margin-top: 10px;">
                    <label>Phường/Xã</label>
                    <input id="search-key-subdistrict" type="text" class="form-control" value="<?php echo $subdistrict ?>">
                </div>
                <div class="form-group" style="margin-top: 10px;">
                    <label>Đường/Phố</label>
                    <input id="search-key-street" type="text" class="form-control" value="<?php echo $street ?>">
                </div>
                <div class="form-group" style="margin-top: 10px;">
                    <label>Diện tích (m<sup>2</sup>)</label>
                    <div class="row" style="padding: 9px;">
                        <input id="search-key-area1" type="number" class="form-control col-md-5" value="<?php echo $area1 ?>" step="1" min="0" max="100">
                        <div class="col-md-2" style="font-size: 25px; text-align: center;"> - </div>
                        <input id="search-key-area2" type="number" class="form-control col-md-5" value="<?php echo $area2 ?>" step="1" min="0" max="100">
                    </div>
                </div>
                <div class="form-group" style="margin-top: 10px;">
                    <label>Giá (VND)</label>
                    <div class="row" style="padding: 9px;">
                        <input id="search-key-price1" type="number" class="form-control col-md-5" value="<?php echo $price1 ?>" step="100000">
                        <div class="col-md-2" style="font-size: 25px; text-align: center;"> - </div>
                        <input id="search-key-price2"type="number" class="form-control col-md-5" value="<?php echo $price2 ?>" step="100000">
                    </div>
                </div>
                <button class="btn btn-danger btn-block" onclick="searchRoom()"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
        </div>
<?php getTemplate("footer", $viewParams) ?>