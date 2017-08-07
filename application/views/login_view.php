<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>NETPC - Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="/css/jquery-ui.min.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />

		<script src="/js/jquery-1.11.1.min.js"></script>
		<script src="/js/jquery-ui.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/jquery.maskedinput.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

		<script type="text/javascript">
			jQuery(function($){
		   $("input[type='phone']").mask("+38(099)999-9999");
		});</script>
	</head>
	<body>
<?php if(isset($_SESSION['message'])) { ?>
	<div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">&times;</span>
</button><?= $_SESSION['message']['text'] ?></div>
<?php } ?>
<?php
if($data)extract($data);
?>
<section class="loginForm">
	<div class="content">
		<div class="container-fluid">
			<div class="col-md-3">
	
			</div>
			<div class="col-md-9">
				<div class="text">
					<span class="h3">Please login to continue.</span>
				</div>
			</div>
		</div>
		<div class="container-fluid form">
			<form action="" method="POST">
				<div class="form-group">
				    <label for="formInputLogin">Login:</label>
				    <input type="text" class="form-control" id="formInputLogin" placeholder="Login" name="login" value="" required="" />
				</div>
				<div class="form-group">
				    <label for="formInputPass">Pass:</label>
				    <input type="password" class="form-control" id="formInputPass" placeholder="Pass" name="pass" value="" required="" />
				</div>
				<div class="submit">
					<input class="btn btn-success" type="submit" name="send_autoriz" value="Login"/>
				</div>
			</form>
		</div>
	</div>
</section>
<!-- Дальше прописывать нужные скрипты  -->

<!-- Конец  -->
<script type="text/javascript">
	$('.alert').fadeIn(500);
	setTimeout(function(){
		$('.alert').fadeOut(500);
	}, 5000);
</script>
<?php unset($_SESSION['message']); ?>

<script type="text/javascript" src="/js/common.js"></script>
</body>
</html>