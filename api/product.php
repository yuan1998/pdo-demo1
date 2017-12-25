<?php


class Product extends Model{
 	
 	public $pdo;
 	public $table = 'product';
 	public $rule = [
 		'id'=>'int|positive|only:id',
 		'title'=>'maxlength:50|minlength:4',
 		'price'=>'num|positive',
 		'info'=>'string',
 		// 'cover_src'=>'string',
 		'cat'=>'int|positive',
 		'stock'=>'int|positive',
 		'hot'=>'bool',
 		'new'=>'bool',
 		'limit'=>'int|positives',
 		'page'=>'int|positive'
 	];
 	public $unempty = ['title','price','cat'];

	public function __construct($pdo){
		$this->pdo = $pdo;
		parent::__construct();

	}

	public function he_permission($level){
		return @$_SESSION['user']['permissions'] >= $level ;
	}

	public function filterFormData($data){
		$r = [];
		foreach ($data as $key => $value) {
			if(in_array($key,$this->structureField))
				$r[$key] = $value;
		}
		return $r;
	}

	public function add($par){

		$data = $this->filterFormData($par);
		$r = $this->_add($data,$error);
		return $r? s() : e($error);
	}

	public function catExists($id){
		$ready = $this->pdo->prepare("select * from cat where id='{$id}'");
		$ready->execute();
		return $ready->fetch(PDO::FETCH_ASSOC);
	}

	public function read($par){
		if(!$this->validateForm($par,$error,false))
			return e($error);

		$r = $this->_read($par);
		return $r ? s($r) : e('pdo error');
	}

	public function getCount(){
		$r = $this->_readCount();
		return $r ? s($r) : e('pdo error');
	}

	public function remove($par){
		$id = $par['id'];
		if(!$this->id_exists($id))
			return e('id undefine.');
		$r = $this->_remove(['condition'=>['id'=>$id]]);
		return $r ? s(): e('未知错误.');
	}


	public function update($par){
		$id = $par['id'];
		$oldData = $this->id_exists($id);
		if(!$oldData)
			return e('id unexists');
		$newData = array_merge($oldData,$par);
		unset($newData['id']);

		$r = $this->_update(['where'=>['id'=>$id],'condition'=>$newData],$error);

		return $r ? s():e($error?:'未知错误.');
	}
	public function id_exists($id){
		$r = $this->_read(['id'=>$id]);
		return $r[0];
	}

	public function test($par){
		// $r = $this->_read(
		// 	['where'=>['price'=>11]] 
		// );  

		// $r = $this->validateString(true);


		// $r = $this->add(['title'=>'1123','price'=>'1312','cat'=>'1','haha'=>'sasd','info'=>'123k']);

		// $r = $this->validateOnly('弟弟','title');
		// var_dump($r);


		             
		// $data = [
		// 	'title'=>'huiyifan',
		// 	'price'=>'998',
		// 	'cat'=>'1'
		// ];
		// $r = $this->validateForm($data,$error);
		// var_dump($r,$error);
		

		// 'where'=>['title'=>'111','price'=>111],
	}
}

