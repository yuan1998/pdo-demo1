<?php 

class Hot
{
	public $pdo;

	public function __construct($pdo){
		$this->$pdo;
	}

	public function add($par){
		if(!is_numeric($id))
			return ['success'=>false,'msg'=>'id type error'];
		$r = $this->pdo->prepare("insert into hot id values :id")->execute(['id'=>$par['id']]);
		return result($r);
	}

	public function remove($par){

	}

	public function id_verify($id){
		return $this->pdo->query("select * from hot where id=$id")->fetch(PDO::FETCH_ASSOC);
	}

	public function read(){
		return $this->pdo->query("select * from hot")->fetch(PDO::FETCH_ASSOC);
	}

	public function result($r){
		return $r ? ['success'=>true] : ['success'=>false,'msg'=>'pdo error'];
	}
	
}