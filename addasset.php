<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <title>NEHR AMS User Management</title>

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
	include_once('config.php');
	$DateError=0;
	$AssetError=0;
	$Success=0;
	$ParentError=0;
	$options = $user->getOptions();
	$distinct = $user->getDistinct();
	
	foreach($distinct[3] as &$value) {
		$value = $value[0];
	}
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$asset['asset_ID'] 			= trim($_POST['assetid']);
		$asset['description'] 		= trim($_POST['description']);
		$asset['quantity'] 			= trim($_POST['quantity']);
		$asset['price']				= trim($_POST['price']);
		$asset['currency']			= trim($_POST['currency']);
		$asset['crtrno']	 		= trim($_POST['crtrno']);
		$asset['purchaseorder_id'] 	= trim($_POST['pono']);
		$asset['release_version']	= trim($_POST['release']);
		$asset['expirydate']		= trim($_POST['expirydate']);
		$asset['remarks']			= trim($_POST['remarks']);
		$asset['parent']			= trim($_POST['parent']);
		$asset['status'] 			= trim($_POST['status']);
		$asset['version']			= 1;
		
		if (isset($_POST['software']) and isset($_POST['hardware'])) {
			$AssetError = 1;
		}
		
		else if (isset($_POST['software'])) {
			$asset['vendor'] 				= trim($_POST['vendor']);
			$asset['procured_from']			= trim($_POST['procure']);
			$asset['shortname']				= trim($_POST['shortname']);
			$asset['purpose'] 				= trim($_POST['purpose']);
			$asset['contract_type']			= trim($_POST['contracttype']);
			$asset['start_date']			= trim($_POST['startdate']);
			$asset['license_explanation']	= trim($_POST['license']);
			
			if (!($user->check_date($asset['start_date']))) {
				$DateError = 1;
			}
		}
		
		
		else if (isset($_POST['hardware'])) {
			$asset['class'] 		= trim($_POST['class']);
			$asset['brand']			= trim($_POST['brand']);
			$asset['audit_date'] 	= trim($_POST['auditdate']);
			$asset['component']		= trim($_POST['component']);
			$asset['label']			= trim($_POST['label']);
			$asset['serial'] 		= trim($_POST['serial']);
			$asset['location'] 		= trim($_POST['location']);
			$asset['replacing']		= trim($_POST['replacing']);
			
			if (!(in_array($asset['replacing'], $distinct[3])) and $asset['replacing'] != "") {
				$ParentError = 1;
			}
		}
		
		
		if (!($user->check_date($asset['expirydate']))) {
				$DateError = 1;
		}
		
		if (!(in_array($asset['parent'], $distinct[3])) and $asset['parent'] != "") {
				$ParentError = 1;
		}
		
		if (in_array($asset['asset_ID'], $distinct[3])) {
				$AssetError = 1;
		}
		
		if ($DateError == 0 and $AssetError == 0 and $ParentError == 0) {
			if (isset($_POST['software'])) {
				$user->addSoftware($asset);
			}
			else if (isset($_POST['hardware'])) {
				$user->addHardware($asset);
			}
			$Success = 1;
		}
		
	}



?>  
  
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php
			include('sidebar.php');
		?>
		<script>
			document.getElementById('addasset.php').setAttribute("class", "current-page");
			var asset_ID = <?php echo json_encode($distinct[3]); ?>;
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
                    <h2>Add Asset</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  <?php
				  if ($AssetError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> Asset ID already exists
                  </div>';} 
				  
				  if ($DateError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> Date Error
                  </div>';}
				  
				  if ($ParentError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> Parent Asset ID Does not exist
                  </div>';}
				  
				  if ($Success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Success</strong> Asset created successfully
                  </div>';}
				  
				  ?>
                    <br />
                    <form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
					  <?php require 'asset.php'; ?>

					<!-- Tabs -->

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true" onclick="software()">Software Asset</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false" onclick="hardware()">Hardware Asset</a>
                        </li>
						<script>
							function software() {
								document.getElementsByName("software")[0].removeAttribute("disabled");
								document.getElementsByName("vendor")[0].removeAttribute("disabled");
								document.getElementsByName("procure")[0].removeAttribute("disabled");
								document.getElementsByName("shortname")[0].removeAttribute("disabled");
								document.getElementsByName("purpose")[0].removeAttribute("disabled");
								document.getElementsByName("contracttype")[0].removeAttribute("disabled");
								document.getElementsByName("startdate")[0].removeAttribute("disabled");
								document.getElementsByName("license")[0].removeAttribute("disabled");
								
								document.getElementsByName("hardware")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("class")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("brand")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("auditdate")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("component")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("label")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("serial")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("location")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("replacing")[0].setAttribute("disabled", "disabled");
							};
							
							function hardware() {
								document.getElementsByName("software")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("vendor")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("procure")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("shortname")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("purpose")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("contracttype")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("startdate")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("license")[0].setAttribute("disabled", "disabled");
								
								document.getElementsByName("hardware")[0].removeAttribute("disabled");
								document.getElementsByName("class")[0].removeAttribute("disabled");
								document.getElementsByName("brand")[0].removeAttribute("disabled");
								document.getElementsByName("auditdate")[0].removeAttribute("disabled");
								document.getElementsByName("component")[0].removeAttribute("disabled");
								document.getElementsByName("label")[0].removeAttribute("disabled");
								document.getElementsByName("serial")[0].removeAttribute("disabled");
								document.getElementsByName("location")[0].removeAttribute("disabled");
								document.getElementsByName("replacing")[0].removeAttribute("disabled");
							};
							software();
						</script>
						
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                      <?php require 'software.php'?>
						<div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						  <button class="btn btn-primary" type="reset">Reset</button>
						  <input type="hidden" name="software" value="type">
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
							<?php require 'hardware.php' ?>
						<div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						  <button class="btn btn-primary" type="reset">Reset</button>
						  <input type="hidden" name="hardware" value="type" disabled="disabled">
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                        </div>
                      </div>
                    </div>
					<!-- /tabs -->
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
	<!--Bootstrap-daterangepicker-->
	<script src="vendors/moment/min/moment.min.js"></script>
	<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- jQuery autocomplete -->
    <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	<script>
	$('#parent').autocomplete({
		lookup: asset_ID,
		onSelect: function () {

    }
	});
	
	$('#replacing').autocomplete({
		lookup: asset_ID,
		onSelect: function () {

    }
	});
	</script>
	</body>
</html>
