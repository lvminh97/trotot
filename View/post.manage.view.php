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
                            <button class="btn btn-success" style="width: 200px;" data-toggle="modal" data-target="#addPostModal"><i class="fa fa-plus"></i> Thêm bài đăng mới</button>
                        </div>
                        <div class="col-md-12" style="margin-top: 40px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="15%">Tiêu đề</th>
                                        <th width="15%">Thời gian</th>
                                        <th width="15%">Phòng</th>
                                        <th width="25%">Nội dung</th>
                                        <th width="10%"></th>
                                        <th width="10%">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody id="room_list">
                                <?php
                                foreach($viewParams['postList'] as $post) { ?>
                                    <tr id="<?php echo $post["post_id"] ?>">
                                        <td><?php echo $post['post_id'] ?></td>
                                        <td><?php echo $post['title'] ?></td>
                                        <td><?php echo getStdFormatTime($post['time']) ?></td>
                                        <td><?php echo $post['name']." - ".getFullAddress($post) ?></td>
                                        <td><?php echo $post['content'] ?></td>
                                        <td>
                                            <button class="btn btn-block btn-warning" data-toggle="modal" data-target="#updatePostModal" onclick="loadPost(this)">Chỉnh sửa</button>
                                            <button class="btn btn-block btn-danger" onclick="deletePost(this)">Xóa</button>
                                        </td>
                                        <td>
                                            <?php echo ($post['approval'] == "yes") ? "Phê duyệt" : "Chưa phê duyệt" ?>
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
            <?php getModal("post.add", $viewParams) ?>
            <?php getModal("post.update", $viewParams) ?>
<?php getTemplate("footer", $viewParams) ?>