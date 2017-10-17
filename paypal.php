
<?php

include('db_fn.php');
db_connect();
$paypal_email="venky99990-facilitator-1@gmail.com";
$payment_currency="USD";
$shipping=10.00;
function no_paypal_trans_id($trans_id){
	$connection=db_connect();
	$query=sprintf("SELECT id FROM products WHERE paypal_trans_id='%s'",mysql_real_escape_string($trans_id));
	$result=mysql_query($query);
	$num_results=mysql_num_rows($result);
	if ($num_results==0) {
		return true;
	}
		return false;
}
function payment_amount_correct($gross_amount,$shipping,$params){
	$amount=0.00;
	for ($i=0; $i <=$params['num_cart_items'] ; $i++) { 
		$query=sprintf("SELECT price FROM products WHERE id='%s'",mysql_escape_string($params["item_number{$i}"]));
		$result=mysql_query($query);
		if ($result) {
			$item_price=mysql_result($result,0, 'price');
			$amount+=$item_price * $params["quantity{$i}"];
		}
	}
	if (($amount+$shipping)==$params['mc_gross']) {

		return true;

	}
	else{
		return false;
	}
}
function create_order($params){
	db_connect();
	$query=sprintf("INSERT INTO orders set orders.firstname='%s',
									orders.lastname='%s',
									orders.email='%s',
									orders.country='%s',
									orders.address='%s',
									orders.city='%s',
									orders.zip_code='%s',
									orders.state='%s',
									orders.status='%s',
									orders.amount='%s',
									orders.paypal_trans_id='%s',
									created_at=NOW()",
									mysql_real_escape_string($params['first_name']),
									mysql_real_escape_string($params['last_name']),
									mysql_real_escape_string($params['payer_email']),
									mysql_real_escape_string($params['address_country']),
									mysql_real_escape_string($params['address_street']),
									mysql_real_escape_string($params['address_city']),
									mysql_real_escape_string($params['address_zip']),
									mysql_real_escape_string($params['address_state']),
									mysql_real_escape_string($params['address_status']),
									mysql_real_escape_string($params['mc_gross']),
									mysql_real_escape_string($params['txn_id'])
									);
		$result=mysql_query($query);
		if (!$result) {
			return false;
		}
		$order_id=mysql_insert_id();
		for($i=0; $i < $params['num_cart_items']; $i++) {
			$product=find_product($params["item_number{$i}"]); 
			echo "something happen".$params["item_number{$i}"];
			$query=sprintf("INSERT INTO items set orders_id='%s',
									product_id='%s',
									tittle='%s',
									price='%s',
									qty='%s'",
									mysql_real_escape_string($order_id),
									mysql_real_escape_string($product['id']),
									mysql_real_escape_string($product['tittle']),
									mysql_real_escape_string($product['price']),
									mysql_real_escape_string($params["quantity{$i}"])
									
									);
			
		}
	
}
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .="&$key=$value";
	}
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	$fp=fsockopen('www.sandbox.paypal.com',80,$errno, $errstr, 30);
	$item_name=$_POST["item_name1"];
	$item_number=$_POST["item_number1"];
	$payment_status=$_POST['payment_status'];
	$payment_amount=$_POST['payment_gross'];
	$payment_currency=$_POST['mc_gross'];
	$txn_id=$_POST['txn_id'];
	$receiver_email=$_POST['receiver_email'];
	$payer_email=$_POST['payer_email'];
if($_POST){
	create_order($_POST);
	print_r($_POST);
}
	
	   if (!$fp) {
          echo $errstr . ' (' . $errno . ')';
     	 } 
      else {
          fputs($fp, $header . $req);
          while (!feof($fp)) {
          $res = fgets($fp, 1024);
              if (strcmp($res, "VERIFIED") == 0) {
                  if (preg_match('/Completed/', $payment_status)                     
					&& no_paypal_trans_id($_POST['txn_id']) 
					&& $paypal_email==$_POST['receiver_email'] 
					&& $payment_currency==$_POST['mc_currency']
					&& payment_amount_correct($shipping,$_POST)){
					create_order($_POST);
					$to="rgukt.raghu-buyer@gmail.com";
					$subject="Orders";
					$message="Some Message".$req;
					$headers='From:webmaster@example.com'."\r\n".
					'Reply-To:webmaster@example.com'."\r\n".
					'X-mailer:PHP'.phpversion();
					mail($to, $subject, $message, $headers);
					echo "VERIFIED";
				}
			}
			
			elseif (strcmp($res, "INVALID")==0) {
				echo "INVALID";

			}
		}
		fclose($fp);
	}

?>