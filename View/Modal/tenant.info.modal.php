<div class="modal fade" id="tenantInfoModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Thông tin người thuê phòng</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div id="tenant-info" class="modal-body">
                <input type="hidden" id="tenant-room">
                <input type="hidden" id="tenant-id">
				<div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-4" style="font-weight: bold;">Họ tên</div>
                    <div class="col-md-8" id="tenant-fullname"></div>
                </div>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-4" style="font-weight: bold;">Email</div>
                    <div class="col-md-8" id="tenant-email"></div>
                </div>
                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-4" style="font-weight: bold;">Số điện thoại</div>
                    <div class="col-md-8" id="tenant-mobile"></div>
                </div>
                <div class="row" style="margin-bottom: 40px;">
                    <div class="col-md-4"><button class="btn btn-success btn-block"><i class="fa fa-phone-alt"></i> Liên hệ</button></div>
                    <div class="col-md-4"><button class="btn btn-danger btn-block" onclick="kickTenant()">Chấm dứt thuê</button></div>
                    <div class="col-md-4"><button class="btn btn-primary btn-block" onclick="openTransferForm()">Gửi khách trọ</button></div>
                </div>
                <div id="transferForm" style="display: none; padding: 20px; border: solid 2px grey; border-radius: 10px;">
                    <div class="row" style="margin-bottom: 24px;">
                        <div class="col-md-12" style="font-size: 18px; font-weight: bold; text-align: center;">Chọn chủ trọ muốn gửi khách</div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <label class="col-md-4 col-form-label" style="font-weight: bold;">Họ tên</label>
                        <input type="text" class="col-md-8 form-control" id="host-name">
                    </div>
                    <div class="row" style="margin-bottom: 15px;">
                        <label class="col-md-4 col-form-label" style="font-weight: bold;">Số điện thoại</label>
                        <input type="text" class="col-md-8 form-control" id="host-mobile">
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" style="padding-left: 0;">
                            <button class="btn btn-primary" style="width: 60%;" onclick="hostFilter()">Tìm</button>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                        <label class="col-md-4 col-form-label" style="font-weight: bold;">Chủ trọ</label>
                        <select id="host-name-list" class="form-control col-md-8">

                        </select>
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-4"></div>
                        <div class="col-md-8" style="padding-left: 0;">
                            <button class="btn btn-primary" style="width: 60%;" onclick="transferTenant()" data-dismiss="modal">Xác nhận gửi</button>
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<!-- <button class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button> -->
			</div>
		</div>
	</div>
</div>