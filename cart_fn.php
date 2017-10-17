<?php 

function add_to_cart($id){
	if(!isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]++;
		return true;

		
	}
	else{
		$_SESSION['cart'][$id]+=1;
		return true;
	}
		return false;

}
function update_cart(){
	foreach ($_SESSION['cart'] as $id => $qty) {
		if($_POST[$id]=='0'){
				unset($_SESSION['cart'][$id]);
		}
		else{
			$_SESSION['cart'][$id]=$_POST[$id];
		}
	}
}
function total_items($cart){
	$num_items=0;
	if(is_array($cart)){
		foreach ($cart as $id => $qty) {
			$num_items += $qty;
		}
	}
	return $num_items;

}
function total_price($cart){
	$num_items=0;
	$price=0;
	$connection=db_connect();
	if(is_array($cart)){
		foreach ($cart as $id => $qty) {
			$query=sprintf("SELECT price FROM products WHERE products.id='$id'",mysql_real_escape_string($id));
			$result=mysql_query($query);
			if($result){
				$item_price=mysql_result($result, 0,'price');
				$price +=$item_price * $qty;
				$num_items += $qty;
			}
		}
	}
	return $price;
}
?>