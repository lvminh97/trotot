//******************************************************************************
//******************************************************************************
function getRequest(link, func) {
	var http = new XMLHttpRequest();
	http.open('GET', link);
	http.onreadystatechange = function () {
		if (http.readyState == 4 && http.status == 200) {
			func(http.responseText);
		}
	}
	http.send(null);
}

function postRequest(link, data, func) {
	var http = new XMLHttpRequest();
	http.open('POST', link, true);
	http.onreadystatechange = function () {
		if (http.readyState == 4 && http.status == 200) {
			func(http.responseText);
		}
	}
	http.send(data);
}
//******************************************************************************
//******************************************************************************
function stringLimitLength(str, limit) {
	if (str.length <= limit)
		return str;
	return str.substring(0, limit) + "...";
}

function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
		vars[key] = value;
	});
	return vars;
}

function getById(id) {
	return document.getElementById(id);
}

function getByName(name) {
	return document.getElementsByName(name);
}

function signup() {
	var fd = new FormData();
	if (getById("signup-username").value.trim() != "") fd.append("username", getById("signup-username").value);
	else return alert("Tên đăng nhập không được để trống!");
	if (getById("signup-fullname").value.trim() != "") fd.append("fullname", getById("signup-fullname").value);
	else return alert("Họ tên không được để trống!");
	fd.append("mobile", getById("signup-mobile").value);
	fd.append("email", getById("signup-email").value);
	fd.append("password", getById("signup-password").value);
	fd.append("password2", getById("signup-password2").value);
	if (getById("signup-type-tenant").checked) fd.append("role", "011");
	else fd.append("role", "210");

	postRequest("?action=signup", fd, function (resp) {
		var res = JSON.parse(resp)['code'];
		switch (res) {
			case "OK":
				alert("Đăng ký thành công. Mời đăng nhập!");
				location.href = "?site=login";
				break;
		}
	});
}

function login() {
	var fd = new FormData();
	fd.append("username", getById("login-username").value);
	fd.append("password", getById("login-password").value);
	postRequest("?action=login", fd, function (resp) {
		// console.log(resp);
		var res = JSON.parse(resp)['code'];
		switch (res) {
			case "OK":
				location.href = "./.";
				break;
			case "Fail":
				alert("Sai tên đăng nhập hoặc mật khẩu!");
				break;
		}
	});
}

function loadInfo() {
	var data = new FormData();
	data.append('request', 'true');
	postRequest('./info/get_info_action.php', data, function (resp) {
		getById('infoModalBody').innerHTML = resp;
	});
}

function updateInfo(obj) {
	var data = new FormData();
	data.append('request', 'true');
	data.append('fullname', getById('fullname').value);
	data.append('email', getById('email').value);
	data.append('mobile', getById('mobile').value);
	postRequest('./info/update_info_action.php', data, function (resp) {
		switch (resp) {
			case "OK":
				alert("Update the information successful!");
				obj.previousElementSibling.click();
				break;
			case "Error: fullname_empty":
				alert("Full name is empty!");
				break;
		}
	});
}

function updatePassword(obj) {
	var data = new FormData();
	data.append('request', 'true');
	data.append('oldpass', getById('old_pass').value);
	data.append('newpass', getById('new_pass').value);
	data.append('newpass2', getById('new_pass2').value);
	postRequest('./info/change_pass_action.php', data, function (resp) {
		switch (resp) {
			case "OK":
				alert("Password changed!");
				getById('old_pass').value = '';
				getById('new_pass').value = '';
				getById('new_pass2').value = '';
				obj.previousElementSibling.click();
				break;
			case "Error: oldpassword_wrong":
				alert("Old password is wrong!");
				break;
			case "Error: password_short":
				alert("Password is too short. The minimum length is 8!");
				break;
			case "Error: password_mismatch":
				alert("Repeat password is not match. Please try again!");
				break;
		}
	});
}

