<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <title>NEHR AMS</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

<?php 
	include('config.php');
	$Success = 0;
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type = $_POST['type'];
        $inputFileName= $_FILES['csv']['tmp_name'];
		$data = array();
		include 'vendors/PHPExcel/Classes/PHPExcel/IOFactory.php';
		ini_set('memory_limit', '500M');
		try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName); //Identify the file
            $objReader = PHPExcel_IOFactory::createReader($inputFileType); //Creating the reader
            $objPHPExcel = $objReader->load($inputFileName); //Loading the file
			
			$sheet = $objPHPExcel->getSheet(1);     		//Selecting sheet 0
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
?>  
  
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <?php include('sidebar.php')?>
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
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

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

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- validator -->
    <script src="vendors/validator/validator.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	
  </body>
</html>
