<div class="modal fade" id="tenantInfoModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Thông tin người thuê phòng</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div id="tenant-info" class="modal-body" style="height: 300px;">
                <input type="hidden" id="tenant-room">
				<div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-4" style="font-weight: bold;">Họ tên</div>
                    <div class="col-md-8" id="tenant-fullname"></div>
                </div>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-4" style="font-weight: bold;">Email</div>
                    <div class="col-md-8" id="tenant-email"></div>
                </div>
                <div class="row" style="margin-bottom: 40px;">
                    <div class="col-md-4" style="font-weight: bold;">Số điện thoại</div>
                    <div class="col-md-8" id="tenant-mobile"></div>
                </div>
                <div class="row">
                    <div class="col-md-4"><button class="btn btn-success btn-block"><i class="fa fa-phone-alt"></i> Liên hệ</button></div>
                    <div class="col-md-4"><button class="btn btn-danger btn-block" onclick="kickTenant()">Chấm dứt thuê</button></div>
                    <div class="col-md-4"><button class="btn btn-primary btn-block">Gửi khách trọ</button></div>
                </div>
			</div>
			<div class="modal-footer">
				<!-- <button class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button> -->
			</div>
		</div>
	</div>
</div>