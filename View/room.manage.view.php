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
                        <div class="col-md-12">
                            <button class="btn btn-success" style="width: 200px;" data-toggle="modal" data-target="#addRoomModal"><i class="fa fa-plus"></i> Thêm phòng</button>
                        </div>
                        <div class="col-md-12" style="margin-top: 40px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Hình ảnh</th>
                                        <th width="30%">Tên phòng</th>
                                        <th width="30%">Địa chỉ</th>
                                        <th width="15%"></th>
                                    </tr>
                                </thead>
                                <tbody id="room_list">
                                <?php
                                foreach($viewParams['roomList'] as $room) { ?>
                                    <tr id="<?php echo $room["room_id"] ?>">
                                        <td><?php echo $room['room_id'] ?></td>
                                        <td><img src="<?php echo convertToListImage($room['images'])[0] ?>" style="width: 80%; height: auto;"></td>
                                        <td><?php echo $room['name'] ?></td>
                                        <td><?php echo getFullAddress($room) ?></td>
                                        <td>
                                            <button class="btn btn-block btn-primary" onclick="window.location.href='?link=manage-room-detail&id='+this.parentElement.parentElement.id">Xem thông tin</button>
                                            <button class="btn btn-block btn-warning" data-toggle="modal" data-target="#updateRoomModal" onclick="loadRoom(this)">Chỉnh sửa</button>
                                            <button class="btn btn-block btn-danger" onclick="deleteRoom(this)">Xóa</button>
                                        </td>
                                    </tr>
                                <?php 
                                } ?>
                                </tbody>
                                <script>
                                    // loadRoomList('room_list')
                                </script>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
            <?php getModal("room.add", $viewParams) ?>
            <?php getModal("room.update", $viewParams) ?>
<?php getTemplate("footer", $viewParams) ?>