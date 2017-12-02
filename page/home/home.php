<?php session_start();	

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php tpl('utility/component') ?>
	<script src="/page/home/home.js"></script>
</head>
<body>
	<div id="pageHead" class="top-nav navbar navbar-inverse">
		<div id="navBar" class="container collapse navbar-collapse">
			<div class="logo col-xs-1 col-md-1 navbar-brand">LOGO.</div>
			<ul class="col-xs-8 col-md-8 nav navbar-nav ">
				<li class="active "><a href="/home">首页</a></li>
				<?php if($_SESSION['user']['permissions'] > 1){
					echo "<li class=''><a href='/product'>商品管理</a></li>";
				} ?>
			</ul>
			<ul class="col-xs-3 col-md-3 nav navbar-nav navbar-right">
				?<php if($_SESSION['user']){
					echo "<li><a href='/user/{$_SESSION['user']['id']}'>{$_SESSION['user']['username']}</a></li>
						<li><a href='' class='loginout'>Loginout</a></li>
					";
				}else{
					echo "<li><a href='/login' class=''>Login</a></li>";
				} ?>
			</ul>
		</div>
	</div>
	<div id="pageBody">
		<div id="hotProductList" class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">热卖商品</h3>
			</div>
			<div class="panel-body">
			</div>
		</div>
		<div id="newProductList" class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">新品商品</h3>
			</div>
			<div class="panel-body">
			</div>
		</div>
		<div id="allProductList" class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">全部商品</h3>
			</div>
			<div class="panel-body">
			</div>
		</div>
	</div>
	
</body>
</html>