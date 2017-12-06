<?php 
class Model {

	public function _read($param){
		$id = @$param['id'];
		$page = @$param['page'];
		$limit = $param['limit'] ?: 10 ;
		$like = @$param['like'];
		$where = @$param['where'];
		$order = @$param['order'];
		$sql_where = $sql_limit = $sql_order = $sql_like = '';
		if($id){
			$sql = "select * from $this->table where id = $id";
		}else{
			if($page){
				$page = ($page-1)*10 ;
				$sql_limit = " limit $page,$limit";	
			}
			$by = $order['by'] ?: 'id';
			$sort = $order['sort'] ?: 'desc';
			$sql_order = " order by $by $sort ";
			if($where){
				$sql_where = " where ";
				$i = 0;
				foreach($where as $key => $val){
					$cond = " $key = '{$val}' ";
					if($i>0)
						$cond = ' and '.$cond;
					$i++;
					$sql_where .= $cond ;
				}
			}
			if($like){
				if($where){
					$sql_like = ' and ';
				}else{
					$sql_where = " where ";					
				}
				$i = 0;
				foreach ($like as $key => $value) {
					$cond = " $key like '%{$value}%' ";
					if($i>0)
						$cond = ' and '.$cond;
					$i++;
					$sql_like .= $cond ;
				}
			}
			$sql = "select * from $this->table $sql_where $sql_like $sql_order $sql_limit";
		}
		$r = $this->pdo->prepare($sql);
		$r->execute();
		return $r->fetchALL(PDO::FETCH_ASSOC);
	}

	public function _readCount(){
		$sql = "select count(*) from $this->table";
		$r = $this->pdo->prepare($sql);
		$r->execute();
		return $r->fetch(PDO::FETCH_NUM)[0];
	}

	public function descTable(){
		$r = $this->pdo->prepare("desc $this->table");
		$r->execute();
		return $r->fetchAll(2);
	}

	public function columnList(){
		$list = $this->descTable();
		$nList = [];
		foreach($list as $col){
			$nList[] = $col['Field'];
		}
		return $nList;
	}



	public function _add($param){
		$condition = $param;
		$sql_value = $sql_col = '';
		$colName = $this->columnList();
		unset($condition['id']);
		foreach ($condition as $key => $value) {
			if(in_array($key, $colName)){
				$sql_col .= "$key,";
				$sql_value .= "'{$value}',";	
			}
		}
		$sql_value = trim($sql_value,',');
		$sql_col = trim($sql_col,',');
		$sql ="insert into $this->table ($sql_col) values ($sql_value) ";
		$r = $this->pdo->prepare($sql)->execute();
		return $r;
	}

	public function _remove($param){
		$condition = $param['condition'];
		if(!$condition)
			return false;
		$sql_where =' where ';
		$i = 0;
		foreach ($condition as $key => $value) {
			$cond = " $key = '{$value}' ";
			if($i > 0)
				$cond = " and $cond ";
			$sql_where .= $cond;
			$i++;
		}
		$sql = "delete from $this->table $sql_where";
		$r = $this->pdo->prepare($sql)->execute();
		return $r;
	}

	public function _update($param){

		$where = $param['where'];
		$data = $param['condition'];
		if(!$where)
			return false;
		$sql_where = " where ";
		$j = 0 ;
		foreach ($where as $key => $value) {
			$cond = " $key = '{$value}' ";
			if($i>0)
				$cond = " and $cond";
			$i++;
			$sql_where .= $cond;
		}
		$sql_set = 'set ';
		$i = 0;
		foreach ($data as $key => $value) {
			$cond = " $key = '{$value}' ";
			if($i>0)
				$cond = ",$cond";
			$i++;
			$sql_set .= $cond;
		}
		$sql = "update $this->table $sql_set $sql_where";
		// var_dump($sql);
		// die();
		$r = $this->pdo->prepare($sql)->execute();
		return $r;
	}

}


 ?>