function chooseImg(obj, input_name) {
	var x = obj.previousElementSibling;
	x.click();
	x.onchange = function (e) {
		var reader = new FileReader();
		reader.readAsDataURL(e.srcElement.files[0]);
		reader.onload = function (e) {
			obj.src = e.target.result;
		}
		obj.previousElementSibling.previousElementSibling.style.display = 'block';
		var check = document.getElementsByName(input_name);
		if (check[check.length - 1].value != "") {
			createImgChooser(obj.parentElement.parentElement.parentElement, input_name);
		}
	}
}
function createImgChooser(obj, input_name) {
	var item = document.createElement('div');
	item.className = 'col-md-3';
	item.innerHTML = "<div style='width: 100%; height: 100%;'>\n" +
		"<button class='close' type='button' style='position: relative; top: 3px; left: -28px; display: none; z-index: 100;' onclick='delImgChooser(this)'>×</button>\n" +
		"<input type='file' name='" + input_name + "' style='display: none;'>\n" +
		"<img src='./assets/img/plus.png' class='imgChooserBg' onclick=\"chooseImg(this, '" + input_name + "')\">\n" +
		"</div>";
	obj.appendChild(item);
}
function delImgChooser(obj) {
	obj.parentElement.parentElement.parentElement.removeChild(obj.parentElement.parentElement);
}

function loadRoomList() {
	// getRequest()
}

function addRoom() {
	var fd = new FormData();
	fd.append("name", getById("room_name").value);
	fd.append("area", getById("room_area").value);
	fd.append("price", getById("room_price").value);
	fd.append("number", getById("room_location_num").value);
	fd.append("alley", getById("room_location_alley").value);
	fd.append("street", getById("room_location_street").value);
	fd.append("subdistrict", getById("room_location_subdistrict").value);
	fd.append("district", getById("room_location_district").value);
	fd.append("province", getById("room_location_province").value);
	var imgList = getByName("room_image");
	for (var i = 0; i < imgList.length; i++) {
		fd.append('image[]', imgList[i].files[0]);
	}
	postRequest("?api=add_room", fd, function (resp) {
		var form = getById("addRoomForm");
		for (var i = 0; i < form.length; i++) form[i].value = "";
		getById("imgChooserPanel").innerHTML =
			"<div class='col-md-3'>\n" +
			"<div style='width: 100%; height: 100%;'>\n" +
			"<button class='close' type='button' style='position: relative; top: 3px; left: -28px; display: none; z-index: 100;' onclick='delImgChooser(this)'>×</button>\n" +
			"<input type='file' name='room_image' style='display: none;'><img src='./assets/img/plus.png' class='imgChooserBg' onclick='chooseImg(this, \"room_image\")'>\n" +
			"</div>\n" +
			"</div>";
		var data = JSON.parse(resp);
		if (data["code"] == "OK") window.location.reload(true);
	});
}

function loadRoom(obj) {
	var id = obj.parentElement.parentElement.id;
	getRequest("?api=get_room&id=" + id, function (resp) {
		// console.log(resp);
		var data = JSON.parse(resp);
		if (data['code'] == "OK") {
			var room = data['room'];
			getById("e_room_id").value = room["room_id"];
			getById("e_room_name").value = room["name"];
			getById("e_room_area").value = room["area"];
			getById("e_room_price").value = room["price"];
			getById("e_room_location_num").value = room["loc_number"];
			getById("e_room_location_alley").value = room["loc_alley"];
			getById("e_room_location_street").value = room["loc_street"];
			getById("e_room_location_subdistrict").value = room["loc_subdistrict"];
			getById("e_room_location_district").value = room["loc_district"];
			getById("e_room_location_province").value = room["loc_province"];
			var imgList = room["images"].split(";");
			getById("imgChooserPanelUpdate").innerHTML = "";
			for (var i = 0; i < imgList.length; i++) {
				var div = document.createElement("div");
				div.className = "col-md-3";
				div.innerHTML = "<div style=\"width: 100%; height: 100%;\">"
					+ "<button class=\"close\" type=\"button\" style=\"position: relative; top: 3px; left: -28px; display: block; z-index: 100;\" onclick=\"delImgChooser(this)\">×</button>"
					+ "<input type=\"hidden\" name=\"e_room_image\" value=\"" + imgList[i] + "\">"
					+ "<img src=\"./Resource/Images/" + imgList[i] + "\" class=\"imgChooserBg\" onclick=\"\"/>"
					+ "</div>";
				getById("imgChooserPanelUpdate").appendChild(div);
			}
			var div = document.createElement("div");
			div.className = "col-md-3";
			div.innerHTML =
				"<div style='width: 100%; height: 100%;'>\n" +
				"<button class='close' type='button' style='position: relative; top: 3px; left: -28px; display: none; z-index: 100;' onclick='delImgChooser(this)'>×</button>\n" +
				"<input type='file' name='e_room_image' style='display: none;'><img src='./assets/img/plus.png' class='imgChooserBg' onclick='chooseImg(this, \"e_room_image\")'>\n" +
				"</div>\n";
			getById("imgChooserPanelUpdate").appendChild(div);
		}
	});
}

