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
                            <!-- <input type="text" id="machine-search-text" class="form-control" style="width: 100%"> -->
                        </div>
                        <div class="col-md-1">
                            <!-- <button class="btn btn-primary"><i class="fa fa-search"></i></button> -->
                        </div>
                        <div class="col-md-6">
                            <!-- <button class="btn btn-success" style="width: 200px;" data-toggle="modal" data-target="#addPostModal"><i class="fa fa-plus"></i> Thêm bài đăng mới</button> -->
                        </div>
                        <div class="col-md-12" style="margin-top: 40px;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="20%">Người đăng</th>
                                        <th width="25%">Tiêu đề</th>
                                        <th width="15%">Thời gian</th>
                                        <th width="10%">Trạng thái</th>
                                        <th width="25%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <input type="hidden" id="approve-post-id">
                                <?php
                                foreach($viewParams['postList'] as $post) { ?>
                                    <tr id="<?php echo $post["post_id"] ?>">
                                        <td><?php echo $post['post_id'] ?></td>
                                        <td><?php echo $post['author'] ?></td>
                                        <td><?php echo $post['title'] ?></td>
                                        <td><?php echo getStdFormatTime($post['time']) ?></td>
                                        <td>
                                            <?php echo ($post['approval'] == "yes") ? "Phê duyệt" : "Chưa phê duyệt" ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" onclick="viewPost('<?php echo $post['room_id'] ?>')"><i class="fa fa-eye"></i> Xem</button>
                                            <button class="btn btn-success" onclick="approvePost(this.parentElement.parentElement.id, 'approve')"><i class="fa fa-check"></i> Phê duyệt</button>
                                            <button class="btn btn-danger" onclick="document.getElementById('approve-post-id').value=this.parentElement.parentElement.id" data-toggle="modal" data-target="#rejectPostModal"><i class="fa fa-times"></i> Từ chối</button>
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
            <?php getModal("post.reject", $viewParams) ?>
            <!-- End of Main Content -->
<?php getTemplate("footer", $viewParams) ?>