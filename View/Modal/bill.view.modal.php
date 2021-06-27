<div class="modal fade" id="viewBillModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Xem hóa đơn</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body" style="height: 580px;">
				<div class="row" style="margin-bottom: 12px;">
					<input type="hidden" id="bill-room-view">
					<label class="col-md-3 col-form-label" style="padding-left: 25px;">Tháng</label>
					<select id="bill-month-view" class="form-control col-md-5">
						<option value="01">Tháng 1</option>
						<option value="02">Tháng 2</option>
						<option value="03">Tháng 3</option>
						<option value="04">Tháng 4</option>
						<option value="05">Tháng 5</option>
						<option value="06">Tháng 6</option>
						<option value="07">Tháng 7</option>
						<option value="08">Tháng 8</option>
						<option value="09">Tháng 9</option>
						<option value="10">Tháng 10</option>
						<option value="11">Tháng 11</option>
						<option value="12">Tháng 12</option>
					</select>
                    <div class="col-md-4">
                        <button class="btn btn-primary" style="width: 150px;" onclick="viewBill()">Xem</button>
                    </div>
				</div>
				<div class="row" style="margin-bottom: 12px;">
					<label class="col-md-3 col-form-label" style="padding-left: 25px;">Năm</label>
					<select id="bill-year-view" class="form-control col-md-5">
						<option value="2020">2020</option>
						<option value="2021">2021</option>
						<option value="2022">2022</option>
						<option value="2023">2023</option>
						<option value="2024">2024</option>
						<option value="2025">2025</option>
					</select>
				</div>
				<div class="row">
					<div class="col-md-12"style="padding-left: 25px; margin-top: 20px; margin-bottom: 30px;">Thông tin hóa đơn</div>
					<div class="col-md-12 row" style="font-weight: bolder;">
						<div class="col-md-5" style="padding-left: 25px;">Chi phí</div>
						<div class="col-md-3">Giá tiền (VND)</div>
						<div class="col-md-2">Số lượng</div>
					</div>
					<div class="col-md-12" id="bill-panel-view">
						<div class="row" style="margin-top: 12px;">
							
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