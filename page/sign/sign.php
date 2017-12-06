<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<?php tpl('utility/component') ?>
	<script src="/page/sign/sign.js"></script>
	<style>
	#rule{
		position:fixed;
		top: 100px;
		right: 0;
		left: 0;
		padding: 10px;
		border:1px solid rgba(0,0,0,0.2);
		background: #fff;
	} 
	#rule p{
		border:1px solid rgba(0,0,0,0.1);

	}
	#rule .btn{
		margin: 10px;
	}

	</style>
</head>
<body>
	<div>
		<form id="signForm" class="form-horizontal row">
			<div class="form-group usernameLabel">
				<label for="inputUsername" class="control-label col-sm-2 col-xs-12">用户名</label>
				<div class="col-sm-8 col-xs-12">
					<input name="username" type="text"  placeholder="Username" class="form-control" id="inputUsername">
				</div>
			</div>
			<div class="form-group emailLabel">
				<label for="inputEmail" class="control-label col-sm-2 col-xs-12">Email</label>
				<div class="col-sm-8 col-xs-12">
					<input name="email" type="text"  placeholder="Email" class="form-control" id="inputEmail">
				</div>
			</div>
			<div class="form-group passwordLabel">
				<label for="inputPassword" class="control-label col-sm-2 col-xs-12">密码</label>
				<div class="col-sm-8 col-xs-12">
					<input name="password" type="password" placeholder="Password" class="form-control"  id="inputPassword">
				</div>
			</div>
			<div class="form-group cPasswordLabel">
				<label for="input-Password" class="control-label col-sm-2 col-xs-12">确认密码</label>
				<div class="col-sm-8 col-xs-12">
					<input name="password-repeat" type="password" class="form-control" placeholder="EnterPassword" id="input-Password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10  col-xs-12">
					<button class="btn btn-default" type="submit">注册</button>
				</div>
			</div>
		</form>
	</div>

	<div id="rule" hidden class="col-md-8 col-md-offset-2 border border-default">
		<h3 class="col-sm-12 text-center">守则</h3>
		<div class="col-sm-12">
			<p class="col-sm-10 col-sm-offset-1"  style="overflow:scroll;height: 500px;">
			如何使用滚动条来显示元素内溢出的内容 - W3School在线测试工具V2
www.w3school.com.cn/tiy/t.asp?f=csse_overflow
如果元素中的内容超出了给定的宽度和高度属性，overflow 属性可以确定是否显示滚动条等行为。 这个属性定义溢出元素内容区的内容会如何处理。如果值为scroll，不论是否需要，用户代理都会提供一种滚动机制。因此，有可能即使元素框中可以放下所有内容也会出现滚动条。默认值是visible。 请在上面的文本框中编辑您的代码，然后 ...
html在文本框中加入滚动条- CSDN博客 - CSDN Blog
blog.csdn.net/zhanghaibing0903/article/details/39832561
2014年10月6日 - 我们都知道大篇幅的文章会占据页面的大部分空间，从而影响页面整体的美观性，而通过为其添加一个带有滚动条的文本框，则能够很好地解决上述问题。下面就是相关语法： style=' color: #ffffff; background-color: #000000; border: solid 2px black; width: 120px; height: 200px;
css实现div自动添加滚动条(图片或文字等超出时显示)_Div+CSS教程_ ...
www.jb51.net › 网页制作 › CSS › Div+CSS教程
css实现div自动添加滚动条比较实用的功能，当图片或文字超出div所规定的宽或高时，会自动出现滚动条，这一点还是比较有利于用户体验的，本文整理了一些实现自动滚动条的方法，感兴趣的朋友不妨参考下，或许对你认识css设置滚动条 ... 如果设为visible，将导致额外的文本溢出到右边或左边（视direction属性设置而定）的单元格。
html滚动条textarea属性设置_HTML/Xhtml_网页制作_脚本之家
www.jb51.net › 网页制作 › HTML/Xhtml
本文介绍html滚动条textarea属性设置:overflow内容溢出时的设置,scrollbar-3d-light-color立体滚动条亮边的颜色等等相关设置,有需要的朋友可以详细参考下，希望 ... 没有滚动条. 复制代码. 代码如下: <body style="overflow-x:hidden;overflow-y:hidden">或<body style="overflow:hidden">. 2.设定多行文本框的滚动条 没有水平滚动条.
html在文本框中加入滚动条- 程序园
www.voidcn.com/article/p-riupsxia-yo.html
2014年10月6日 - 我们都知道大篇幅的文章会占据页面的大部分空间，从而影响页面整体的美观性，如何使用滚动条来显示元素内溢出的内容 - W3School在线测试工具V2
www.w3school.com.cn/tiy/t.asp?f=csse_overflow
如果元素中的内容超出了给定的宽度和高度属性，overflow 属性可以确定是否显示滚动条等行为。 这个属性定义溢出元素内容区的内容会如何处理。如果值为scroll，不论是否需要，用户代理都会提供一种滚动机制。因此，有可能即使元素框中可以放下所有内容也会出现滚动条。默认值是visible。 请在上面的文本框中编辑您的代码，然后 ...
html在文本框中加入滚动条- CSDN博客 - CSDN Blog
blog.csdn.net/zhanghaibing0903/article/details/39832561
2014年10月6日 - 我们都知道大篇幅的文章会占据页面的大部分空间，从而影响页面整体的美观性，而通过为其添加一个带有滚动条的文本框，则能够很好地解决上述问题。下面就是相关语法： style=' color: #ffffff; background-color: #000000; border: solid 2px black; width: 120px; height: 200px;
css实现div自动添加滚动条(图片或文字等超出时显示)_Div+CSS教程_ ...
www.jb51.net › 网页制作 › CSS › Div+CSS教程
css实现div自动添加滚动条比较实用的功能，当图片或文字超出div所规定的宽或高时，会自动出现滚动条，这一点还是比较有利于用户体验的，本文整理了一些实现自动滚动条的方法，感兴趣的朋友不妨参考下，或许对你认识css设置滚动条 ... 如果设为visible，将导致额外的文本溢出到右边或左边（视direction属性设置而定）的单元格。
html滚动条textarea属性设置_HTML/Xhtml_网页制作_脚本之家
www.jb51.net › 网页制作 › HTML/Xhtml
本文介绍html滚动条textarea属性设置:overflow内容溢出时的设置,scrollbar-3d-light-color立体滚动条亮边的颜色等等相关设置,有需要的朋友可以详细参考下，希望 ... 没有滚动条. 复制代码. 代码如下: <body style="overflow-x:hidden;overflow-y:hidden">或<body style="overflow:hidden">. 2.设定多行文本框的滚动条 没有水平滚动条.
html在文本框中加入滚动条- 程序园
www.voidcn.com/article/p-riupsxia-yo.html
2014年10月6日 - 我们都知道大篇幅的文章会占据页面的大部分空间，从而影响页面整体的美观性，</p>
		</div>
		<div class="text-center col-sm-12">
			<button class="agree btn btn-default">同意</button>
			<button class="disagree btn btn-info">关闭</button>
		</div>
	</div>
	
</body>
</html>