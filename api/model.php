<?php 
class Model extends Validator{

	/*
	*
	* table sturcture list.
	*/
	public $structureField;

	/*
	*
	*
	*
	* instance class of the time run function.
	*
	*/
	public function __construct(){
		/*
		*
		* get column list to structureField .
		*
		*/
		$this->structureField = $this->columnList();
	}

	public function _read($param){

		/*
		*
		*
		*
		* get have to condition.
		*
		*/
		$id = @$param['id'];
		$page = @$param['page'];
		$limit = $param['limit'] ?: 10 ;
		$like = @$param['like'];
		$where = @$param['where'];
		$order = @$param['order'];

		/*
		*
		*
		*
		* ready sql item.
		*
		*/
		$sql_where = $sql_limit = $sql_order = $sql_like = '';


		if($id){
			/*
			*
			* if id exist ,return id in table.
			*
			*
			*/
			$sql = "select * from $this->table where id = $id";


		}else{
			/*
			*
			*judge page exist. 
			*
			*
			*/
			if($page){
				$page = ($page-1)*10 ;
				$sql_limit = " limit $page,$limit";	
			}

			/*
			*
			*
			*default generate order.
			*
			*/

			$by = $order['by'] ?: 'id';
			$sort = $order['sort'] ?: 'desc';
			$sql_order = " order by $by $sort ";


			/*
			*
			*
			*judge where exist. 
			*
			*/
			if($where){
				/*
				*
				*
				* get sql statement.
				*
				*/
				$sql_where =" where ".$this->equal_comma($where,'and');
			}

			/*
			*
			*
			*judge like exist. 
			*
			*/
			if($like){

				/*
				*
				*
				* judge where exist.if where exist,like equal and.
				*
				*/
				$sql_like = $where ? ' and ': " where ";
				/*
				*
				*
				* get sql statement.
				*
				*/
				$sql_like .= $this->equal_comma($like,'and',true) ;
			}


			/*
			*
			*
			* compose sql statement.
			*
			*/
			$sql = "select * from $this->table $sql_where $sql_like $sql_order $sql_limit";
		}

		/*
		*
		*
		* run sql. return result.
		*
		*/

		$r = $this->pdo->prepare($sql);
		$r->execute();
		return $r->fetchALL(2);
	}



	/*
	*
	*
	* get now table rows conut.
	*
	*/

	public function _readCount(){
		/*
		*
		*
		* run sql , get table rows counts.
		*
		* ready sql.
		*/
		$sql = "select count(*) from $this->table";

		$r = $this->pdo->prepare($sql);

		/*
		*
		*
		*
		* run sql.
		*/
		$r->execute();

		/*
		*
		*
		* reutrn result.
		*/
		return $r->fetch(PDO::FETCH_NUM)[0];
	}


	/*
	*
	*
	*
	* get now table structure.
	*
	*/

	public function descTable(){
		/*
		*
		*
		* run sql ,get table desc.
		*
		*/
		$r = $this->pdo->prepare("desc $this->table");

		$r->execute();

		/*
		*
		*
		* return result.
		*
		*/
		return $r->fetchAll(2);
	}


	/*
	*
	*
	*
	* get structure field.
	*
	*/
	public function columnList(){
		$list = $this->descTable();
		$nList = [];
		foreach($list as $col){
			$nList[] = $col['Field'];
		}
		return $nList;
	}




	/*
	*
	*
	*
	*
	*
	* iteration arr get sql statement.
	*
	*/
	public function equal_comma ($arr,$symbol,$like=false){
		/*
		* init $wait.
		*/
		$wait = '';
		/*
		*
		*
		* 
		* iteration arr generate sql statement.
		*/

		foreach ($arr as $key => $value) {
			
			/*
			*
			*
			*
			* judge key is it legal.
			*
			*/
			if(in_array($key,$this->structureField))

				/*
				*
				*
				*
				* judge paramas in like exist.
				*
				*/
				if(!$like){
					/*
					*
					* like unexist.
					*
					* with where.
					*/
					$wait .= " $key = '{$value}' $symbol";
				}else{

					/*
					*
					*
					* like exist.
					*
					* with like.
					*/
					$wait .= " $key like '%$value%' $symbol";
				}
		}

		/*
		*
		*
		*
		*
		* reutrn $wait.
		*
		*/
		return trim($wait,$symbol) ;
	}

	/*
	*
	*
	*
	* 
	* sql statement method.
	*/
	public function sql_comma ($arr,$symbol,$value=false){
		/*
		* init $wait.
		*/

		$wait = '';

		/*
		*
		*
		* iteration arr.
		*
		*/
		foreach ($arr as $key => $val) {
			
			/*
			*
			*
			*
			* judge key is it legal.
			*/
			if(in_array($key, $this->structureField)){
				/*
				*
				*
				*
				* params in the $value if exist.
				*/
				if($value){
					/*
					*
					*
					*
					* with value.
					*/
					$wait .= "'$val'$symbol";
				}else{
					/*
					*
					*
					* with key.
					*
					*/
					$wait .=$key.$symbol;
				}
			}
		}
		/*
		*
		* return $wait .
		* 
		*/
		return trim($wait,$symbol);
	}

	/*
	*
	*
	*
	* all table add core.
	*
	*/
	public function _add($param,&$error=null,$valided = true){
		/*
		*
		*
		* 
		* remove id .because not needed.
		*/
		unset($param['id']);

		if($valided)
			if(!$this->validateForm($param,$error))
				return false;
			
		/*
		*
		*
		*
		* get core sql statement.
		*/

		$sql_value = $this->sql_comma($param,',',true);
		$sql_col = $this->sql_comma($param,',');
		/*
		*
		*
		*
		* run sql return result.
		*/
		$sql ="insert into $this->table ($sql_col) values ($sql_value) ";
		$r = $this->pdo->prepare($sql)->execute();
		if(!$r)
			$error = '未知错误.';
		return $r;
	}


	/*
	*
	*
	*
	*
	* core remove method.
	*/
	public function _remove($param){
		/*
		*
		*
		*
		*
		* get params inner condition.
		*/
		$condition = $param['condition'];

		/*
		*
		*
		*
		* not condtion return error.
		*
		*/
		if(!$condition)
			return false;
		/*
		*
		*
		*
		* get where statement.
		*/
		$sql_where = $this->equal_comma($condition,'and');


		/*
		*
		*
		*
		* run sql return result.
		*
		*/
		$sql = "delete from $this->table where $sql_where";
		$r = $this->pdo->prepare($sql)->execute();
		return $r;
	}
	/*
	*
	*
	*
	*
	* core update method.
	*
	*/
	public function _update($param,&$error){
		/*
		*
		*
		*
		* get where of param.  
		*/
		$where = $param['where'];

		/*
		*
		*
		*
		* get data of param.  
		*/
		$data = $param['condition'];



		if(!$this->validateForm($data,$error))
			return false;


		/*
		*
		*
		*
		*
		* judge where exist , if there is not.return false.
		*/
		if(!$where)
			return false;
		/*
		*
		*
		*
		* get where statement.
		*/
		$sql_where = $this->equal_comma($where,'and');


		/*
		*
		*
		*
		* get set statement.
		*/
		$sql_set = $this->equal_comma($data,',');


		/*
		*
		*
		*
		*
		* run sql statement , return result.
		*
		*/
		$sql = "update $this->table set $sql_set where $sql_where";
		$r = $this->pdo->prepare($sql)->execute();
		return $r;
	}

}


 ?>