function updateRoom() {
	var fd = new FormData();
	fd.append("id", getById("e_room_id").value);
	fd.append("name", getById("e_room_name").value);
	fd.append("area", getById("e_room_area").value);
	fd.append("price", getById("e_room_price").value);
	fd.append("number", getById("e_room_location_num").value);
	fd.append("alley", getById("e_room_location_alley").value);
	fd.append("street", getById("e_room_location_street").value);
	fd.append("subdistrict", getById("e_room_location_subdistrict").value);
	fd.append("district", getById("e_room_location_district").value);
	fd.append("province", getById("e_room_location_province").value);
	var imgList = getByName("e_room_image");
	for (var i = 0; i < imgList.length; i++) {
		if (imgList[i].type == "hidden") fd.append("image_name[]", imgList[i].value);
		else if (imgList[i].type == "file") fd.append("image[]", imgList[i].files[0]);
	}
	postRequest("?api=update_room", fd, function (resp) {
		// console.log(resp);
		var form = getById("updateRoomForm");
		for (var i = 0; i < form.length; i++) form[i].value = "";
		getById("imgChooserPanelUpdate").innerHTML =
			"<div class='col-md-3'>\n" +
			"<div style='width: 100%; height: 100%;'>\n" +
			"<button class='close' type='button' style='position: relative; top: 3px; left: -28px; display: none; z-index: 100;' onclick='delImgChooser(this)'>×</button>\n" +
			"<input type='file' name='e_room_image' style='display: none;'><img src='./assets/img/plus.png' class='imgChooserBg' onclick='chooseImg(this, \"e_room_image\")'>\n" +
			"</div>\n" +
			"</div>";
		var data = JSON.parse(resp);
		if (data["code"] == "OK") window.location.reload(true);
	});
}

function deleteRoom(obj) {
	var cf = confirm("Bạn muốn xóa phòng này?");
	if (!cf) return;
	var fd = new FormData();
	fd.append("id", obj.parentElement.parentElement.id);
	postRequest("?api=delete_room", fd, function (resp) {
		// console.log(resp);
		var data = JSON.parse(resp);
		if (data["code"] == "OK") {
			window.location.reload(true);
		}
	})
}

function loadPostList(){
	// 
}

function addPost() {
	var fd = new FormData();
	fd.append("title", getById("post_title").value);
	fd.append("room_id", getById("post_room").value);
	fd.append("content", tinymce.EditorManager.get('post_content').getContent({format: 'raw'}));
	postRequest("?api=add_post", fd, function (resp) {
		var form = getById("addPostForm");
		for (var i = 0; i < form.length; i++) form[i].value = "";
		tinymce.EditorManager.get('post_content').setContent("");
		var data = JSON.parse(resp);
		if (data["code"] == "OK") window.location.reload(true);
	});
}

function loadPost(obj) {
	var fd = new FormData();
	var id = obj.parentElement.parentElement.id;
	getRequest("?api=get_post&id=" + id, function (resp) {
		// console.log(resp);
		var data = JSON.parse(resp);
		if (data['code'] == "OK") {
			var post = data['post'];
			getById("e_post_id").value = post["post_id"];
			getById("e_post_title").value = post["title"];
			getById("e_post_room").value = post["room_id"];
			tinymce.EditorManager.get('e_post_content').setContent(post['content']);
		}
	});
}

function updatePost(){
	var fd = new FormData();
	fd.append("id", getById("e_post_id").value);
	fd.append("title", getById("e_post_title").value);
	fd.append("room_id", getById("e_post_room").value);
	fd.append("content", tinymce.EditorManager.get('e_post_content').getContent({format: 'raw'}));
	postRequest("?api=update_post", fd, function (resp) {
		// console.log(resp);
		var form = getById("updatePostForm");
		for (var i = 0; i < form.length; i++) form[i].value = "";
		tinymce.EditorManager.get('e_post_content').setContent("");
		var data = JSON.parse(resp);
		if (data["code"] == "OK") window.location.reload(true);
	});
}

