$(function(){
	'use strict';
	const product = new Model('product');
	const cat = new Model('cat');
	const el_productForm = document.querySelector('#productForm');
	const el_productList = document.querySelector('#productList');
	const el_prev = document.querySelector('.prev');
	const el_next = document.querySelector('.next');
	const el_current = document.querySelector('.current');
	let pageNum = el_current.querySelector('a');

	let id = null;
	let page = {
		'c' : null,
		'now' : 1,
		'o' :null,
	}


	init();

	// on page load out run function 
	function init(){
		cat.read({'order':{'by':'id','sort':'asc'}},cat_List_Render);  //get cat list
		product.read({'page':1},render);	 //get product list and render to page
		product.count(pageCount);           //get page count 
		el_productForm.addEventListener('submit',function(e){ // product form add Event
			e.preventDefault();
			let data = get_Form_Data(e.target);    // get form content
			if(id){                              // judgment id run update or add
				data.id = id;
				product.update(data,callBack); 
				id = null;
			}else{
				product.add(data,callBack);   
			}
			product.read({'page':1},render);  // reload list data to page
			e.target.reset();				 // reduction form
		})
	}

	// monitor page change 
	Object.defineProperty(page,'o',{
		set:function(value){ 
			this.now = value;
			pageNum.innerText = value; 
		},
		get:function(){
			return this.now;
		}
	})

	// get page count 
	function pageCount(data){
		page.c = Math.ceil(data / 10);
		page.now = 1;
		el_prev.addEventListener('click',function(e){ // monitor prev and next
			e.preventDefault();
			if(page.now == 1)
				return;
			page.o = --page.now;
			product.read({'page':page.now},render);
		})
		el_next.addEventListener('click',function(e){
			e.preventDefault();
			if(page.now == page.c)
				return;
			page.o = ++page.now;
			product.read({'page':page.now},render);
		})
	}

	

	function cat_List_Render(data){
		let select = el_productForm.querySelector('[name=cat]');
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

	function callBack(msg){
		alert(msg);
	}

	function render(data){
		el_productList.innerHTML = '';
		for(let item of data){
			let el = document.createElement('tr');
			el.innerHTML = `
			<td>${item.title}</td>
			<td>${item.price}</td>
			<td>${item.info}</td>
			<td>${item.stock}</td>
			<td>${item.cat}</td>
			<td>
				<input type="checkbox" name="hot" ${item.hot ? 'checked' :''} class="hot" />
				<input type="checkbox" name="new" ${item.new ? 'checked' :''} class="new" />
				<button class="update btn btn-primary">更新</button>
				<button class="delete btn btn-danger">删除</button>
			</td>
			`;
			checked(el.querySelector('[name=hot]'),item.id);
			checked(el.querySelector('[name=new]'),item.id);


			el.querySelector('.delete').addEventListener('click',function(){
				if(confirm('确定要删除嘛？')){
					product.delete(item.id,callBack);
					product.read({'page':1},render);
				}
			})
			el.querySelector('.update').addEventListener('click',function(){
				fill_Form_Data(el_productForm,item);
			})
			el_productList.appendChild(el);
		}
	}

	function checked(el,id){
		el.addEventListener('click',function(e){
			el.checked
			let data  = {'id':id};
			data[el.name] = Number(el.checked);
			product.update(data,callBack);
		})

		
	}

	function fill_Form_Data(el,data){
		let el_item =  el.querySelectorAll('[name]');
		for(let item of el_item){
			item.value = data[item.name];
		}
		id = data.id;
	}
})