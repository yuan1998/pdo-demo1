<?php


class Product extends Model{
 	
 	public $pdo;
 	public $table = 'product';

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function he_permission($level){
		return @$_SESSION['user']['permissions'] >= $level ;
	}

	public function add($par){
		$data = [
			'cover_src' => @$par['cover_src'],
			'title' => @$par['title'],
			'price' => @$par['price'],
			'cat' => @$par['cat'],
			'info' => @$par['info'],
			'stock' => @$par['stock'] ?: 0,
		];
		if(!$data['title'] ||!is_numeric($data['price'])||!is_numeric($data['stock'])||!$this->catExists((int)$data['cat']))
			return e('params error');
		$r = $this->_add($data);
		return $r? s() : e('未知错误');
	}

	public function catExists($id){
		$ready = $this->pdo->prepare("select * from cat where id='{$id}'");
		$ready->execute();
		return $ready->fetch(PDO::FETCH_ASSOC);
	}

	public function read($par){
		if($par['page'])
			if(!is_numeric($par['page']))
				return e('params page error');
		if($par['id'])
			if(!is_numeric($par['id']))
				return e('params id error');
		if($par['limit'])
			if(!is_numeric($par['limit']))
				return e('params limit error');
		$r = $this->_read($par);
		return $r ? s($r) : e('pdo error');
	}

	public function getCount(){
		$r = $this->_readCount();
		return $r ? s($r) : e('pdo error');
	}

	public function remove($par){
		$id = $par['id'];
		if(!is_numeric($id))
			return e('id type error');
		$result = $this->_read(['id'=>$id]);
		if(!$result)
			return e('id unexists');
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
		$r = $this->_update(['where'=>['id'=>$id],'condition'=>$newData]);
		return $r ? s():e('未知错误.');
	}
	public function id_exists($id){
		$r = $this->_read(['id'=>$id]);
		return $r[0];
	}

	public function test($par){
		$r = $this->_read(
			['like'=>['title'=>'11','price'=>11]]
		);
		var_dump($r);
		// 'where'=>['title'=>'111','price'=>111],
	}
}

