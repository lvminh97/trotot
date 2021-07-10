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
				<div class="form-inline">
					
				</div>
                <div class="form-group">
                    <label for="">Chọn phòng muốn tới</label>
                    <select class="form-control" id="receive-room">
                    <?php
                    foreach($viewParams['roomList'] as $room){ 
                        if($room['status'] == "available") {?>
                        <option value="<?php echo $room['room_id'] ?>"><?php echo $room['name']." - ".getFullAddress($room) ?></option>
                    <?php
                        }  
                    } ?>
                    </select>
                </div>
                <div class="form-group">
					<label for="reject-feedback">Phản hồi</label>
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