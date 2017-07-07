<?php
	
	include('components/config.php');
	
	$result = $user->getPurchaseOrderFile($_GET['id']);
	
	if ($result['filecontent'] != "") { 
	header("Content-length: " . $result['filesize']);
	header("Content-type: " . $result['filetype']);
	header("Content-Disposition: attachment; filename=".$result['filename']);
	echo $result['filecontent'];
	}
	else {
		header("Location: purchaseorder.php");
	}
?>