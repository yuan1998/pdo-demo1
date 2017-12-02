<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php tpl('utility/component') ?>
	<script src="/page/sign/sign.js"></script>
</head>
<body>
	<div>
		<form class="form-horizontal">
			<div class="form-group">
				<label for="inputUsername" class="control-label col-sm-2">用户名</label>
				<div class="col-sm-8">
					<input type="text" placeholder="Email" class="form-control" id="inputUsername">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="control-label col-sm-2">密码</label>
				<div class="col-sm-8">
					<input type="email" placeholder="Password" class="form-control"  id="inputPassword">
				</div>
			</div>
			<div class="form-group">
				<label for="input-Password" class="control-label col-sm-2">确认密码</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="EnterPassword" id="input-Password">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-10 col-sm-offset-2">
					<input type="checkbox" name="protocol">同意
				</label>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button class="btn btn-default" type="submit">注册</button>
				</div>
			</div>
		</form>
	</div>
	
</body>
</html>