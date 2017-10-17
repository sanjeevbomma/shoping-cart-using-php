<?php
	include("db_fn.php");
	include("cart_fn.php");
	session_start();
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart']=array();
		$_SESSION['total_items']=0;
		$_SESSION['total_price']='0.00';

	}
	$view=empty($_GET['view'])? 'index' : $_GET['view'];
	$controller="shop";
	switch($view){
		case "index":
			$products=find_products();
		break;
		case "add_to_cart":
			$id=$_GET['id'];
			$add_item=add_to_cart($id);
			$_SESSION['total_items']=total_items($_SESSION['cart']);
			$_SESSION['total_price']=total_price($_SESSION['cart']);
			header('location:index.php');
		
		break;
		case "update_cart":
			update_cart();
			$_SESSION['total_items']=total_items($_SESSION['cart']);
			$_SESSION['total_price']=total_price($_SESSION['cart']);
			header('location:index.php?view=checkout');
		
		break;
		case "checkout":
		$shipping=10.0;
			
		break;
		case "thankyou":

		$_SESSION['cart']=array();
		$_SESSION['total_items']=0;
		$_SESSION['total_price']='0.00';
					
		break;
	}
	include($_SERVER['DOCUMENT_ROOT'].'/'.'gamelist/views/layouts/'.$controller.'.php');
?>