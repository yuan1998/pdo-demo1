<?php 
class User extends Model{
	public $pdo;
	public $table = 'user';

	public function __construct($pdo){
		$this->pdo=$pdo;
	}

	public function read($par){
		if($par['id'])
			if(!is_numeric($par['id']))
				return e('输入ID有误.');
		$r = $this->_read($par);
		return s($r);
	}

	public function changePassword($par){
		$oldPassword = @$par['oldPassword'];
		$username = @$par['username'];
		$newPassword = @$par['newPassword'];

		if(!$username || !$this->userVerify($username,$oldPassword))
			return e('用户信息有误');
		$newPassword = $this->hash_password($newPassword);

		$r = $this->_update(['where'=>['username'=>$username],'condition'=>['password'=>$newPassword]]);
		return $r ? s() : e('error');
	}

	public function signup($par){
		$username = @$par['username'];
		$password = @$par['password'];
		if(!$username || $this->userExist($username))
			return e('用户名错误或已存在.');
		if(!$password)
			return e('输入的密码有误.');
		$password = $this->hash_password($password);
		$r = $this->_add(['condition'=>['username'=>$username,'password'=>$password]]);
		return $r ? s() : e('未知错误.');
	}

	public function hash_password($password){
		return md5(md5($password).'xyee');
	}

	public function login($par){
		if(!$par['username']||!$par['password'])
			return e('用户名和密码有误.');
		$user = $this->userVerify($par['username'],$par['password']);
		if(!$user)
			return e('用户名和密码有误.');
		if($user['permissions'] = 0)
			return e('用户已被封锁.');

		$_SESSION['user'] = $user;
		$_SESSION['user']['loginTime'] = time();
		return s();
	}

	public function loginout(){
		unset($_SESSION['user']);
		if(isset($_SESSION['user']))
			return e('发生未知错误');
		return s();
	}

	public function userExist($name){
		$r = $this->_read(['where'=>['username'=>$name]]);
		return $r[0];
	}

	public function usernameVerify($par){
		if(!$par['username'])
			return false;
		if($this->userExist($par['username']))
			return false;
		return true;
	}

	public function userVerify($username,$password){
		$password = $this->hash_password($password);
		$r = $this->_read(['where'=>['username'=>$username,'password'=>$password]]);
		return $r[0];
	}

	public function update($par){
		if($_SESSION['user']['permissions'] < 9)
			return e('权限不足');
		$id = $par['id'];
		if($par['password'])
			$par['password'] = $this->hash_password($par['password']);
		$oldData = $this->_read(['id'=>$id])[0];
		if(!$oldData)
			return e('id unexists');
		$newData = array_merge($oldData,$par);
		$newData['data'] = json_encode($newData['data']);
		unset($newData['id']);
		$r = $this->_update(['where'=>['id'=>$id],'condition'=>$newData]);
		return $r ? s():e('未知错误.');
	}
}
?>