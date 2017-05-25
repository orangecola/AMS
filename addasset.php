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
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$asset_id 		= trim($_POST['assetid']);
		$description 	= trim($_POST['description']);
		$quantity 		= trim($_POST['quantity']);
		$price 			= trim($_POST['price']);
		$crtrno 		= trim($_POST['crtrno']);
		$pono 			= trim($_POST['pono']);
		$release 		= trim($_POST['release']);
		$expiry 		= trim($_POST['expirydate']);
		$remarks 		= trim($_POST['remarks']);
		
		if (isset($_POST['software'])) {
			$vendor 		= trim($_POST['vendor']);
			$procure 		= trim($_POST['procure']);
			$shortname 		= trim($_POST['shortname']);
			$purpose 		= trim($_POST['purpose']);
			$contracttype 	= trim($_POST['contracttype']);
			$startdate 		= trim($_POST['startdate']);
			$license 		= trim($_POST['license']);
			$verification 	= trim($_POST['verification']);
			
			if (!($user->check_date($startdate))) {
				$DateError = 1;
			}
		}
		
		
		if (isset($_POST['hardware'])) {
			$class 			= trim($_POST['class']);
			$brand 			= trim($_POST['brand']);
			$auditdate 		= trim($_POST['auditdate']);
			$component 		= trim($_POST['component']);
			$label 			= trim($_POST['label']);
			$serial 		= trim($_POST['serial']);
			$location 		= trim($_POST['location']);
			$status 		= trim($_POST['status']);
			$replacing 		= trim($_POST['replacing']);
		}
		
		
		if (!($user->check_date($expiry))) {
				$DateError = 1;
		}
		
		if ($DateError == 0 and $AssetError == 0) {
			$user->addasset($asset_id, $description, $quantity, $price, $crtrno, $pono, $release, $expiry, $remarks);
			
			if (isset($_POST['software'])) {
				$user->addSoftware($asset_id, $vendor, $procure, $shortname, $purpose, $contracttype, $startdate, $license, $verification);
			}
			else if (isset($_POST['hardware'])) {
				$user->addHardware($asset_id, $class, $brand, $auditdate, $component, $label, $serial, $location, $status, $replacing);
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
			//document.getElementById('addpurchaseorder.php').setAttribute("class", "current-page");
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
				  
				  if ($Success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Success</strong> Asset created successfully
                  </div>';}
				  
				  ?>
                    <br />
                    <form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Asset ID <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  class="form-control col-md-7 col-xs-12 required"  name="assetid">
                        </div>
                      </div>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Description
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12"  name="description"></textarea>
                        </div>
                      </div>					  
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Quantity
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="quantity">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Price
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="price">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Change Request / Tech Refresh Number
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="crtrno" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order ID
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="pono" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Release version
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="release" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  <div class="item form-group">
					  <label class="control-label col-md 3 col-sm-3 col-xs-12">Expiry Date
					  </label>
					  <fieldset class="col-md-6 col-sm-6 col-xs-12">
                          <div class="control-group">
                            <div class="controls">
                              <div class="xdisplay_inputx form-group">
							  
                                <input type="text" class="form-control " id="single_cal3" placeholder="First Name" name="expirydate" aria-describedby="inputSuccess2Status4">
                                
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                              </div>
                            </div>
                          </div>
                        </fieldset>
						</div>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Remarks
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12"  name="remarks"></textarea>
                        </div>
                      </div>
					  <div class="x_content">


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
								document.getElementsByName("verification")[0].removeAttribute("disabled");
								
								document.getElementsByName("hardware")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("class")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("brand")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("auditdate")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("component")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("label")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("serial")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("location")[0].setAttribute("disabled", "disabled");
								document.getElementsByName("status")[0].setAttribute("disabled", "disabled");
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
								document.getElementsByName("verification")[0].setAttribute("disabled", "disabled");
								
								document.getElementsByName("hardware")[0].removeAttribute("disabled");
								document.getElementsByName("class")[0].removeAttribute("disabled");
								document.getElementsByName("brand")[0].removeAttribute("disabled");
								document.getElementsByName("auditdate")[0].removeAttribute("disabled");
								document.getElementsByName("component")[0].removeAttribute("disabled");
								document.getElementsByName("label")[0].removeAttribute("disabled");
								document.getElementsByName("serial")[0].removeAttribute("disabled");
								document.getElementsByName("location")[0].removeAttribute("disabled");
								document.getElementsByName("status")[0].removeAttribute("disabled");
								document.getElementsByName("replacing")[0].removeAttribute("disabled");
							};
						</script>
						
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Vendor
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="vendor">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Procured From
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="procure">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Short name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="shortname">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Purpose
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="purpose">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contract Type 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control required" name="contracttype">
                            <option value="Software & Support">Software & Support</option>
                            <option value="Software">Software</option>
                            <option value="Support">Support</option>
                          </select>
                        </div>
                      </div>
					  <div class="item form-group">
					  <label class="control-label col-md 3 col-sm-3 col-xs-12">Start Date
					  </label>
					  <fieldset class="col-md-6 col-sm-6 col-xs-12">
                          <div class="control-group">
                            <div class="controls">
                              <div class="xdisplay_inputx form-group">
							  
                                <input type="text" class="form-control" name="startdate" id="single_cal4" placeholder="First Name" aria-describedby="inputSuccess2Status4">
                                
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                              </div>
                            </div>
                          </div>
                        </fieldset>
						</div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">License Explanation
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="license" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Verification Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="verification" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
						<div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						  <button class="btn btn-primary" type="reset">Reset</button>
						  <input type="hidden" name="software" value="type">
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                          <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Class</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="class" disabled="disabled">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="brand" disabled="disabled">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Audit Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="auditdate" disabled="disabled">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Component</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="component" disabled="disabled">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Label</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="label" class="form-control col-md-7 col-xs-12" disabled="disabled">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Serial</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="serial" class="form-control col-md-7 col-xs-12" disabled="disabled">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="location" class="form-control col-md-7 col-xs-12" disabled="disabled">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="status" class="form-control col-md-7 col-xs-12" disabled="disabled">
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Replacing</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="replacing" class="form-control col-md-7 col-xs-12" disabled="disabled">
                        </div>
                      </div>
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
	
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	</body>
</html>
