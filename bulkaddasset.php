<?php 
	include('components/config.php');
	$Success = 0;
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type = $_POST['type'];
        $inputFileName= $_FILES['csv']['tmp_name'];
		$data = array();
		include('vendors/PHPExcel/Classes/PHPExcel/IOFactory.php');
		ini_set('memory_limit', '1024M');
		try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName); //Identify the file
			$objReader = PHPExcel_IOFactory::createReader($inputFileType); //Creating the reader
            
			$objReader->setReadDataOnly(true);
			
			
			$objPHPExcel = $objReader->load($inputFileName); //Loading the file
			
			$sheet = $objPHPExcel->getSheet(0);     		//Selecting sheet 0
			$highestRow = $sheet->getHighestRow();     		//Getting number of rows
			$highestColumn = $sheet->getHighestColumn();    //Getting number of columns
			

			$headers = $sheet->rangeToArray('A3:' . $highestColumn . '3', NULL, TRUE, FALSE);
		
		
			for ($row = 4; $row <= $highestRow; $row++) {
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				$newrow = array();
				foreach($headers[0] as $key=>$value) {
					if (isset($rowData[0][$key])) {
						$newrow[$value] = $rowData[0][$key];
					}
					$data[$row-4] = $newrow;
				}
			}
			
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
            . '": ' . $e->getMessage());
        }
		
		if ($type == 'software') {
			$user->bulkaddsoftware($data);
		}
		if ($type == 'hardware') {
			$user->bulkaddhardware($data);
		}
		$Success = 1;
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
                <h3>Asset Management</h3>
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
                    <strong>Success</strong> Data Added Successfully
                  </div>';}
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
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
        <!-- /page content -->
        <?php
			include 'components/footer.php';
			include 'components/closing.php';
		?>