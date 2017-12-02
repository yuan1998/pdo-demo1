
<div id="side-bar" class="col-sm-3">
	<div class="list-group">
		<a href="/home" class="list-group-item">首页</a>
		<a href="/product" class="list-group-item">商品管理</a>
		<a href="/cat" class="list-group-item">分类管理</a>
		<?php if($_SESSION['user']['permissions'] > 3){
			echo "<a href='/user' class='list-group-item'>用户管理</a>";
		} ?>
	</div>
</div>