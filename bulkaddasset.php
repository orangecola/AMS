<?php 
	include('components/config.php');
	$Success = 0;
	$errorRow = array();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type = $_POST['type'];
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
			

			for ($row = 3; $row <= $highestRow; $row++) {
				$asset[$row]['asset_ID'] 			= $sheet->getCell('A'.$row)->getValue();
				$asset[$row]['description'] 		= $sheet->getCell('B'.$row)->getValue();
				$asset[$row]['quantity']			= $sheet->getCell('C'.$row)->getCalculatedValue();
				$asset[$row]['crtrno']				= $sheet->getCell('D'.$row)->getValue();
				$asset[$row]['purchaseorder_id']	= $sheet->getCell('E'.$row)->getValue();
				$asset[$row]['release_version']		= $sheet->getCell('F'.$row)->getValue();
				$asset[$row]['expirydate']			= $sheet->getCell('G'.$row)->getValue();
				$asset[$row]['status']				= $sheet->getCell('H'.$row)->getValue();
				$asset[$row]['remarks']				= $sheet->getCell('I'.$row)->getValue();
				$asset[$row]['poc']					= $sheet->getCell('J'.$row)->getValue();
				
				//Check quantity
				if (!($user->validatesAsInt($asset[$row]['quantity']))) {
					$errorRow['number'][] = $row;
				}
				
				//Convert Date to Format
				if (PHPExcel_Shared_Date::isDateTime($sheet->getCell('G'.$row))) {
					$asset[$row]['expirydate'] = date('m/d/Y', PHPExcel_Shared_Date::ExcelToPHP($asset[$row]['expirydate']));
				}
				
				//Date Check
				if (!($user->check_date($asset[$row]['expirydate']))) {
					$errorRow['date'][] = $row;
				}	
				
				if ($type == 'hardware') {
					$asset[$row]['IHiS_Asset_ID']	= $sheet->getCell('K'.$row)->getValue();
					$asset[$row]['IHiS_Invoice']	= $sheet->getCell('L'.$row)->getValue();
					$asset[$row]['CR359 / CR506']	= $sheet->getCell('M'.$row)->getValue();
					$asset[$row]['CR560']			= $sheet->getCell('N'.$row)->getValue();
					$asset[$row]['POST-CR560']		= $sheet->getCell('O'.$row)->getValue();
					$asset[$row]['price']			= $sheet->getCell('P'.$row)->getCalculatedValue();
					$asset[$row]['currency']		= $sheet->getCell('Q'.$row)->getValue();
					$asset[$row]['class']			= $sheet->getCell('R'.$row)->getValue();
					$asset[$row]['brand']			= $sheet->getCell('S'.$row)->getValue();
					$asset[$row]['audit_date']		= $sheet->getCell('T'.$row)->getValue();
					$asset[$row]['component']		= $sheet->getCell('U'.$row)->getValue();
					$asset[$row]['label']			= $sheet->getCell('V'.$row)->getValue();
					$asset[$row]['serial']			= $sheet->getCell('W'.$row)->getValue();
					$asset[$row]['location']		= $sheet->getCell('X'.$row)->getValue();
					$asset[$row]['replacing']		= $sheet->getCell('Y'.$row)->getValue();
					$asset[$row]['excelsheet']		= $sheet->getCell('Z'.$row)->getValue();
					$asset[$row]['version']			= 1;
					//Ensure non null values
					foreach ($asset[$row] as $key=>$value) {
						if ($value === "" and 
							$key != 'remarks' and 
							$key != 'replacing' and 
							$key != 'excelsheet') {
							$errorRow['null'][] = $row.$key;
						}
					}
					if (!($user->validatesAsInt($asset[$row]['price']) or $user->validatesAsDouble($asset[$row]['price']))) {
						$errorRow['number'][] = $row;
					}
					//Ensure that if the replacing field is entered, the parent exists in the system
					//if ($asset[$row]['replacing'] != "") {
					//	if (!(in_array($asset[$row]['replacing'], $distinct[3]))) {
					//			$errorRow['parent'][] = $row;
					//	}
					//}
				}
				else if ($type == 'software') {
					$asset[$row]['vendor']				= $sheet->getCell('K'.$row)->getValue();
					$asset[$row]['procured_from']		= $sheet->getCell('L'.$row)->getValue();
					$asset[$row]['shortname']			= $sheet->getCell('M'.$row)->getValue();
					$asset[$row]['purpose']				= $sheet->getCell('N'.$row)->getValue();
					$asset[$row]['contract_type']		= $sheet->getCell('O'.$row)->getValue();
					$asset[$row]['start_date']			= $sheet->getCell('P'.$row)->getValue();
					$asset[$row]['license_explanation']	= $sheet->getCell('Q'.$row)->getValue();
					$asset[$row]['version']				= 1;
					
					if (PHPExcel_Shared_Date::isDateTime($sheet->getCell('P'.$row))) {
						$asset[$row]['start_date'] = date('m/d/Y', PHPExcel_Shared_Date::ExcelToPHP($asset[$row]['start_date']));
					}
					
					//Date Check
					if (!($user->check_date($asset[$row]['start_date']))) {
						$errorRow['date'][] = $row;
					}
					
					//Null Check
					foreach ($asset[$row] as $key=>$value) {
						if ($value === "" and 
							$key != 'remarks' and 
							$key != 'replacing' and 
							$key != 'license_explanation') {
							$errorRow['null'][] = $row;
						}
					}
				}
			}
			if (sizeof($errorRow) == 0 and sizeof($asset) > 0) {
				if ($type == 'software') {
					$user->bulkAddSoftware($asset);
				}
				else if ($type == 'hardware') {
					$user->bulkAddHardware($asset);
				}
				$Success = 1;
			}
			echo '<script>console.log('.json_encode($errorRow).');</script>';
        } catch (Exception $e) {
			echo $e->getMessage();
            $FileUploadError = 1;
        }
	}
	include 'components/sidebar.php';
