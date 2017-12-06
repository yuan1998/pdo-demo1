<?php session_start();
	if($_SESSION['user']['permissions'] < 2){
		echo "404访问失败,权限不足.";
		die();
	}
 ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php tpl('utility/component'); ?>
	<script src="/page/user/user.js"></script>
</head>
<body>
	<?php tpl('utility/html/side-bar'); ?>
	<div>
		<div id="userList">
			<table>
				<thead>
						<th>用户名</th>
						<th>权限等级</th>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	
</body>
</html>