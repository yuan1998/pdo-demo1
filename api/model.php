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
				$sql_where .= $this->equal_comma($where,'and');
			}
			if($like){
				$where ? $sql_like = ' and ' : $sql_where = " where ";
				$sql_like .= $this->equal_comma($like,'and',true) ;
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

	public function equal_comma ($arr,$symbol,$like=false){
		$wait;
		$col = $this->columnList();
		foreach ($arr as $key => $value) {
			# code...
			if(in_array($key,$col))
				if(!$like){
					$wait .= " $key = '{$value}' $symbol";
				}else{
					$wait .= " $key like '%$value%' $symbol";
				}
		}
		return trim($wait,$symbol) ;
	}

	public function sql_comma ($arr,$symbol,$value=false){
		$colName = $this->columnList();
		$wait;
		foreach ($arr as $key => $val) {
			if(in_array($key, $colName)){
				if($value){
					$wait .= "'$val'$symbol";
				}else{
					$wait .=$key.$symbol;
				}
			}
		}
		return trim($wait,$symbol);
	}



	public function _add($param){
		unset($param['id']);

		$sql_value = $this->sql_comma($param,',',true);
		$sql_col = $this->sql_comma($param,',');

		$sql ="insert into $this->table ($sql_col) values ($sql_value) ";
		$r = $this->pdo->prepare($sql)->execute();
		return $r;
	}

	public function _remove($param){
		$condition = $param['condition'];
		if(!$condition)
			return false;

		$sql_where = $this->equal_comma($condition,'and');

		$sql = "delete from $this->table where $sql_where";
		$r = $this->pdo->prepare($sql)->execute();
		return $r;
	}

	public function _update($param){

		$where = $param['where'];
		$data = $param['condition'];
		if(!$where)
			return false;

		$sql_where = $this->equal_comma($where,'and');


		$sql_set = $this->equal_comma($data,',');

		$sql = "update $this->table set $sql_set where $sql_where";
		// var_dump($sql);
		// die();
		$r = $this->pdo->prepare($sql)->execute();
		return $r;
	}

}


 ?>