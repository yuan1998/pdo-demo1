$(function(){
	'use srtict';
	const el_form = document.querySelector("#loginForm");


	el_form.addEventListener('submit',function(e){
		e.preventDefault();
		let data = get_Form_Data(e.target);
		$.post('/a/user/login',data).then(function(res){
			if(res.success)
				window.location.href = '/home';
			displayError(res.msg);
		})
	})

	function displayError(msg){
		
	}

	function get_Form_Data(el){
		let itemList = el.querySelectorAll('[name]');
		let data ={};
		for(let i of itemList){
			data[i.name] = i.value;
		}
		return data;
	}
})