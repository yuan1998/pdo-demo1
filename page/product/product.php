<?php session_start();	
	var_dump($_SESSION['user']);
	if($_SESSION['user']['permissions'] < 2){
		echo "404访问失败,权限不足.";
		die();
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php tpl('utility/component'); ?>
	<script src="/page/product/product.js"></script>
</head>
<body>
	<div>
		<?php tpl('utility/html/side-bar'); ?>
		<div class="col-sm-9">
			<form id="productForm">
				<label>
					标题：<input type="text" class="form-control" name="title">
				</label><br>
				<label>
					价格:<input type="text" class="form-control" name="price">
				</label><br>
				<label>
					信息:<input type="text" class="form-control" name="info">
				</label><br>
				<label>
					库存:<input type="text" class="form-control" name="stock">
				</label><br>
				分类:
				<select class="form-control" name="cat" id="catSelect"></select>
				<button type="submit" class="btn btn-primary">提交</button>
			</form>
			<div id="productBar">
				<table class="table">
					<thead>
						<th>标题</th>
						<th>价格</th>
						<th>信息</th>
						<th>库存</th>
						<th>分类</th>	
						<th>操作</th>
					</thead>
					<tbody id="productList"></tbody>
				</table>
			</div>
			<ul class="pagination">
				<li class="prev"><a href="">上一页</a></li>
				<li class="current"><a href="">1</a></li>
				<li class="next"><a href="">下一页</a></li>
			</ul>
		</div>
	</div>
	
</body>
</html>