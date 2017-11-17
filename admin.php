<?php
/* >_ Developed by Vy Nghia */
require 'server/config.php';
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin</title>
<base href="<?php echo WEBURL ?>" />
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
<?php if(isset($_SESSION['admin'])): ?>
<li <?php echo ($_GET['page'] == null) ? 'class="active"' : null; ?>>
<a href="admin"><i class="fa fa-user-circle" aria-hidden="true"></i> <span class="nav-label">Trang quản trị viên</span></a>
</li>
<li <?php echo ($_GET['page'] == 'approval') ? 'class="active"' : null; ?>>
<a href="admin/approval"><i class="fa fa-check-square-o" aria-hidden="true"></i>  <span class="nav-label">Bài viết đã phê duyệt</span></a>
</li>
<li <?php echo ($_GET['page'] == 'change') ? 'class="active"' : null; ?>>
<a href="admin/change"><i class="fa fa-address-card" aria-hidden="true"></i>  <span class="nav-label">Đổi mật khẩu</span></a>
</li>
<li>
<a href="server/action?type=admin&do=logout"><i class="fa fa-power-off" aria-hidden="true"></i>  <span class="nav-label">Đăng xuất</span></a>
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
<?php if(isset($_SESSION['admin'])): ?>
<li>
<a href="/">Quản trị viên</a>
</li>
<?php endif; ?>
<li class="active">
<strong><?php switch($_GET['page']){
	case null: echo 'Trang chủ'; break;
	case 'change': echo 'Thay đổi thông tin đăng nhập'; break;
	case 'approval': echo 'Bài viết đã phê duyệt'; break;
}
?></strong>
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
<p style="color: blue"><strong><?php echo !$_SESSION['admin'] ? 'Điều trước tiên hãy đăng nhập' : 'Chào mừng bạn đến với quản trị viên'; ?></strong></p>
<?php if(isset($_SESSION['admin'])):
switch($_GET['page']):
/* THAY ĐỔI MẬT KHẨU QUẢN TRỊ VIÊN */
case 'change': ?>
<form id="change" method="POST" action="" class="form-horizontal">
<div class="form-group"><label class="col-sm-2 control-label">Mật khẩu</label>
<div class="col-sm-10"><input type="password" name="password" value="" class="form-control"></div>
</div>
<div class="form-group">
<div class="col-sm-12">
<button style="float: right" id="lgbtn" class="btn btn-primary" value="submit" name="submit" type="submit">Thay đổi đăng nhập</button>
</div>
</div>
</form>
<?php break;
/* QUẢN LÝ BÀI ĐĂNG ĐÃ DUYỆT */
case 'approval':
if($_GET['p'] == null)
		$_GET['p'] = 1;
if($_GET['p'] >= 2)
	$pages = ($_GET['p'] - 1) * 10;
else
	$pages = 0; ?>
<div id="post">
<small>Bài viết được hiển thị theo thời gian duyệt</small>
<?php $postQuery = mysql_query("SELECT * FROM `post` WHERE `approval` = 1 ORDER BY `time_approval` DESC LIMIT 10 OFFSET {$pages}");
while($post = mysql_fetch_array($postQuery)):
$pst = new Website; ?>
<div class="social-feed-separated" id="post-id-<?php echo $post['id'] ?>">
<div class="social-feed-box">
<div class="social-avatar">
<small class="text-muted"><?php echo $pst->timeAgo(strtotime($post['time'])) ?></small>
</div>
<div class="social-body">
<p><?php echo htmlspecialchars(base64_decode($post['content'])) ?></p>
<p><hr></p>
<div class="">
<button class="btn btn-warning btn-rounded btn-sm" id="approval" data-id="<?php echo $post['id'] ?>" data-type="re-approval"><i class="fa fa-check"></i>Đưa về trạng thái phê duyệt</button>
<button class="btn btn-danger btn-rounded btn-sm" id="approval" data-id="<?php echo $post['id'] ?>" data-type="deny"><i class="fa fa-times"></i> Xóa bài bài viết này</button>
</div>
</div>
</div>
</div>
<?php 
endwhile; ?>
</div>
<?php break;
/* TRANG CHỦ */
case null; ?>
<div class="alert alert-success" style="color:#1abc9c" role="alert">
<font color="black">Mình mong bạn sẽ ủng hộ một chút ít cho tác giả bản web này là <a href="https://www.facebook.com/NghiaisGay">Vy Nghĩa</a>, bạn có thể sử dụng tiền đóng góp để ra 1 ý tưởng về dự án của bạn cho tác giả triển khai.
Đây là hành động <strong>không bắt buộc</strong>, nếu bạn có nhu cầu thì hãy đóng góp để <a href="https://www.facebook.com/NghiaisGay">Vy Nghĩa</a> có thể duy trì các cơ sở vật chất và thử nghiệm các ý tưởng về sau.<br />
<strong>Email hổ trợ:</strong> nghiaisgay@gmail.com<br />
<strong>Liên hệ trò chuyện:</strong> 01632211065 (Vy Nghĩa)
<br /><br />
<strong>Cảm ơn. Mong sự tích cực từ bạn!</strong></font>
</div>
<p>Để giảm thiểu số lượng spam những bài viết ở đây đều phải qua phê duyệt mới có thể xuất hiện trên trang web. Các bài viết trên trang web sẽ được sắp xếp theo thời gian phê duyệt!</p>
<hr>
<div id="post">
<?php
if($_GET['p'] == null)
		$_GET['p'] = 1;
if($_GET['p'] >= 2)
	$pages = ($_GET['p'] - 1) * 10;
