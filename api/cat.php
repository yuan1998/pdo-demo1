<?php 

class Cat extends Model{
	public $pdo;
	public $table = 'cat'; 
	public function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function add($params){
		$data=[
			'title'=>@$params['title'],
			'pid'=>@$params['pid'] ?: 0
		];
		if(!$data['title'] || !is_numeric($data['pid'])||$this->titleExists($data['title']))
			return e('标题有误或已存在.');
		if($data['pid'] != 0)
			if(!$this->id_verify($data['pid']))
				return e('pid error');
		$r = $this->_add($data);
		return $r ? s() : e('未知错误.');
	}

	public function titleExists($title){
		$r = $this->_read(['where'=>['title'=>$title]]);
		return $r[0];
	}

	public function read($params){
		if($params['id'])
			if(!is_numeric($params['id']))
				return e('ID 有误');
		$r = $this->_read($params);
		return s($r);
	}

	public function remove($params){
		$id = @$params['id'];
		if(!$this->id_verify($id))
			return e('ID 有误');
		if($this->pid_verify($id))
			return e('它是一个父级分类.');
		$r = $this->_remove(['condition'=>['id'=>$id]]);
		return $r ? s() : e('未知错误.');
	}

	public function id_verify($id){
		$ready = $this->_read(['id'=>$id]);
		return $ready[0];
	}

	public function pid_verify($id){
		$ready = $this->_read(['where'=>['pid'=>$id]]);;
		return $ready;
	}

	public function update($par){
		$id = @$par['id'];
		if(!$id || !is_numeric($id))
			return e('输入了错误的ID.');

		$old = $this->id_verify($id);
		if(!$old)
			return e('ID不存在.');

		$data = array_merge($old,$par);
		if(!is_numeric($data['pid']))
			return e('PID 有误.');

		if(!$data['pid'] == 0)
			if(!$this->id_verify($data['pid']) || $data['pid']==$data['id']||$this->pid_verify_for($data['id'],$data['pid']))
				return e('设置的PID有误，请重新操作.');
		if(!$data['title'])
			return e('标题有误.');
		$exist = $this->titleExists($data['title']);
		if($exist && $exist['id'] != $old['id'])
			return e('标题或已存在.');
		unset($data['id']);
		$r = $this->_update(['where'=>['id'=>$id],'condition'=>$data]);
		return $r ? s():e('未知错误.');
	}

	public function pid_verify_for($id,$pid){
		$d = $this->_read(['where'=>['id'=>$pid,'pid'=>$id]]);
		if(!$d){
			$r = $this->pid_verify($id);
			if(!$r)
				return $d;
			foreach($r as $item){
				$d = $this->pid_verify_for($item['id'],$pid);
				if($d)
					break;
			}
		}
		return $d;
	}

	public function printTrees(){
		$list = json_decode(json_encode($this->_read()),true);
		$trees = [];
		foreach($list as $item){
			$trees[$item['id']] = $item;
			$trees[$item['id']]['children'] =[];
		}
		foreach ($trees as $key => $value) {
			if($value['pid'] != 0)
				$trees[$value['pid']]['children'][] = &$trees[$key];
		}
		foreach ($trees as $key => $value) {
			if($value['pid'] != 0){
				unset($trees[$key]);
			}
		}
		return $trees;
	}
}