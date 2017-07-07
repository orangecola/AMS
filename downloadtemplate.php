<?php 
	include ('components/config.php');
	include('vendors/PHPExcel/Classes/PHPExcel/IOFactory.php');
	ini_set('memory_limit', '1024M');
	$path = $_GET['type'].".xlsx";
	if(isset($_GET['type'])) {
		$header = $user->getHeaders($_GET['type']);
	}
	else {
		header('Location: hardwarelist.php');
	}
	
	if ($header != null) {
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	
	$rownumber = 1;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rownumber, $_GET['type'].' Import. DO NOT EDIT THE FIRST 2 ROWS');
		$rownumber++;
		$key = 0;
		foreach ($header as $data) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr($key + 65).$rownumber, $data['COLUMN_NAME']);
			$objPHPExcel->getActiveSheet()->getColumnDimension(chr($key + 65))->setAutoSize(true);
			$key++;
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
	exit;
	}
?>