else
	$pages = 0;
$postQuery = mysql_query("SELECT * FROM `post` WHERE `approval` = 0 ORDER BY `time` DESC LIMIT 10 OFFSET {$pages}");
while($post = mysql_fetch_array($postQuery)):
$pst = new Website; ?>
<div class="social-feed-separated" id="post-id-<?php echo $post['id'] ?>">
<div class="social-feed-box">
<div class="social-avatar">
<small class="text-muted"><?php echo $pst->timeAgo(strtotime($post['time'])) ?></small>
</div>
<div class="social-body">
<p><?php echo htmlspecialchars(base64_decode($post['content'])) ?></p>
<p><hr></p>
<div class="">
<button class="btn btn-primary btn-rounded btn-sm" id="approval" data-id="<?php echo $post['id'] ?>" data-type="allow"><i class="fa fa-check"></i> Phê duyệt bài viết này</button>
<button class="btn btn-danger btn-rounded btn-sm" id="approval" data-id="<?php echo $post['id'] ?>" data-type="deny"><i class="fa fa-times"></i> Từ chối bài viết này</button>
</div>
</div>
</div>
</div>
<?php 
endwhile; ?>
</div>
<?php break;
endswitch;
endif;
?>
</div>
<!-- POST AREA -->
<div class="social-body">
<?php if(!$_SESSION['admin']): ?>
<form id="Login" method="POST" action="" class="form-horizontal">
<div class="form-group"><label class="col-sm-2 control-label">Username</label>
<div class="col-sm-10"><input type="text" name="username" value="" class="form-control" autocomplete="off"></div>
</div>
<div class="form-group"><label class="col-sm-2 control-label">Password</label>
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

</div>
<div class="row" style="text-align: center">
<?php 
	switch($_GET['page']){
		case null:
			$query = 'SELECT * FROM `post`';
			break;
		case 'approval':
			$query = 'SELECT * FROM `post` WHERE `approval` = 1';
			break;
	}
	$n = mysql_num_rows(mysql_query($query)) / 10;
	if(mysql_num_rows(mysql_query($query)) % 10 > 0)
		$n+=1;
	$n = (int) $n; 
	if(mysql_num_rows(mysql_query($query)) > 0): ?>
<ul class="pagination pagination-sm">
    <li class="<?php echo ($_GET['p']-1 != 0) ? 'first' : 'first disabled';?>"><a href="/admin?p=1">First</a></li>
    <li class="<?php echo ($_GET['p']-1 != 0) ? 'prev' : 'prev disabled';?>"><a href="/admin?p=<?php echo ($_GET['p']-1 != 0) ? $_GET['p']-1 : 1;?>">Previous</a></li>
	<?php for($i = 1; $i <= $n; $i++): ?>
    <li class="<?php echo ($_GET['p'] == $i) ? 'page active' : 'page'; ?>"><a href="/admin?p=<?php echo $i ?>"><?php echo $i ?></a></li>
	<?php endfor; ?>
    <li class="<?php echo ($_GET['p']+1 > $n) ? 'next disabled' : 'next'; ?>"><a href="/admin?p=<?php echo $_GET['p']+1 ?>">Next</a></li>
    <li class="<?php echo ($_GET['p']+1 > $n) ? 'last disabled' : 'last'; ?>"><a href="/admin?p=<?php echo $n ?>">Last</a></li>
</ul>
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
<?php if(isset($_SESSION['admin'])): ?>
$('#post').on('click', '#approval', function() {
		let $this = $(this);
		let id = $this.data('id');
		let type = $this.data('type');
		
		//Alert content
		if(type == 'allow')
		{
			alert = 'Bài viết này sẽ được phê duyệt và hiển thị trên trang chủ';
			result = 'Bài viết này đã được phê duyệt';
		}
		else if(type == 're-approval')
		{
			alert = 'Bài viết này sẽ được đưa về trạng thái chờ phê duyệt'; 
			result = 'Tác động lên bài viết đã được thực hiện';
		}
		else
		{
			alert = 'Bài viết này sẽ bị từ chối và đồng thời xóa khỏi hệ thống'; 
			result = 'Bài viết này đã bị xóa';
		}
		
		swal({
			  title: 'Bạn chắc chắn điều này?',
			  text: alert,
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Chấp nhận',
			  cancelButtonText: 'Hủy'
			}).then(function () {
				$.ajax({
				method: 'POST',
				url: 'server/action.php?do=approval',
				data: { id: id, type: type },
				success: function (data) {
						swal("Thành công!", result, "success")
						$('#post-id-' + id).remove()
					},
				error: function(){
						swal("Đã xảy ra lỗi!", "Đã xảy ra lỗi cục bộ, vui lòng thử lại!", "error")
					}
				});
			});
});

$("#change").on('submit',(function(e) {
	e.preventDefault();
	$.ajax({
		url: "server/action.php?do=change&type=admin",
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function () {
			$('#lgbtn').text('Đang xử lý...').prop('disabled', true)
		},
		success: function(data) {
			$('#lgbtn').text('Thay đổi đăng nhập').prop('disabled', false)
			if(data == true)
				location.reload();
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
		url: "server/auth.php?login=admin",
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
				swal("Lỗi đăng nhập!", "Tài khoản hoặc mật khẩu không đúng!", "error")
			else if(data == 'null')
				swal("Lỗi đăng nhập!", "Vui lòng điền đủ thông tin!", "error")
			else
				swal("Lỗi đăng nhập!", "Máy chủ không phản hồi dữ liệu!", "error")
				console.log(data);
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
