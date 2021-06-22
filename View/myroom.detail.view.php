<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <div class="container">
        <?php getTemplate("topbar", $viewParams) ?>
        <?php getTemplate("menu", $viewParams) ?>
        <div style="min-height: 1000px; margin-top: 100px; margin-bottom: 60px;">
            <div class="room-detail row">
                <div class="col-md-12">
                    <div style="padding: 10px;">
                        <div class="post-title" style="text-align: center;">
                            <?php echo $viewParams['room']['name'] ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 25px;">
                <?php $images = convertToListImage($viewParams['room']['images']); ?>
                    <div id="carouselExampleControls" class="carousel slide room-image-list" data-ride="carousel">
                        <ol class="carousel-indicators">
                        <?php 
                            for($i = 0; $i < count($images); $i++){ ?>
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" class="<?php echo ($i == "0" ? "active" : "") ?>"></li>
                        <?php 
                            } ?>
                        </ol>
                        <div class="carousel-inner">
                        <?php
                            $i = 0;
                            foreach($images as $image) { ?>
                            <div class="carousel-item <?php echo ($i == "0" ? "active" : "") ?>" style="text-align: center;">
                                <img src="<?php echo $image ?>" class="room-image">
                            </div>
                        <?php
                            $i++; 
                            } ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-12 room-info" style="padding: 0 50px 0 50px;">
                    <table class="table table-striped" style="margin-top: 20px;">
                        <tbody>
                            <tr>
                                <td width="35%">Địa chỉ</td>
                                <td><?php echo getFullAddress($viewParams['room']) ?></td>
                            </tr>
                            <tr>
                                <td>Diện tích</td>
                                <td><?php echo $viewParams['room']['area'] ?> m<sup>2</sup></td>
                            </tr>
                            <tr>
                                <td>Giá thuê</td>
                                <td><?php echo number_format($viewParams['room']['price']) ?> VND/tháng</td>
                            </tr>
                            <!-- <tr>
                                <td>Chủ trọ</td>
                                <td><?php //echo $viewParams['host']['fullname'] ?></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php getTemplate("footer", $viewParams) ?>