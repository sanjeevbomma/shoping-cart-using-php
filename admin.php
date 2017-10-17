<?php
	include("db_fn.php");
	
	$view=empty($_GET['view'])? 'index' : $_GET['view'];
	$controller="admin";
	switch($view){
		case "index":
			$orders=find_orders();
		break;
	}
	include($_SERVER['DOCUMENT_ROOT'].'/'.'gamelist/views/layouts/'.$controller.'.php');
?>