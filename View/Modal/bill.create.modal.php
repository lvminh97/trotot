<div class="modal fade" id="createBillModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Lập hóa đơn</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" style="height: 580px;">
				<div class="row" style="margin-bottom: 12px;">
					<label class="col-md-3 col-form-label" style="padding-left: 25px;">Phòng</label>
					<select id="bill-room" class="form-control col-md-8">
					<?php
					foreach($viewParams['roomList'] as $room){ ?>
						<option value="<?php echo $room['room_id'] ?>">
						<?php echo $room['name']." - ".getFullAddress($room) ?>
						</option>
					<?php 
					} ?>	
					</select>
				</div>
				<?php
				$year = explode("-", $viewParams['time'])[0];
				$month = explode("-", $viewParams['time'])[1]; ?>
				<div class="row" style="margin-bottom: 12px;">
					<label class="col-md-3 col-form-label" style="padding-left: 25px;">Tháng</label>
					<select id="bill-month" class="form-control col-md-8">
					<option value="01" <?php echo ($month == "01" ? "selected" : "") ?>>Tháng 1</option>
						<option value="02" <?php echo ($month == "02" ? "selected" : "") ?>>Tháng 2</option>
						<option value="03" <?php echo ($month == "03" ? "selected" : "") ?>>Tháng 3</option>
						<option value="04" <?php echo ($month == "04" ? "selected" : "") ?>>Tháng 4</option>
						<option value="05" <?php echo ($month == "05" ? "selected" : "") ?>>Tháng 5</option>
						<option value="06" <?php echo ($month == "06" ? "selected" : "") ?>>Tháng 6</option>
						<option value="07" <?php echo ($month == "07" ? "selected" : "") ?>>Tháng 7</option>
						<option value="08" <?php echo ($month == "08" ? "selected" : "") ?>>Tháng 8</option>
						<option value="09" <?php echo ($month == "09" ? "selected" : "") ?>>Tháng 9</option>
						<option value="10" <?php echo ($month == "10" ? "selected" : "") ?>>Tháng 10</option>
						<option value="11" <?php echo ($month == "11" ? "selected" : "") ?>>Tháng 11</option>
						<option value="12" <?php echo ($month == "12" ? "selected" : "") ?>>Tháng 12</option>
					</select>
				</div>
				<div class="row" style="margin-bottom: 12px;">
					<label class="col-md-3 col-form-label" style="padding-left: 25px;">Năm</label>
					<select id="bill-year" class="form-control col-md-8">
						<option value="2020" <?php echo ($year == "2020" ? "selected" : "") ?>>2020</option>
						<option value="2021" <?php echo ($year == "2021" ? "selected" : "") ?>>2021</option>
						<option value="2022" <?php echo ($year == "2022" ? "selected" : "") ?>>2022</option>
						<option value="2023" <?php echo ($year == "2023" ? "selected" : "") ?>>2023</option>
						<option value="2024" <?php echo ($year == "2024" ? "selected" : "") ?>>2024</option>
						<option value="2025" <?php echo ($year == "2025" ? "selected" : "") ?>>2025</option>
					</select>
				</div>
				<div class="row">
					<div class="col-md-12"style="padding-left: 25px; margin-top: 20px; margin-bottom: 30px;">Các khoản chi phí</div>
					<div class="col-md-12 row">
						<div class="col-md-5" style="padding-left: 25px;">Chi phí</div>
						<div class="col-md-3">Giá tiền (VND)</div>
						<div class="col-md-2">Số lượng</div>
					</div>
					<div id="bill-panel">
						<div class="col-md-12 row" style="margin-top: 12px;">
							<div class="col-md-5" style="padding-left: 25px;">
								<input type="text" name="bill-title" class="form-control">
							</div>
							<div class="col-md-3">
								<input type="number" step="500" name="bill-price" class="form-control">
							</div>
							<div class="col-md-2">
								<input type="number" name="bill-number" class="form-control">
							</div>
							<div class="col-md-2">
								<button class="btn btn-outline-success" onclick="addBillItem(this)"><i class="fa fa-plus"></i></button>
								<button class="btn btn-outline-success" onclick="removeBillItem(this)"><i class="fa fa-trash"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Bỏ qua</button>
				<button class="btn btn-primary" data-dismiss="modal" onclick="createBill()">Submit</button>
			</div>
		</div>
	</div>
</div>