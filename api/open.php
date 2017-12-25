<?php 
tpl('api/validator');
tpl('api/model');
tpl('api/cat');
tpl('api/product');
tpl('api/user');


function new_pdo(){
	$dsn = 'mysql:host=127.0.0.1;prot=3306;dbname=shop';
	$user = 'test1';
	$password = '123';
	$options = [
	    PDO::ATTR_CASE => PDO::CASE_NATURAL, 
	    /*PDO::CASE_NATURAL | PDO::CASE_LOWER 小写，PDO::CASE_UPPER 大写， */
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
	    /*是否报错，PDO::ERRMODE_SILENT 只设置错误码，PDO::ERRMODE_WARNING 警告级，如果出错提示警告并继续执行| PDO::ERRMODE_EXCEPTION 异常级，如果出错提示异常并停止执行*/
	    PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL, 
	    /* 空值的转换策略 */
	    PDO::ATTR_STRINGIFY_FETCHES => false, 
	    /* 将数字转换为字符串 */
	    PDO::ATTR_EMULATE_PREPARES => false, 
	    /* 模拟语句准备 */
	];
	return new PDO($dsn,$user,$password,$options);	
}

function getParams($uri){
	$uri = trim(trim($uri,'/'),'a/');
	$uri = explode('?',$uri)[0];
	$model = explode('/',$uri);

	$action = $model[1];

	$klass = ucfirst($model[0]);

	if(!permisstionVerify($klass,$action)){
		return e('权限不足.');
	}


	$params = array_merge($_GET,$_POST);


	// $action = @$params['action'];

	if(!class_exists($klass))
		return ['success'=>'false','msg'=>'model error.'];

	$model = new $klass(new_pdo());

	if(!method_exists($model,$action))
		return ['success'=>'false','msg'=>'action error.'];

	// unset($params['model'],$params['action']);

	return $model->$action($params);
}

function e($msg){
	return ['success'=>false,'msg'=>$msg];
}
function s($data=null){
	return ['success'=>true,'data'=>$data];
}

function permisstionVerify($klass,$action){
	
	$public = [
		'User'=>['login','loginout','signup','changePassword','userExist','active','emailExist'],
		'Cat'=>['read','printTrees'],
		'Product'=>['read','getCount','test','descTable'],
	];


	$config =[
		'User'=>[
			'read'=>5,
			'update'=>5
		],
		'Cat'=>[
			'add'=>2,
			'remove'=>2
		],
		'Product'=>[
			'add'=>2,
			'remove'=>2,
			'update'=>2,
		]
	];

	// var_dump($config[$klass]);

	if($public[$klass]){
		$model = $public[$klass];
		if(in_array($action,$model))
			return true;
	}

	if(!$_SESSION['user'])
		return false;

	if($config[$klass]){
		$model = $config[$klass];
		$per = $_SESSION['user']['permissions'];
		if($model[$action] <= $per)
			return true;
	}
	return false;
}


function json($data){
	header('Content-Type: application/json');
	return json_encode($data);
}

function init($url){
	echo json(getParams($url));
}









