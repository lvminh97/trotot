<div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Thêm bài đăng mới</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="addPostForm">
					<div class="form-group">
						<label for="machine_name">Tiêu đề</label>
						<input type="text" class="form-control" id="post_title" style="width: 100%;">
					</div>
					<div class="form-group">
						<label for="machine_doc">Chọn phòng</label>
                        <select class="form-control" id="post_room">
                            <option value="0">Mặc định</option>
                        </select>
					</div>
                    
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
				<button class="btn btn-primary" data-dismiss="modal" onclick="addRoom()">Thêm</button>
			</div>
		</div>
	</div>
</div>