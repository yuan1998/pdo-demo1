<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

	tpl('PHPMailer/src/Exception');
	tpl('PHPMailer/src/PHPMailer');
	tpl('PHPMailer/src/SMTP');
	
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
		$email = filter_var(@$par['email'], FILTER_VALIDATE_EMAIL);
		if(!$email)
			return e('有误的邮箱.');
		if($this->emailExist($email))
			return e('邮箱已存在.');
		$regtime = time(); 
		$token = md5($username.$password.$regtime);
		$token_exptime = time()+60*60*24;
		$password = $this->hash_password($password);
		$data = ['username'=>$username,
				'password'=>$password,
				'email'=>$email,
				'token'=>$token,
				'token_exptime'=>$token_exptime,
				'regtime'=>$regtime];
		$r = $this->_add($data);
		if(!$r)
			return e('未知错误');
		die();
		$mailer = new PHPMailer();
		return $this->sendEmail($mailer,$email,$username,$token);
	}

	public function sendEmail($mail,$email,$username,$token){
		// var_dump($email);
		// $mail->SMTPDebug=1;
		$mail->isSMTP();  
		$mail->SMTPAuth = true;   
		$mail->Host = 'smtp.mailgun.org'; 
		$mail->SMTPSecure = 'sll';
		$mail->Prot = '465';

		$mail->CharSet = 'UTF-8';
		$mail->Username = 'postmaster@sandbox4ecdff98c08f47b3beb5ba37345737fd.mailgun.org';
		$mail->Password = '3322123aa';
		$mail->isHTML(true);
		$mail->From = 'no-reply@sandboxc77c3a9be90a494081dad1628d554337.mailgun.or';
		$mail->FormName = 'TEST';
		$mail->addAddress($email);

		$mail->Subject="激活";
		// $mail->Body = 'yo';
		$mail->Body =  "亲爱的".$username."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/><a href='http://localhost:3322/api/user/active?token=".$token."' target='_blank'>http://localhost:3322/api/user/active?token=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";
    	if(!$mail->send()){
    		return e($mail->ErrorInfo);	
    	}else{
			return s();		
    	}
	
			// "curl -d "apiUser=yuan1998_test_Ifx6bo&apiKey=3tciZaPStK2MBegg&to=976629445@qq.com&from=service@UWRSQtD3ZeHwJlQGMfblNmUjaWPiq4k7.sendcloud.org&fromname=SendCloud测试邮件&subject=来自SendCloud的第一封邮件！&html=你太棒了！你已成功的从SendCloud发送了一封测试邮件，接下来快登录前台去完善账户信息吧！&respEmailId=true" http://api.sendcloud.net/apiv2/mail/send"
	

	 // exec("curl -s --user 'api:key-2cc1c0292ed8b13725fe9b13675c078e' \
  //   https://api.mailgun.net/v3/sandbox4ecdff98c08f47b3beb5ba37345737fd.mailgun.org/messages \
  //   -F from='yo@yo.org' \
  //   -F to=sandbox4ecdff98c08f47b3beb5ba37345737fd.mailgun.org \
  //   -F to=chizhiyueshu1@qq.com \
  //   -F subject='Hello' \
  //   -F text='ok'");
    	
	}

	public function hash_password($password){
		return md5(md5($password).'xyee');
	}

	public function active ($par){
		$token = @$par['token'];


		$r = $this->_read(['where'=>['token'=>$token]]);
		if(!$r)
			e('验证码已失效.请重新发送');

		$user = $r[0];
		
		if($user['token_exptime'] < time())
			return e('验证码已失效.请重新发送');
		$r = $this->_update(['where'=>['id'=>$user['id']],'condition'=>['status'=>1,'token'=>0,'token_exptime'=>0]]);
		return $r ? s() : e('失败.');
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

	public function emailExist($email){
		$r = $this->_read(['where'=>['email'=>$email]]);
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