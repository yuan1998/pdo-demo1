<?php 
session_start();
require_once('./model.php');
require_once('./cat.php');
require_once('./product.php');
require_once('./user.php');


function new_pdo(){
	$dsn = 'mysql:host=127.0.0.1;prot=3306;dbname=shop';
	$user = 'test1';
	$password = '123';
	$options = [
	    PDO::ATTR_CASE => PDO::CASE_NATURAL, /*PDO::CASE_NATURAL | PDO::CASE_LOWER 小写，PDO::CASE_UPPER 大写， */
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, /*是否报错，PDO::ERRMODE_SILENT 只设置错误码，PDO::ERRMODE_WARNING 警告级，如果出错提示警告并继续执行| PDO::ERRMODE_EXCEPTION 异常级，如果出错提示异常并停止执行*/
	    PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL, /* 空值的转换策略 */
	    PDO::ATTR_STRINGIFY_FETCHES => false, /* 将数字转换为字符串 */
	    PDO::ATTR_EMULATE_PREPARES => false, /* 模拟语句准备 */
	];

	return new PDO($dsn,$user,$password,$options);	
}

function getParams(){
	$params = array_merge($_GET,$_POST);

	$klass = ucfirst(@$params['model']);

	$action = @$params['action'];

	if(!class_exists($klass))
		return ['success'=>'false','msg'=>'model error.'];

	$model = new $klass(new_pdo());

	if(!method_exists($model,$action))
		return ['success'=>'false','msg'=>'action error.'];

	unset($params['model'],$params['action']);

	return $model->$action($params);
}

function e($msg){
	return ['success'=>false,'msg'=>$msg];
}
function s($data=null){
	return ['success'=>true,'data'=>$data];
}


function json($data){
	header('Content-Type: application/json');
	return json_encode($data);
}

function init(){
	echo json(getParams());

}
init();








