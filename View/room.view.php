<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <div class="container">
        <?php getTemplate("topbar", $viewParams) ?>
        <?php getTemplate("menu", $viewParams) ?>
        <div style="min-height: 1000px; margin-top: 100px; margin-bottom: 60px;">
            <div class="room-detail row">
                <div class="col-md-12">
                    <div style="margin: 0 50px 0 50px; border: gray solid 1px; padding: 20px;">
                        <div class="post-title">
                            <?php echo $viewParams['room']['title'] ?>
                        </div>
                        <div class="post-time">
                            <?php echo date_format(date_create($viewParams['room']['time']), "d/m/Y H:i") ?>
                        </div>
                        <div class="post-content">
                        <?php echo $viewParams['room']['content'] ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 50px;">
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
                            <tr>
                                <td>Chủ trọ</td>
                                <td><?php echo $viewParams['host']['fullname'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" style="padding: 30px 50px 0 50px; text-align: center;">
                    <a href="tel:<?php echo $viewParams['host']['mobile'] ?>"><button class="btn btn-success" style="width: 200px;"><i class="fa fa-phone-alt"></i> <?php echo $viewParams['host']['mobile'] ?></button></a>
                    <button class="btn btn-warning" style="width: 200px; margin-left: 100px;" onclick="rentRequest()">Thuê ngay</button>
                </div>
            </div>
        </div>
<?php getTemplate("footer", $viewParams) ?>