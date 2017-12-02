$(function(){
	'use strict';

	window.Model = function Model(model){
		if(!model)
			throw('model Error.');
		this.url = '/api/open.php?model='+model;
		this.list = [];
		// this.init = functon() {
		// 	this.el = document.querySelector(elSelector);
		// }
		// this.init();
	}

	Model.prototype.read = function(data,callback,el){
		$.post(this.url+'&action=read',data).then(function(res){
			this.list = res;
			if(callback)
				callback(res.data,el);
		})
	}

	Model.prototype.add = function(data,callback){
		$.post(this.url+'&action=add',data)
		.then(function(res){
			if(!res.success)
				callback(res.msg);
		})
	}
	Model.prototype.update = function(data,callback){
		$.post(this.url+'&action=update',data).then(function(res){
			if(!res.success)
				callback(res.msg);
		})
	}
	Model.prototype.delete = function(id,callback){
		$.post(this.url+'&action=remove&id='+id).then(function(res){
			if(!res.success)
				callback(res.msg);
		})
	}
	Model.prototype.count = function(callback){
		$.get(this.url+'&action=getCount',function(res){
			if(res.success)
				callback(res.data);
		})
	}
})