function deletePost(obj) {
	var cf = confirm("Bạn muốn xóa bài đăng này?");
	if (!cf) return;
	var fd = new FormData();
	fd.append("id", obj.parentElement.parentElement.id);
	postRequest("?api=delete_post", fd, function (resp) {
		// console.log(resp);
		var data = JSON.parse(resp);
		if (data["code"] == "OK") {
			window.location.reload(true);
		}
	})
}

function rentRequest(){
	var cf = confirm("Bạn muốn thuê phòng này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("room_id", getUrlVars()['id']);
	postRequest("?api=rent", fd, function(resp){
		console.log(resp);
		// if not log in => alert "require log in"
		// if sent request before => alert "can not send request twice"
		// if can not rent => alert "can not rent"
		// if OK => alert "Send request successful"
	});
}

function roomTypeFilter(type){
	var roomList = getById('my-room-list').children;
	for(var i = 0; i < roomList.length; i++){
		if(type == "0" && roomList[i].className == "my-room-item-renting" ||
		type == "1" && roomList[i].className == "my-room-item-return" ||
		type == "2" && roomList[i].className == "my-room-item-pending"){
			roomList[i].style.display = "block";
		}
		else roomList[i].style.display = "none";
	}
}

function viewMyBill(obj){
	var bill = obj.parentElement.nextElementSibling;
	if(bill.style.display == "none")
		bill.style.display = "block";
	else
		bill.style.display = "none";
}

function returnRoom(id){
	var cf = confirm("Bạn muốn trả phòng?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("id", id);
	postRequest("?api=return_room", fd, function(resp){
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			alert("Đã trả phòng!");
			window.location.reload(true);
		}
	});
}

function loadRentPendingList(id){
	var fd = new FormData();
	fd.append('id', id);
	postRequest("?api=get_rent_pending_list", fd, function(resp){
		// console.log(resp);
		var data = JSON.parse(resp);
		if(data['code'] != "OK") return;
		var list = getById('rent-pending-list');
		list.innerHTML = "";
		for(var i = 0; i < data['rentList'].length; i++){
			var divE = document.createElement("div");
			divE.className = "row";
			divE.innerHTML = 
				"<div class=\"col-md-9\">" +
					"<span style=\"font-size: 20px; font-weight: bolder; color: blue; margin-left: 15px;\">" + data['rentList'][i]['fullname'] + "</span>" +
					"<span style=\"font-size: 16px; font-style: italic; margin-left: 10px;\">(" + data['rentList'][i]['begin_time'] + ")</span>" + 
				"</div>" + 
				"<div class=\"col-md-3\">" + 
					"<button class=\"btn btn-success\" onclick=\"approveRentRequest('" + data['rentList'][i]['rent_id'] + "', 'approve')\"><i class=\"fa fa-check\"></i></button>" + 
					"<button class=\"btn btn-danger\" onclick=\"approveRentRequest('" + data['rentList'][i]['rent_id'] + "', 'deny')\"><i class=\"fa fa-times\"></i></button>" + 
				"</div>";
			list.appendChild(divE);
		}
	});
}

function loadTenantInfo(id){
	var fd = new FormData();
	fd.append("room_id", id);
	getById("tenant-room").value = id;
	postRequest("?api=get_tenant", fd, function(resp){
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			var data = json['user'];
			getById("tenant-id").value = data['user_id'];
			getById("tenant-fullname").innerHTML = data['fullname'];
			getById("tenant-email").innerHTML = data['email'];
			getById("tenant-mobile").innerHTML = "<a href=\"tel:" + data['mobile'] + "\">" + data['mobile'] + "</a>";
		}
	});
}

