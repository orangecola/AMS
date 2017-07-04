<?php 
	include ('config.php');
	include('vendors/PHPExcel/Classes/PHPExcel/IOFactory.php');
	ini_set('memory_limit', '1024M');
	date_default_timezone_set('Asia/Singapore');
	$time = date("Y-m-d H:i:s");
	$path = $time.".xlsx";
	
	if(isset($_GET['purchaseorderid'])) {
		$header = "Purchase Order ". $_GET['purchaseorderid'];
		$result = $user->downloadReport('purchaseorder_id', $_GET['purchaseorderid']);
		$purchaseorder = $user->getPurchaseOrder($_GET['purchaseorderid']);
	}
	else if(isset($_GET['release'])) {
		$header = 'Release ' . $_GET['release'];
		$result = $user->downloadReport('release_version', $_GET['release']);
	}
	else if (isset($_GET['crtrno'])) {
		
		$header = 'CR / TR No ' . $_GET['crtrno'];
		$result = $user->downloadReport('crtrno', $_GET['crtrno']);
	}
	else {
		header('Location: generatereport.php');
	}
	//echo '<script>';
	//echo "console.log(".json_encode($result).");";
	//echo '</script>';
	
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', $header);
	$objPHPExcel->getActiveSheet()->SetCellValue('A2', $time);
	$rownumber = 3;
	if (sizeof($result['hardware'] > 0)) {
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rownumber, 'Software');
		$rownumber++;
		$headers = array_merge($user->assetFields, $user->hardwareFields);
		
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $data);
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
		$rownumber++;
		foreach ($result['hardware'] as $row) {
			
			foreach ($headers as $key=>$data) {
				$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $row[$data]);
			}
			$rownumber++;
		}
		$rownumber += 2;
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
	}
	
	if (sizeof($result['software'] > 0)) {
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rownumber, 'Hardware');
		$rownumber++;
		$headers = array_merge($user->assetFields, $user->hardwareFields);
		
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $data);
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
		$rownumber++;
		foreach ($result['hardware'] as $row) {
			
			foreach ($headers as $key=>$data) {
				$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $row[$data]);
			}
			$rownumber++;
		}
		
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
	}
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save($path);
	
	//Serve the file to the client
	ob_clean();
	header("Content-Description: File Transfer");
	header("Content-Type: application/octet-stream");
	header('Content-Disposition: attachment; filename="'.basename($path).'"');
	header("Content-Transfer-Encoding: binary");
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header("Content-Type: application/force-download");
	header("Content-Type: application/download");
	header("Content-Length: ".filesize($path));
	readfile($path);
	exit;
?>