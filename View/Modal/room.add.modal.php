<div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Thêm phòng mới</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="addRoomForm" enctype="multipart/form-data">
					<div class="form-group">
						<label for="machine_name">Tên phòng</label>
						<input type="text" class="form-control" id="room_name" style="width: 100%;">
					</div>
					<div class="form-group">
						<label>Hình ảnh phòng</label>
						<div class="row" id="imgChooserPanel">
							<div class="col-md-3">
								<div style="width: 100%; height: 100%;">
									<button class="close" type="button" style="position: relative; top: 3px; left: -28px; display: none; z-index: 100;" onclick="delImgChooser(this)">×</button>
									<input type="file" name="room_image" style="display: none;">
									<img src="./assets/img/plus.png" class="imgChooserBg" onclick="chooseImg(this, 'room_image')">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="machine_doc">Diện tích (m<sup>2</sup>)</label>
						<input type="text" class="form-control" id="room_area" style="width: 100%;">
					</div>
                    <div class="form-group">
						<label for="machine_doc">Giá thuê (VND)</label>
						<input type="text" class="form-control" id="room_price" style="width: 100%;">
					</div>
                    <div class="form-group">
						<label for="machine_doc">Số</label>
						<input type="text" class="form-control" id="room_location_num" style="width: 100%;">
					</div>
                    <div class="form-group">
						<label for="machine_doc">Ngõ</label>
						<input type="text" class="form-control" id="room_location_alley" style="width: 100%;">
					</div>
                    <div class="form-group">
						<label for="machine_doc">Phố / Đường</label>
						<input type="text" class="form-control" id="room_location_street" style="width: 100%;">
					</div>
                    <div class="form-group">
						<label for="machine_doc">Phường / Xã</label>
						<input type="text" class="form-control" id="room_location_subdistrict" style="width: 100%;">
					</div>
					<div class="form-group">
						<label for="machine_doc">Quận / Huyện</label>
						<input type="text" class="form-control" id="room_location_district" style="width: 100%;">
					</div>
					<div class="form-group">
						<label for="machine_doc">Tỉnh / Thành Phố</label>
						<input type="text" class="form-control" id="room_location_province" style="width: 100%;">
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