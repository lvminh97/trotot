<div class="modal fade" id="approveTransferModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Yêu cầu chuyển phòng</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="transfer_id">
				<div class="form-group">
					<label>Phê duyệt</label>
					<select id="approval" class="form-control" onchange="if(this.value=='reject') document.getElementById('room_sel').style.display='none'; else document.getElementById('room_sel').style.display='block';">
						<option value="approve">Đồng ý</option>
						<option value="reject">Từ chối</option>
					</select>
				</div>
                <div class="form-group" id="room_sel">
                    <label for="">Chọn phòng muốn tới</label>
                    <select class="form-control" id="receive-room">
                    
                    </select>
                </div>
                <div class="form-group">
					<label for="approve-feedback">Phản hồi</label>
					<textarea class="form-control" id="approve-feedback" style="height: 180px;"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
                <button class="btn btn-primary" data-dismiss="modal" onclick="tenantApproveTransfer()">Xác nhận</button>
			</div>
		</div>
	</div>
</div>