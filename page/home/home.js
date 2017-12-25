$(function(){
	'use strict';
	const product = new Model('product', '.list', '.form');
	const allProductList = document.querySelector('#allProductList .panel-body');
	const hotProductList = document.querySelector('#hotProductList .panel-body');
	const newProductList = document.querySelector('#newProductList .panel-body');


	const loginout = document.querySelector('.loginout');


	init();

	function init(){
		product.read({'page':1,'limit':32},productRender,allProductList);
		product.read({'page':1,'limit':32,'where':{'hot':1}},productRender,hotProductList);
		product.read({'page':1,'limit':32,'where':{'new':1}},productRender,newProductList);

		if(loginout){
			loginout.addEventListener('click',function(e){
			e.preventDefault();
			$.get('/a/user/loginout',function(res){
				if(res.success)
					window.location.reload();
			})
		})
		}
	}

	function productRender(data, el){
		el.innerHTML = '';
		for(let item of data){
			let div = document.createElement('div');
			div.classList = "productItem col-xs-4 col-md-3";
			div.innerHTML = `
				<img src="" alt="" />
				<div class="caption">
					<h3>${item.title}</h3>
					<p>
						${item.info||'-'}
					</p>
					<p>¥${item.price}</p>
					<p><a href="" class="btn btn-info">TSET</a></p>
				</div>
			`;
			el.appendChild(div);
		}
	}

	



})