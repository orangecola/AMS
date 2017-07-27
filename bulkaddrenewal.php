<?php 
	include('components/config.php');
	$wrongPassword = 0;
	$Success = 0;
	$errorRow = array();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputFileName= $_FILES['csv']['tmp_name'];
		$data = array();
		include('vendors/PHPExcel/Classes/PHPExcel/IOFactory.php');
		ini_set('memory_limit', '1024M');
		try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName); //Identify the file
			$objReader = PHPExcel_IOFactory::createReader($inputFileType); //Creating the reader
            
			//$objReader->setReadDataOnly(true);	
			$objPHPExcel = $objReader->load($inputFileName); //Loading the file
			
			$sheet = $objPHPExcel->getSheet(0);     		//Selecting sheet 0
			$highestRow = $sheet->getHighestRow();     		//Getting number of rows
			$highestColumn = $sheet->getHighestColumn();    //Getting number of columns
			
			$distinct = $user->getDistinct();
			
			foreach($distinct[3] as &$value) {
				$value = $value[0];
			}
			unset($value);
			for ($row = 3; $row <= $highestRow; $row++) {
				$asset[$row]['asset_ID'] 			= $sheet->getCell('A'.$row)->getValue();
				$asset[$row]['parent_ID'] 			= trim($sheet->getCell('B'.$row)->getValue());
				$asset[$row]['purchaseorder_id']	= $sheet->getCell('C'.$row)->getValue();
				$asset[$row]['startdate']			= $sheet->getCell('D'.$row)->getValue();
				$asset[$row]['expiry_date']			= $sheet->getCell('E'.$row)->getValue();
				
				if (PHPExcel_Shared_Date::isDateTime($sheet->getCell('D'.$row))) {
						$asset[$row]['startdate'] = date('m/d/Y', PHPExcel_Shared_Date::ExcelToPHP($asset[$row]['startdate']));
				}
				
				if (PHPExcel_Shared_Date::isDateTime($sheet->getCell('E'.$row))) {
						$asset[$row]['expiry_date'] = date('m/d/Y', PHPExcel_Shared_Date::ExcelToPHP($asset[$row]['expiry_date']));
				}
				
				//Copy Asset ID if it is blank
				if ($asset[$row]['asset_ID'] == "") {
					$asset[$row]['asset_ID'] = $asset[$row]['parent_ID'];
				}
				
				//Null Check
				foreach ($asset[$row] as $key=>$value) {
					if ($value === "") {
						$errorRow['null'][] = $row;
					}
				}
				
				//Date Check
				if (!($user->check_date($asset[$row]['expiry_date']) and $user->check_date($asset[$row]['startdate']))) {
					$errorRow['date'][] = $row;
				}
					
				//Parent ID Check
				if (!(in_array($asset[$row]['parent_ID'], $distinct[3]))) {
					$errorRow['parent'][] = $row;
				}
			}
			if ((sizeof($errorRow) == 0) and (sizeof($asset) > 0)) {
				$user->bulkAddRenewal($asset);
				$Success = 1;
			}
        } catch (Exception $e) {
			echo $e->getMessage();
            $FileUploadError = 1;
        }
	}
	include('components/sidebar.php')
?>  
  
<script>
	document.getElementById('bulkaddrenewal.php').setAttribute("class", "current-page");
</script>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>Asset Management</h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Bulk Add Renewals</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
		  <?php 
			if ($Success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Success</strong> '.sizeof($asset).' Renewals Added Successfully
                  </div>';}
				  if (isset($errorRow['number'])) 
				  {
					echo 
					'<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<strong>Error</strong> Number Errors in Rows ';
					foreach ($errorRow['number'] as $row) echo $row." ";
					echo '</div>';
				  }
				  if (isset($errorRow['null'])) 
				  {
					echo 
					'<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<strong>Error</strong> Missing Fields in Rows ';
					foreach ($errorRow['null'] as $row) echo $row." ";
					echo '</div>';
				  }
				  if (isset($errorRow['date'])) 
				  {
					echo 
					'<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<strong>Error</strong> Date Format Error in Rows ';
					foreach ($errorRow['date'] as $row) echo $row." ";
					echo '</div>';
				  }
				  if (isset($errorRow['parent'])) 
				  {
					echo 
					'<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<strong>Error</strong> Parent Asset Not Found in Rows ';
					foreach ($errorRow['parent'] as $row) echo $row." ";
					echo '</div>';
				  }
		  ?>
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Excel File to import
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="file" class="form-control col-md-7 col-xs-12"  name="csv">
				</div>
			  </div>
			  <div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a class="btn btn-default" href="downloadtemplate.php?type=nehr_Renewal"><i class="fa fa-download"></i> Download Template</a></a>
				  <button type="submit" class="btn btn-success">Submit</button>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>
</div>
</div>
<!-- /page content -->

<?php 
	require 'components/footer.php';
	require 'components/closing.php';
?>