?>  
  
        <script>
			document.getElementById('bulkaddasset.php').setAttribute("class", "current-page");
		</script>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>NEHR Asset Management</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Bulk Asset Import</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  <?php 
				  
				  if ($Success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Success</strong> '.sizeof($asset).' Assets Added Successfully
                  </div>';}
				  if (isset($errorRow['number'])) 
				  {
					echo 
					'<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<strong>Error</strong> Number Errors in Rows';
					foreach ($errorRow['number'] as $row) echo $row." ";
					echo '</div>';
				  }
				  if (isset($errorRow['null'])) 
				  {
					echo 
					'<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<strong>Error</strong> Missing Fields in Rows';
					foreach ($errorRow['null'] as $row) echo $row." ";
					echo '</div>';
				  }
				  if (isset($errorRow['date'])) 
				  {
					echo 
					'<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<strong>Error</strong> Date Format Error in Rows';
					foreach ($errorRow['date'] as $row) echo $row." ";
					echo '</div>';
				  }
				  if (isset($errorRow['parent'])) 
				  {
					echo 
					'<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						<strong>Error</strong> RMA Asset Not Found in Rows';
					foreach ($errorRow['parent'] as $row) echo $row." ";
					echo '</div>';
				  }
				  ?>
                    <br />
                    <form id="demo-form2" class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Excel File to import
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" class="form-control col-md-7 col-xs-12"  name="csv">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Import Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="type">
                            <option value="software">Software</option>
                            <option value="hardware">Hardware</option>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <a class="btn btn-default" href="downloadtemplate.php?type=nehr_Hardware"><i class="fa fa-download"></i> Hardware Template</a></a>
						  <a class="btn btn-default" href="downloadtemplate.php?type=nehr_Software"><i class="fa fa-download"></i> Software Template</a></a>
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
			include 'components/footer.php';
			include 'components/closing.php';
		?>