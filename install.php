<?php
/* >_ Developed by Vy Nghia */
require 'server/config.php';
session_start();
error_reporting(0);

if(isset($_SESSION['install'])){
	if($_GET['do'] == 'update'){
		$configExample = file_get_contents('server/lib/example/config.example.php');
		
		$numcfg = ["{1}", "{2}", "{3}", "{4}", "{5}"];
		$change   = ["{$_POST['weburl']}", "{$_POST['dbhost']}", "{$_POST['dbuser']}", "{$_POST['dbpass']}", "{$_POST['dbname']}"];
		
		$configNew = str_replace($numcfg, $change, $configExample);
		$ConfigFile = fopen("server/config.php", "w") or die("Không thể khởi tạo file này!");
		fwrite($ConfigFile, $configNew);
		fclose($ConfigFile);
		
		echo (true);
		
		exit;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Server / Install</title>
<link href="assets/css/bootstrap3/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-wysihtml5.css" rel="stylesheet">
<link href="assets/css/animate.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.css" rel="stylesheet" type="text/css">
<style>
textarea {
     width: 100%;
	 height: 100px;
	 resize: none;
     -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
     -moz-box-sizing: border-box;    /* Firefox, other Gecko */
     box-sizing: border-box;         /* Opera/IE 8+ */
}
</style>
</head>
<body class="boxed-layout fixed-sidebar">
<div id="wrapper">
<nav class="navbar-default navbar-static-side" role="navigation">
<div class="sidebar-collapse">
<ul class="nav metismenu" id="side-menu">
<li class="nav-header">
<div class="dropdown profile-element">
<a data-toggle="dropdown" class="dropdown-toggle" href="#">
<span class="clear"> <span class="block m-t-xs"> Chào bạn</strong>
</span> </a>
</div>
</li>
<!-- vertical menu -->
<li>
<a href="/"><i class="fa fa-home"></i> <span class="nav-label">Trang chủ</span></a>
</li>
<?php if(isset($_SESSION['installer'])): ?>
<li>
<a href="server/action?type=installer&do=logout"><i class="fa fa-power-off" aria-hidden="true"></i>  <span class="nav-label">Đăng xuất</span></a>
</li>
<?php endif; ?>
</ul>
</div>
</nav> <div id="page-wrapper" class="gray-bg">
<div class="row border-bottom">
<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
<div class="navbar-header">
<a class="navbar-minimalize minimalize-styl-2 btn btn-primary "><i class="fa fa-bars"></i> </a>
</div>
</nav>
</div>
<!-- current page -->
<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
<h2>Bảng tin</h2>
<ol class="breadcrumb">
<li>
<a href="/">Trang chủ</a>
</li>
<?php if(isset($_SESSION['installer'])): ?>
<li class="active">
<strong>Xác thực truy cập</strong>
</li>
<?php else: ?>
<li class="active">
<strong>Quản lý cấu hình website</strong>
<?php endif; ?>
</li>
</ol>
</div>
<div class="col-lg-2">
</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<div class="col-lg-12">
<div class="social-feed-separated">
<div class="social-feed-box">
<div class="social-avatar">
<p style="color: blue"><strong><?php echo !$_SESSION['install'] ? 'Điều trước tiên hãy đăng nhập' : 'Chào mừng bạn đến với quản lý cấu hình'; ?></strong></p>
<?php if(isset($_SESSION['install'])): ?>
<div class="alert alert-success" style="color:#1abc9c" role="alert">
<font color="black">Mình mong bạn sẽ ủng hộ một chút ít cho tác giả bản web này là <a href="https://www.facebook.com/NghiaisGay">Vy Nghĩa</a>, bạn có thể sử dụng tiền đóng góp để ra 1 ý tưởng về dự án của bạn cho tác giả triển khai.
Đây là hành động <strong>không bắt buộc</strong>, nếu bạn có nhu cầu thì hãy đóng góp để <a href="https://www.facebook.com/NghiaisGay">Vy Nghĩa</a> có thể duy trì các cơ sở vật chất và thử nghiệm các ý tưởng về sau.<br />
<strong>Email hổ trợ:</strong> nghiaisgay@gmail.com<br />
<strong>Liên hệ trò chuyện:</strong> 01632211065 (Vy Nghĩa)
<br /><br />
<strong>Cảm ơn. Mong sự tích cực từ bạn!</strong></font>
</div>
 <table class="table table-bordered">
    <thead>
      <tr>
        <th colspan="2"><center>Các điều kiện về PHP</center></th>
      </tr>
      <tr>
        <th>Điều kiện</th>
        <th width="180px">Phiên bản</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Yêu cầu tối thiểu</td>
        <td>5.x.x</td>
      </tr>
      <tr>
        <td>Yêu cầu tiêu chuẩn</td>
        <td>5.6.x</td>
      </tr>
      <tr>
        <td>Phiên bản PHP trên server của bạn</td>
        <td><?php echo phpversion() ?></td>
      </tr>
    </tbody>
  </table>
<?php
endif;
?>
</div>
<!-- POST AREA -->
<div class="social-body">
<?php if(!$_SESSION['install']): ?>
<form id="Login" method="POST" action="" class="form-horizontal">
<div class="form-group"><label class="col-sm-2 control-label">Mật khẩu truy cập</label>
<div class="col-sm-10"><input type="password" name="password" value="" class="form-control"></div>
</div>
<div class="form-group">
<div class="col-sm-4 col-sm-offset-2">
<button id="lgbtn" class="btn btn-primary" value="submit" name="submit" type="submit">Đăng nhập</button>
</div>
</div>
</form>
<?php endif; ?>
</div>
</div>
</div>

<hr>

<?php if(isset($_SESSION['install'])): ?>
<div class="social-feed-separated">
<div class="social-feed-box">
<div class="social-body">
<h3>Cấu hình website</h3>
<form id="install" method="POST" action="" class="form-horizontal">
	<div class="form-group"><label class="col-sm-2 control-label">Website</label>
		<div class="col-sm-10"><input type="text" name="weburl" value="<?php echo WEBURL ?>" placeholder="Địa chỉ trang Confession" class="form-control">
		<small>Địa chỉ dẫn đến trang chủ (nếu nằm trong thư mục thì chỉ rõ thư mục luôn)</small></div>
	</div>

	<div class="form-group"><label class="col-sm-2 control-label">DB Host</label>
		<div class="col-sm-10"><input type="text" name="dbhost" value="<?php $db->dbinfo('dbhost') ?>" placeholder="localhost" class="form-control"></div>
	</div>
	
	<div class="form-group"><label class="col-sm-2 control-label">DB Username</label>
		<div class="col-sm-10"><input type="text" name="dbuser" value="<?php $db->dbinfo('dbuser') ?>" placeholder="db username" class="form-control"></div>
	</div>
	
	<div class="form-group"><label class="col-sm-2 control-label">DB Password</label>
		<div class="col-sm-10"><input type="text" name="dbpass" value="<?php $db->dbinfo('dbpass') ?>" placeholder="db password" class="form-control"></div>
	</div>
	
	<div class="form-group"><label class="col-sm-2 control-label">DB Name</label>
		<div class="col-sm-10"><input type="text" name="dbname" value="<?php $db->dbinfo('dbname') ?>" placeholder="select db name" class="form-control"></div>
	</div>
	<div class="form-group">
	<div class="col-sm-4 col-sm-offset-2">
		<button id="isnbtn" class="btn btn-primary" value="submit" name="submit" type="submit">Cập nhật cấu hình</button>
	</div>
	</div>
</form>
</div>
</div>
</div>
<?php endif; ?>

</div>
</div>
</div>
<div class="footer">
<div>
&copy; 2017 Vy Nghia.
</div>
</div>

</div>
<script src="assets/js/jquery-2.1.1.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/js/inspinia.js"></script>
<script src="assets/js/plugins/pace/pace.min.js"></script>
<script src="assets/js/jquery.twbsPagination.min.js"></script>
<script src="assets/js/wysihtml5-0.3.0.js"></script>
<script src="assets/js/bootstrap-wysihtml5.js?v=1509569870"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.min.js"></script>
<script>
<?php if(isset($_SESSION['install'])): ?>
$("#install").on('submit',(function(e) {
	e.preventDefault();
	$.ajax({
		url: "install.php?do=update",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function () {
			$('#isnbtn').text('Đang xử lý...').prop('disabled', true)
		},
		success: function(data) {
			$('#isnbtn').text('Cập nhật cấu hình').prop('disabled', false)
			if(data == true){
				swal({
				  title: 'Updated!',
				  text: 'Cấu hình đã được thay đổi! Bạn muốn nạp dữ liệu vào database ngay bây giờ không?',
				  type: 'success',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Chấp nhận',
				  cancelButtonText: 'Hủy'
				}).then(function () {
					$.ajax({
						url: "server/action?do=install&type=mysql",
						type: "POST",
						contentType: false,
						cache: false,
						processData:false,
						success: function(data) {
							swal("Hoàn thành!", "Đã nạp dữ liệu (databse) vào cơ sở dữ liệu của bạn!", "success")
						}
					})
				});
			}
		},
		error: function(){
			swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
			$('#lgbtn').text('Đăng nhập').prop('disabled', false)
		}
   });
}));
<?php endif; ?>

$("#Login").on('submit',(function(e) {
	e.preventDefault();
	$.ajax({
		url: "server/auth.php?login=install",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function () {
			$('#lgbtn').text('Đang xử lý...').prop('disabled', true)
		},
		success: function(data) {
			$('#lgbtn').text('Đăng nhập').prop('disabled', false)
			if(data == 'success')
				location.reload();
			else if (data == 'failed')
				swal("Lỗi đăng nhập!", "Mật khẩu truy cập không đúng, vui lòng gắng thử lại!", "error")
			else
				swal("Lỗi đăng nhập!", "Máy chủ không phản hồi dữ liệu!", "error")
		},
		error: function(){
			swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
			$('#lgbtn').text('Đăng nhập').prop('disabled', false)
		}
   });
}));
</script>
</body>
</html>
