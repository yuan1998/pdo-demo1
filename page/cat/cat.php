<?php session_start();	
	if($_SESSION['user']['permissions'] < 2){
		echo "404访问失败.";
		die();
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php tpl('utility/component'); ?>
	<script src="/page/cat/cat.js"></script>
</head>
<body>
	<div>
		<?php tpl('utility/html/side-bar') ?>
		<div class="col-sm-9">
			<form id="catForm">
				<label>
					标题：<input type="text" class="form-control" name="title">
				</label><br>
				父级分类:
				<select class="form-control" name="pid" id="catSelect"></select>
				<button type="submit" class="btn btn-primary">提交</button>
			</form>
			<div id="catBar">
				<table class="table">
					<thead>
						<th>标题</th>	
						<th>操作</th>
					</thead>
					<tbody id="catList"></tbody>
				</table>
			</div>
		</div>
	</div>
	
</body>
</html>