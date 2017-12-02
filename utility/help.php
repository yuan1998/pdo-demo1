<?php 
function tpl($path){
	require_once(tpl_url($path));
}	

function tpl_url($path){
	return dirname(__FILE__).'/../'.$path.'.php';
}

 ?>