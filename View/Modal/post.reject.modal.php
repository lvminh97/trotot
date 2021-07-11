<div class="modal fade" id="rejectPostModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Từ chối phê duyệt bài đăng</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="reject-feedback">Lý do từ chối</label>
					<textarea class="form-control" id="reject-feedback" style="height: 180px;"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="approvePost(document.getElementById('approve-post-id').value, 'delete')">Xác nhận</button>
			</div>
		</div>
	</div>
</div>