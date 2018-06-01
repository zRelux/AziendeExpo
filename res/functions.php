<?php
// functions.php
function check_txnid($tnxid, $db){
	$valid_txnid = true;

  $valid_txnid = $db->checktxnId($tnxid);

	return $valid_txnid;
}

function check_price($price, $id){
	$valid_price = false;

	$num = 5.00;

  if($num == $price){
			$valid_price = true;
	}

	return $valid_price;

	return true;
}

function updatePayments($data, $db){
    $lastid = $db->insertPayment($data);
		return $lastid;
}
