<?php

function db_connect(){
	$connection=mysql_pconnect('localhost','root','');
	if(!$connection){
		return false;
	}
	if(!mysql_select_db('gamelist')){
		return false;
	}
	return $connection;
}
	if(db_connect()){
		//echo "Connected</br>";
	}
	function db_result_to_array($result){
		$res_array=array();
		for($count=0;$row=mysql_fetch_array($result);$count++){
			$res_array[$count]=$row;
		}
		return $res_array;
	}
	function find_products(){
		db_connect();
		$query="SELECT * FROM products ORDER BY products.id DESC";
		$result=mysql_query($query);
		$result=db_result_to_array($result);
		return $result;
	} 
	function find_product($id){
		db_connect();
		$query=sprintf("SELECT * FROM products WHERE products.id='%s'",mysql_real_escape_string($id));
		$result=mysql_query($query);
		$row=mysql_fetch_array($result);
		return $row;
	} 
	//$product=find_product(1);
	//$product=find_products(1);
	
	//foreach ($products as $product) {
		# code...
	
	//	echo $product['tittle'];
	//}

	function find_orders(){
		db_connect();
		$query="SELECT * FROM orders ORDER BY orders.id DESC";
		$result=mysql_query($query);
		$result=db_result_to_array($result);
		return $result;
	} 

  function find_order($id)
 {
 	 db_connect();
 	 
 	 $query="SELECT * FROM orders WHERE orders.id='$id'";
 	 
 	 $result = mysql_query($query);

	 $result=db_result($result);

	 if(!$result)
	 {
		 echo mysql_error();
	 }
	 return $result;

 }
// find items

function find_items($id){
		db_connect();
		$query=sprintf("SELECT * FROM items WHERE order_id='%s'",mysql_real_escape_string($id));
		$result=mysql_query($query);
		$result=mysql_fetch_array($result);
		return $result;
		}
	 
	
?>