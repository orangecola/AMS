<?php 
	include ('components/config.php');
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
	else if (isset($_GET['expirydate'])) {
		$header = 'Expiring before ' . $_GET['expirydate'];
		$result = $user->downloadReport('expirydate', $_GET['expirydate']);
	}
	else if (isset($_GET['everything'])) {
		$header = 'Asset Register';
		$result = $user->downloadReport('nehr_Asset.asset_tag', '%');
	}
	else {
		header('Location: generatereport.php');
	}
	$objPHPExcel = new PHPExcel();
	$ActiveSheetIndex = 0;
	if (isset($result['hardware']) and sizeof($result['hardware']) > 0) {
		if ($ActiveSheetIndex > 0) {
			$objPHPExcel->createSheet();
		}
		$objPHPExcel->setActiveSheetIndex($ActiveSheetIndex);
		$objPHPExcel->getActiveSheet()->setTitle('Hardware');
		
		$headers = $user->getHeaders('nehr_Hardware');
		$rownumber = 1;
	
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $data['COLUMN_NAME']);
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
		$rownumber++;
		foreach ($result['hardware'] as $row) {
			
			foreach ($headers as $key=>$data) {
				$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $row[$data['COLUMN_NAME']]);
			}
			$rownumber++;
		}
		$rownumber += 2;
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
		
		$ActiveSheetIndex++;
	}
	
	if (isset($result['software']) and sizeof($result['software']) > 0) {
		if ($ActiveSheetIndex > 0) {
			$objPHPExcel->createSheet();
		}
		$objPHPExcel->setActiveSheetIndex($ActiveSheetIndex);
		$objPHPExcel->getActiveSheet()->setTitle('Software');
		$rownumber = 1;
		$headers = $user->getHeaders('nehr_Software');
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $data['COLUMN_NAME']);
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
		$rownumber++;
		foreach ($result['software'] as $row) {
			
			foreach ($headers as $key=>$data) {
				$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $row[$data['COLUMN_NAME']]);
			}
			$rownumber++;
		}
		
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
	}
	
	if (isset($result['renewal']) and sizeof($result['renewal']) > 0) {
		if ($ActiveSheetIndex > 0) {
			$objPHPExcel->createSheet();
		}
		$objPHPExcel->setActiveSheetIndex($ActiveSheetIndex);
		$objPHPExcel->getActiveSheet()->setTitle('Renewals');
		$rownumber = 1;
		$headers = $user->getHeaders('nehr_Renewal');
		
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $data['COLUMN_NAME']);
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
		$rownumber++;
		foreach ($result['renewal'] as $row) {
			
			foreach ($headers as $key=>$data) {
				$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $row[$data['COLUMN_NAME']]);
			}
			$rownumber++;
		}
		
		foreach ($headers as $key=>$data) {
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
		}
	}
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
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
	$objWriter->save('php://output');
?>