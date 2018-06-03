<?php
  include "database.php";
  $connessione = explode(",", file_get_contents('linfo.txt'));
  $servername = $connessione[0];
  $database   = $connessione[1];
  $username   = $connessione[2];
  $password   = $connessione[3];
  $db = new Database();
  $db->setLogInfo($servername, $database, $username, $password);

  // PayPal settings
  $paypal_email = 'aziendeexpo@gmail.com';
  $return_url = 'https://aziendeexpo.it/payment-successful.html';
  $cancel_url = 'https://aziendeexpo.it/payment-cancelled.html';
  $notify_url = 'https://aziendeexpo.it/res/payments.php';

  $item_name = "Pubblicità dell'azienda";
  $item_amount = 5.00;

  // Include Functions
  include("functions.php");

  // Check if paypal request or response
  if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
  	$querystring = '';

  	// Firstly Append paypal account to querystring
  	$querystring .= "?business=".urlencode($paypal_email)."&";

  	// Append amount& currency (£) to quersytring so it cannot be edited in html

  	//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
  	$querystring .= "item_name=".urlencode($item_name)."&";
  	$querystring .= "amount=".urlencode($item_amount)."&";

  	//loop for posted values and append to querystring
  	foreach($_POST as $key => $value){
  		$value = urlencode(stripslashes($value));
  		$querystring .= "$key=$value&";
  	}

  	// Append paypal return addresses
  	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
  	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
  	$querystring .= "notify_url=".urlencode($notify_url);

  	// Append querystring with custom field
  	//$querystring .= "&custom=".USERID;

  	// Redirect to paypal IPN
  	header('location:https://ipnpb.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
  	exit();
  } else {
  	// Response from Paypal

  	// read the post from PayPal system and add 'cmd'
  	$req = 'cmd=_notify-validate';
  	foreach ($_POST as $key => $value) {
  		$value = urlencode(stripslashes($value));
  		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
  		$req .= "&$key=$value";
  	}

  	// assign posted variables to local variables
  	$data['item_name']			= $_POST['item_name'];
  	$data['item_number'] 		= $_POST['item_number'];
  	$data['payment_status'] 	= $_POST['payment_status'];
  	$data['payment_amount'] 	= $_POST['mc_gross'];
  	$data['payment_currency']	= $_POST['mc_currency'];
  	$data['txn_id']				= $_POST['txn_id'];
  	$data['receiver_email'] 	= $_POST['receiver_email'];
  	$data['payer_email'] 		= $_POST['payer_email'];
  	$data['custom'] 			= $_POST['custom'];

  	// post back to PayPal system to validate
  	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
  	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
  	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

  	$fp = fsockopen ('ipnpb.sandbox.paypal.com/cgi-bin/webscr', 443, $errno, $errstr, 30);

  	if (!$fp) {
      fputs($fp, $header . $req);
      file_put_contents('testingpaypalipn.txt', print_r($POST, true));
  	} else {
  		fputs($fp, $header . $req);
      file_put_contents('testingpaypalipn.txt', print_r($POST, true));
  		while (!feof($fp)) {
  			$res = fgets ($fp, 1024);
  			if (strcmp($res, "VERIFIED") == 0) {
  				// Validate payment (Check unique txnid & correct price)
  				$valid_txnid = check_txnid($data['txn_id'], $db);
  				$valid_price = check_price($data['payment_amount'], $data['item_number']);

          file_put_contents('testingpaypalipn.txt', print_r($POST, true));
  				// PAYMENT VALIDATED & VERIFIED!
  				if ($valid_txnid && $valid_price) {

  					$orderid = updatePayments($data, $db);

  					if ($orderid) {
  						 $db->sponsorizza($data['payer_email']);
  					} else {
              file_put_contents('testingpaypalipn.txt', print_r($POST, true));
  						// Error inserting into DB
  						// E-mail admin or alert user
  						// mail('user@domain.com', 'PAYPAL POST - INSERT INTO DB WENT WRONG', print_r($data, true));
  					}
  				} else {
            file_put_contents('testingpaypalipn.txt', print_r($POST, true));
  					// Payment made but data has been changed
  					// E-mail admin or alert user
  				}

  			} else if (strcmp ($res, "INVALID") == 0) {
          fputs($fp, $header . $req);
          file_put_contents('testingpaypalipn.txt', print_r($POST, true));
        }
  		}
  	fclose ($fp);
  	}
  }
?>
