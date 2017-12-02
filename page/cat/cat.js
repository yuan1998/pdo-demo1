$(function(){
	'use strict';
	const cat = new Model('cat');
	const el_catForm = document.querySelector('#catForm');
	const el_catList = document.querySelector('#catList');

	let id= null;

	cat.read(1,cat_List_Render);
	cat.read(1,render);


	el_catForm.addEventListener('submit',function(e){
		e.preventDefault();
		let data = get_Form_Data(e.target);
		if(id){
			data.id = id;
			cat.update(data);
		}else{
			cat.add(data);
		}
		id= null;
		cat.read(1,render);
	})

	function cat_List_Render(data){
		let select = el_catForm.querySelector('[name=pid]');
		console.log(select);
		select.innerHTML= '';
		let s = document.createElement('option');
		s.innerText = '一级分类';
		s.value = 0;
		select.appendChild(s);
		for(let item of data){
			let option = document.createElement('option');
			option.innerText = item.title;
			option.value = item.id;
			select.appendChild(option);
		}
	}

	function get_Form_Data(el){
		let el_item =  el.querySelectorAll('[name]');
		let data = {};
		for(let item of el_item){
			data[item.name] = item.value;
		}
		return data;
	}

	function render(data){
		el_catList.innerHTML = '';
		for(let item of data){
			let el = document.createElement('tr');
			el.innerHTML = `
			<td>${item.title}</td>
			<td>
				<button class="update btn btn-primary">更新</button>
				<button class="delete btn btn-danger">删除</button>
			</td>
			`;

			el.querySelector('.delete').addEventListener('click',function(){
				if(confirm('确定要删除嘛？')){
					cat.delete(item.id,callBack);
					cat.read(1,render);
				}
			})
			el.querySelector('.update').addEventListener('click',function(){
				fill_Form_Data(el_catForm,item);
			})
			el_catList.appendChild(el);
		}
	}

	function callBack(msg){
		alert(msg);
	}

	function fill_Form_Data(el,data){
		let el_item =  el.querySelectorAll('[name]');
		for(let item of el_item){
			item.value = data[item.name];
		}
		id = data.id;
	}

})