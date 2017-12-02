<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php tpl('utility/component') ?>
	<script src="/page/login/login.js"></script>
</head>
<body>
	<h1></h1>
	<div class="container col-sm-4 col-sm-offset-4 text-center">
		<form class="panel panel-danger" id="loginForm">
			<div class="panel-heading"><h5>WELCOME</h5></div>
			<label class="form-grounp panel-body">
					<input type="text" class="form-control" placeholder="username" name="username">
			</label><br>
			<label class="form-grounp">
					<input type="password" class="form-control" name="password" placeholder="password">
			</label><br>
			<button type="submit" class="btn btn-default">登陆</button>
			<a href="/sign" class="btn btn-default">注册</a>
		</form>
	</div>
	
</body>
</html>