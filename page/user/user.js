$(function(){
	'use srtict';

	const user = new Model('user');
	const el_list = document.querySelector('#userList tbody');

	init();
	function init(){
		user.read({},render);
	}

	function render(data){
		el_list.innerHTML= '';
		for(let item of data){
			let tr = document.createElement('tr');
			tr.innerHTML = `
				<td>${item.username}</td>
				<td>${select()}</td>
				<td></td>
			`;
			let el = tr.querySelector('[name=permissions]');
			el.value = item.permissions;
			selectEvent(el,item.id);
			el_list.appendChild(tr);
		}
	}

	function selectEvent(el,id){
		el.addEventListener('change',function(e){
			user.update({"permissions":el.value,'id':id},callBack);
		})
	}
	function callBack(msg){
		alter(msg);
	}

	function select(){
		return `<select name="permissions">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="999">999</option>
					</select>`
	}
})