<?php 
session_start();
require_once('utility/help.php');
tpl('api/open');
$name = $_SERVER['REQUEST_URI'];

if(strpos($name,'/a/') !== false){
	init($name);
	return;
}

switch($name){
	case '/home':
		tpl('page/home/home');
		break;
	case '/product':
		tpl('page/product/product');
		break;
	case '/cat':
		tpl('page/cat/cat');
		break;
	case'/login':
		tpl('page/login/login');
		break;
	case'/user':
		tpl('page/user/user');
		break;
	case'/sign':
		tpl('page/sign/sign');
		break;
	default:
		http_response_code(404);
		die('404 ERROR');
}

// $page = $_GET['page'];
// require_once('page/'.$page.'/'.$page.'.php');
 ?>