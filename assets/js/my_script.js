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

	postRequest("?action=dangky", fd, function (resp) {
		var res = JSON.parse(resp)['code'];
		switch (res) {
			case "OK":
				alert("Đăng ký thành công. Mời đăng nhập!");
				location.href = "?site=dangnhap";
				break;
		}
	});
}

function login() {
	var fd = new FormData();
	fd.append("username", getById("login-username").value);
	fd.append("password", getById("login-password").value);
	postRequest("?action=dangnhap", fd, function (resp) {
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
	var fd = new FormData();
	fd.append("id", obj.parentElement.parentElement.id);
	postRequest("?api=get_room", fd, function (resp) {
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

function updateProduct() {
	var fd = new FormData();
	fd.append("product_id", getById("product_id_update").value);
	fd.append("register_number", getById("product_reg_update").value);
	fd.append("name", getById("product_name_update").value);
	fd.append("summary", tinymce.EditorManager.get('product_summary_update').getContent({ format: 'raw' }));
	fd.append("content", tinymce.EditorManager.get('product_content_update').getContent({ format: 'raw' }));
	fd.append("price", getById("product_price_update").value);
	fd.append("sale", getById("product_sale_update").value);
	fd.append("origin", getById("product_origin_update").value);
	fd.append("brand", getById("product_brand_update").value);
	fd.append("packing", getById("product_packing_update").value);
	fd.append("ingredient", getById("product_ingredient_update").value);
	fd.append("is_feature", getById("product_feature_update").checked ? "1" : "0");
	var imgList = getByName("product_image_update");
	for (var i = 0; i < imgList.length; i++) {
		if (imgList[i].type == "hidden") fd.append("images[]", imgList[i].value);
		else if (imgList[i].type == "file") fd.append("image[]", imgList[i].files[0]);
	}
	postRequest("?action=update_product_act", fd, function (resp) {
		if (resp == "UpdateProductOK") {
			getById("product_id_update").value = "";
			getById("product_name_update").value = "";
			getById("product_reg_update").value = "";
			getById("product_price_update").value = "";
			getById("product_sale_update").value = "";
			getById("product_origin_update").value = "";
			getById("product_brand_update").value = "";
			getById("product_packing_update").value = "";
			getById("product_ingredient_update").value = "";
			getById("product_feature_update").checked = false;
			tinymce.EditorManager.get('product_summary_update').setContent("");
			tinymce.EditorManager.get('product_content_update').setContent("");
			getById("imgChooserPanelUpdate").innerHTML = "<div class=\"col-md-3\">"
				+ "<div style=\"width: 100%; height: 100%;\">"
				+ "<button class=\"close\" type=\"button\" style=\"position: relative; top: 3px; left: -28px; display: block; z-index: 100;\" onclick=\"delImgChooser(this)\">×</button>"
				+ "<input type=\"file\" name=\"product_image_update\" style=\"display: none;\">"
				+ "<img src=\"assets/img/plus.png\" class=\"imgChooserBg\" onclick=\"chooseImg(this, 'product_image_update')\">"
				+ "</div>"
				+ "</div>";
			loadProductList('productlist_body', getById("subcategory_select").value);
		}
	})
}