function approveRentRequest(id, cmd){
	var cfMess = cmd == "approve" ? "chấp nhận" : "từ chối";
	var cf = confirm("Bạn có chắc muốn " + cfMess + " yêu cầu này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append('rent_id', id);
	fd.append('cmd', cmd);
	postRequest("?api=approve_rent", fd, function(resp){
		var dt = JSON.parse(resp);
		if(dt['code'] == "OK") window.location.reload(true);
	});
}

function kickTenant(){
	var cf = confirm("Bạn muốn chấm dứt cho khách thuê phòng này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("room_id", getById("tenant-room").value);
	postRequest("?api=kick_tenant", fd, function(resp){
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			window.location.reload(true);
		}
	});
}

function openTransferForm(){
	var obj = getById("transferForm");
	if(obj.style.display == "none")
		obj.style.display = "block";
	else
		obj.style.display = "none";
}

function hostFilter(){
	var fd = new FormData();
	fd.append("name", getById("host-name").value);
	fd.append("mobile", getById("host-mobile").value);
	getById("host-name-list").innerHTML = "";
	postRequest("?api=search_host", fd, function(resp){
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			var data = json['host'];
			for(var i = 0; i < data.length; i++){
				var opt = document.createElement("option");
				opt.value = data[i]['user_id'];
				opt.innerText = data[i]['fullname'] + " - SĐT: " + data[i]['mobile'];
				getById("host-name-list").appendChild(opt);
			}
		}
	});
}

function transferTenant(){
	var cf = confirm("Xác nhận gửi khách đang thuê đến chủ trọ này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("host", getById("host-name-list").value);
	fd.append("tenant", getById("tenant-id").value)
	fd.append("room", getById("tenant-room").value);
	postRequest("?api=transfer_tenant", fd, function(resp){
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			window.location.reload(true);
		}
		else if(json['code'] == "NoEmptyRoom"){
			alert("Chủ trọ này hiện không còn phòng trống!");
		}
	})
}

function viewTransfer(){

}

function approveTransfer(id){
	var cf = confirm("Bạn đồng ý yêu cầu này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("id", getById("transfer-id").value);
	fd.append("status", "approve");
	fd.append("feedback", getById('approve-feedback').value);
	fd.append("room_id", getById('receive-room').value);
	postRequest("?api=approve_transfer", fd, function(resp){
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			window.location.reload(true);
		}
		else if(json['code'] == "NoEmptyRoom"){
			alert("Hiện tại bạn đang không còn phòng trống nên không thể nhận khách!");
		}
	});
}

function rejectTransfer(){
	var cf = confirm("Bạn từ chối yêu cầu này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("id", getById("transfer-id").value);
	fd.append("status", "reject");
	fd.append("feedback", getById('reject-feedback').value);
	postRequest("?api=approve_transfer", fd, function(resp){
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			window.location.reload(true);
		}
	});
}

function addBillItem(obj){
	var divE = document.createElement("div");
	divE.className = "col-md-12 row";
	divE.style.marginTop = "12px";
	divE.innerHTML = 
		"<div class=\"col-md-5\" style=\"padding-left: 25px;\">" + 
			"<input type=\"text\" name=\"bill-title\" class=\"form-control\">" +
		"</div>" +
		"<div class=\"col-md-3\">" +
			"<input type=\"number\" step=\"500\" name=\"bill-price\" class=\"form-control\">" +
		"</div>" +
		"<div class=\"col-md-2\">" +
			"<input type=\"number\" name=\"bill-number\" class=\"form-control\">" +
		"</div>" +
		"<div class=\"col-md-2\">" +
			"<button class=\"btn btn-outline-success\" onclick=\"addBillItem(this)\"><i class=\"fa fa-plus\"></i></button>\n" +
			"<button class=\"btn btn-outline-success\" onclick=\"removeBillItem(this)\"><i class=\"fa fa-trash\"></i></button>" +
		"</div>"
	getById("bill-panel").appendChild(divE);
}

function removeBillItem(obj){
	var count = getByName("bill-title").length;
	if(count == 1) return;
	obj.parentElement.parentElement.remove();
}

