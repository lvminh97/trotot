<?php if (!defined('__CONTROLLER__')) return; ?>
<?php getTemplate("header", $viewParams); ?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php getTemplate("sidebar.admin", $viewParams); ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php getTemplate("topbar.manage", $viewParams); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" id="machine-search-text" class="form-control" style="width: 100%">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-md-6">
                            <!-- <button class="btn btn-success" style="width: 200px;" data-toggle="modal" data-target="#addPostModal"><i class="fa fa-plus"></i> Thêm bài đăng mới</button> -->
                        </div>
                        <div class="col-md-12" style="margin-top: 40px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="25%">Tên</th>
                                        <th width="25%">SĐT</th>
                                        <th width="25%">Email</th>
                                        <th width="20%"></th>
                                    </tr>
                                </thead>
                                <tbody id="room_list">
                                <?php
                                foreach($viewParams['hostList'] as $host) { ?>
                                    <tr id="<?php echo $host["user_id"] ?>">
                                        <td><?php echo $host['user_id'] ?></td>
                                        <td><?php echo $host['fullname'] ?></td>
                                        <td><?php echo $host['mobile'] ?></td>
                                        <td><?php echo $host['email'] ?></td>
                                        <td>
                                            <!-- <button class="btn btn-primary" onclick="viewPost('<?php echo $post['room_id'] ?>')"><i class="fa fa-eye"></i> Xem</button>
                                            <button class="btn btn-success" onclick="approvePost(this.parentElement.parentElement.id, 'approve')"><i class="fa fa-check"></i> Phê duyệt</button> -->
                                            <button class="btn btn-danger" onclick="removeHost(this.parentElement.parentElement.id)"><i class="fa fa-times"></i> Xóa tài khoản</button>
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
<?php getTemplate("footer", $viewParams) ?>