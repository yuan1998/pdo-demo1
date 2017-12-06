$(function(){
	'use strict';

	const user = new Model('user');

	let errorMsg ={
		'email':{
			'type':'请输入正确的邮箱.',
			'empty':'邮箱不能为空.',
			's':'邮箱不能包含空格',
			'exist':'邮箱已存在.'
		},
		'username':{
			'empty':'用户名不能为空.',
			's':'用户名不能包含空格.',
			'exist':'用户名已存在.'
		},
		'password':{
			'empty':'密码不能为空',
			'range':'密码长度在6位到16位之间',
			's':'密码不能包含空格'
		},
		'repeat':{
			'empty':'请再次输入密码',
			'equal':'输入的密码不一致',
		}
	}

	function FormVerify(){
		this.form = document.querySelector('#signForm');
		this.el_u = this.form.querySelector('.usernameLabel');
		this.el_e = this.form.querySelector('.emailLabel');
		this.el_p = this.form.querySelector('.passwordLabel');
		this.el_pr = this.form.querySelector('.cPasswordLabel');


		this.el_password = this.form.querySelector('[name=password]');
		this.el_password_repeat = this.form.querySelector('[name=password-repeat]');
		this.el_username = this.form.querySelector('[name=username]');
		this.el_email = this.form.querySelector('[name=email]');


		this.rule = document.querySelector('#rule');
		this.emailReg = /^[\w\d\.\-\_]+[@][\w\d]+(\.[0-9a-zA-Z]+)+$/;
	    this.passwordReg = /^[\@\sA-Za-z0-9\!\#\$\%\^\&\*\.\~\(\)\_\-\+\=\[\]\{\}\`\;\:\'\"\,\<\.\>\/\?\|\\]{6,22}$/;

		this.init = function(){
			this.inputEvent();
			this.submitEvent();
			this.ruleconfirm();
		}
		this.init();
	}

	FormVerify.prototype.ruleconfirm = function(){
		let agree = this.rule.querySelector('.agree');
		let disagree = this.rule.querySelector('.disagree');
		let me = this;

		agree.addEventListener('click',function(e){
			let data = me.get_Form_Data(me.form);
			$.post('/a/user/signup',data).then(function(res){
				if(res.success){
					window.location.href = '/login';
				}
			})
		})

		disagree.addEventListener('click',function(e){
			me.rule.hidden = true;
		})

	}

	FormVerify.prototype.submitEvent = function (){
		let me = this;
		this.form.addEventListener('submit',function(e){
			e.preventDefault();
			if(!me.submitVerify())
				return;
			me.rule.hidden = false;
		})
	}

	FormVerify.prototype.submitVerify = function (){
		user.read({'where':{'email':this.el_email.value}},this.emailJudgment,this);
		user.read({'where':{'username':this.el_username.value}},this.usernameJudgment,this);
		this.passwordJudgment();
		this.repeatPasswordJudgment();
		if(this.el_e.classList.contains('has-error'))
			return false;
		else if(this.el_p.classList.contains('has-error'))
			return false;
		else if(this.el_pr.classList.contains('has-error'))
			return false;
		else if(this.el_u.classList.contains('has-error'))
			return false;
		else return true;
	}
	FormVerify.prototype.inputEvent = function (){
		let me = this;
		this.el_email.addEventListener('blur',function(){
			user.read({'where':{'email':this.value}},me.emailJudgment,me);
		})
		this.el_username.addEventListener('blur',function(){
			user.read({'where':{'username':this.value}},me.usernameJudgment,me);
		})
		this.el_password.addEventListener('blur',function(){
			me.passwordJudgment();
		})
		this.el_password_repeat.addEventListener('blur',function(){
			me.repeatPasswordJudgment();
		})
	}
	FormVerify.prototype.usernameJudgment = function (data,me){
		let val = me.el_username.value;
		if(val == ''){
			addClass(me.el_u,'has-error');
		}
		else if(/\s/.test(val)){
			addClass(me.el_u,'has-error');
		}
		else if(val.length < 8 ){
			addClass(me.el_u,'has-error');
		}
		else if(data[0]){
			addClass(me.el_u,'has-error');
		}
		else removeClass(me.el_u,'has-error');
	}

	FormVerify.prototype.emailJudgment = function (data,me){
		let val = me.el_email.value;
		if(val == ''){
			addClass(me.el_e,'has-error');
		}
		else if(/\s/.test(val)){
			addClass(me.el_e,'has-error');
		}
		else if(!me.emailReg.test(val)){
			addClass(me.el_e,'has-error');
		}
		else if(data[0]){
			addClass(me.el_e,'has-error');
		}
		else removeClass(me.el_e,'has-error');
	}	
	FormVerify.prototype.passwordJudgment = function (){
		let val = this.el_password.value;
		if(val == ''){
			addClass(this.el_p,'has-error');
		}
		else if(!this.passwordReg.test(val)){
			addClass(this.el_p,'has-error');
		}
		else removeClass(this.el_p,'has-error');
	}
	FormVerify.prototype.repeatPasswordJudgment = function(){
		let password = this.el_password.value;
		let again = this.el_password_repeat.value;
		if(again == '')
			addClass(this.el_pr,'has-error');
		else if(again.length < 6 )
			addClass(this.el_pr,'has-error');
		else if(again !== password)
			addClass(this.el_pr,'has-error');
		else removeClass(this.el_pr,'has-error');
	}
	FormVerify.prototype.get_Form_Data = function(el){
		let input =el.querySelectorAll('[name]');
		let data = {};
		for(let item of input){
			data[item.name] = item.value;
		}
		return data;
	}




	let inp = new FormVerify;

	function addClass(el,klass){
		el.classList.add(klass);
	}
	function removeClass(el,klass){
		el.classList.remove(klass);
	}

})