function createBill(){
	var cf = confirm("Tạo hóa đơn?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("room_id", getById('bill-room').value);
	fd.append("time", getById("bill-year").value + "-" + getById("bill-month").value + "-01");
	var titleList = getByName("bill-title");
	var priceList = getByName("bill-price");
	var numberList = getByName("bill-number");
	for(var i = 0; i < titleList.length; i++){
		fd.append('titleList[]', titleList[i].value);
		fd.append('priceList[]', priceList[i].value);
		fd.append('numList[]', numberList[i].value);
	}
	postRequest("?api=create_bill", fd, function(resp){
		var data = JSON.parse(resp);
		if(data['code'] == "OK"){
			window.location.reload(true);
		}
		else if(data['code'] = "NoTenant"){
			alert("Không thể lập hóa đơn do phòng này hiện không có người thuê");
		}
	})
}

function searchBill(){
	window.location.href = "./?link=manage-bill&y=" + getById("bill-year-search").value + "&m=" + getById("bill-month-search").value;
}

function getStatistic(){
	window.location.href = "./?link=statistic&y=" + getById("statistic-year").value + "&m=" + getById("statistic-month").value;
}

function viewBill(id){
	var fd = new FormData();
	fd.append("bill_id", id)
	postRequest("?api=get_bill", fd, function(resp){
		var json = JSON.parse(resp);
		getById("bill-panel-view").innerHTML = "";
		if(json['code'] == "OK"){
			var data = json['bill']['bill'];
			console.log(data);
			var total = 0;
			for(var i = 0; i < data.length; i++){
				var divE = document.createElement("div");
				divE.className = "row";
				divE.style.marginTop = "12px";
				divE.innerHTML = 
					"<div class=\"col-md-5\" style=\"padding-left: 25px;\">" +
					data[i]['title'] + 				
					"</div>" + 
					"<div class=\"col-md-3\">" + 
					data[i]['price'] + 
					"</div>" + 
					"<div class=\"col-md-2\">" +
					data[i]['number'] + 
					"</div>";
				getById("bill-panel-view").appendChild(divE);
				total += parseInt(data[i]['price']) * parseInt(data[i]['number']);
			}
			var hr = document.createElement("hr");
			getById("bill-panel-view").appendChild(hr);
			var divE = document.createElement("div");
			divE.className = "row";
			divE.style.marginTop = "12px";
			divE.innerHTML = 
				"<div class=\"col-md-5\" style=\"padding-left: 25px;\">" +
				"Tổng tiền" + 				
				"</div>" + 
				"<div class=\"col-md-3\">" + 
				total + "VND" + 
				"</div>";
				getById("bill-panel-view").appendChild(divE);
		}
	});
}

function updateBill(id, status){
	var fd = new FormData();
	fd.append("bill_id", id);
	fd.append("status", status);
	postRequest("?api=update_bill_status", fd, function(resp){
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			window.location.reload(true);
		}
	});
}

function deleteBill(id){
	var cf = confirm("Bạn chắc chắn muốn xóa hóa đơn này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("bill_id", id);
	postRequest("?api=delete_bill", fd, function(resp){
		window.location.reload(true);
	});
}

function searchRoom(){
	var queryString = "";
	if(getById("search-key-province").value.trim() != "")
		queryString += "&province=" + getById("search-key-province").value.trim();
	if(getById("search-key-district").value.trim() != "")
		queryString += "&district=" + getById("search-key-district").value.trim();
	if(getById("search-key-subdistrict").value.trim() != "")
		queryString += "&subdistrict=" + getById("search-key-subdistrict").value.trim();
	if(getById("search-key-street").value.trim() != "")
		queryString += "&street=" + getById("search-key-street").value.trim();
	if(getById("search-key-area1").value != "0")
		queryString += "&area1=" + getById("search-key-area1").value;
	if(getById("search-key-area2").value != "0")
		queryString += "&area2=" + getById("search-key-area2").value;
	if(getById("search-key-price1").value != "0")
		queryString += "&price1=" + getById("search-key-price1").value;
	if(getById("search-key-price2").value != "0")
		queryString += "&price2=" + getById("search-key-price2").value;
	window.location.href = "?site=room_list" + queryString;
}

function viewPost(id){
	var aElem = document.createElement("a");
	aElem.href = "?site=room_demo&id=" + id;
	aElem.target = "_blank";
	aElem.click();
}

function approvePost(id, cmd){
	var str;
	if(cmd == "approve") str = "phê duyệt";
	else str = "từ chối";
	var cf = confirm("Bạn muốn " + str + " bài đăng này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("id", id);
	fd.append("cmd", cmd);
	if(cmd == "delete")
		fd.append("feedback", getById('reject-feedback').value);
	postRequest("?api=approve_post", fd, function(resp){
		console.log(resp);
		var json = JSON.parse(resp);
		if(json['code'] == "OK"){
			window.location.reload(true);
		}
	});
}

function removeHost(id){
	var cf = confirm("Bạn muốn xóa tài khoản này?");
	if(!cf) return;
	var fd = new FormData();
	fd.append("id", id);
	postRequest("?api=delete_host", fd, function(resp){
		console.log(resp);
		var json = JSON.parse(resp);
		if(json['code'] == "OK")
			window.location.reload(true);
	})
}