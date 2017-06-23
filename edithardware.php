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
	$NoChanges=0;
	$DateError=0;
	$NumberError = 0;
	$Success=0;
	$ParentError = 0;
	$distinct = $user->getDistinct();
	
	foreach($distinct[3] as &$value) {
		$value = $value[0];
	}
	if(!(isset($_GET['id']))) {
			header('Location: assetlist.php');
	}
	
	$result = $user->getHardware($_GET['id']);
	
	if (!$result[0]) {
		header('Location: assetlist.php');
	}
	
	$options = $user->getOptions();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$candidate['asset_ID'] 			= trim($_POST['assetid']);
		$candidate['description']		= trim($_POST['description']);
		$candidate['quantity']			= trim($_POST['quantity']);
		$candidate['price']				= trim($_POST['price']);
		$candidate['currency']			= trim($_POST['currency']);
		$candidate['crtrno']			= trim($_POST['crtrno']);
		$candidate['purchaseorder_id']	= trim($_POST['pono']);
		$candidate['release_version']	= trim($_POST['release']);
		$candidate['expirydate']		= trim($_POST['expirydate']);
		$candidate['remarks']			= trim($_POST['remarks']);
		$candidate['parent']			= trim($_POST['parent']);
		
		$candidate['class']				= trim($_POST['class']);
		$candidate['brand']				= trim($_POST['brand']);
		$candidate['audit_date']		= trim($_POST['auditdate']);
		$candidate['component']			= trim($_POST['component']);
		$candidate['label']				= trim($_POST['label']);
		$candidate['serial']			= trim($_POST['serial']);
		$candidate['location']			= trim($_POST['location']);
		$candidate['status']			= trim($_POST['status']);
		$candidate['replacing']			= trim($_POST['replacing']);
		
		$same = true;
		//Similarility Check
		foreach ($user->assetFields as $value) {
			if ($candidate[$value] != $result[1][$value]) {
				$same = false;
				break;
			}
		}
		unset($value);
		
		foreach ($user->hardwareFields as $value) {
			
			if ($candidate[$value] != $result[1][$value]) {
				$same = false;
				break;
			}
		}
		unset($value);
		
		if ($same) {
			$NoChanges = 1;
		}
		
		//Check price if it is integer / double
		//Check quantity if it is an integer
		if (!(($user->validatesAsInt($candidate['price']) or $user->validatesAsDouble($candidate['price'])) and $user->validatesAsInt($candidate['quantity']))) {
			$NumberError = 1;
		}
		
		//Check Dates
		if (!($user->check_date($candidate['expirydate']))) {
				$DateError = 1;
		}
		
		if (!(in_array($candidate['parent'], $distinct[3])) and $candidate['parent'] != "") {
				$ParentError = 1;
		}
		
		if (!(in_array($candidate['replacing'], $distinct[3])) and $candidate['replacing'] != "") {
				$ParentError = 1;
		}
		
		if (!$same and $DateError == 0 and $NumberError == 0 and $ParentError == 0) {
			$candidate['version'] = $result[1]['version'] + 1;
			$candidate['asset_tag'] = $result[1]['asset_tag'];
			$user->editHardware($candidate);
			$result = $user->getHardware($_GET['id']);
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
			document.getElementById('assetlist.php').setAttribute("class", "current-page");
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
                    <h2>Edit Hardware Asset <?php echo $result[1]['asset_ID'];?><small>Last Edited: <?php echo $result[1]['lastedited']?></small></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  <?php
				  if ($NoChanges == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> No changes made
                  </div>';} 
				  
				  if ($DateError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> Date Error
                  </div>';}
				  
				  if ($NumberError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> Number Error. Please check quantity and price
                  </div>';}
				  
				  if ($Success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Success</strong> Hardware edits successful
                  </div>';}
				  
				  if ($ParentError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> Parent Asset ID Does not exist
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
                          <textarea class="form-control col-md-7 col-xs-12" name="description"></textarea>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Currency</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control required" name="currency">
                            <?php 
							echo '<option class="nochange" value="'.htmlentities($result[1]['currency']).'">'.htmlentities($result[1]['currency']).' (No Change)</option>';
							?>
                            <?php 
                                foreach($options['currency'] as $row) {
                                    echo '<option value="'.$row['currency_name'].'">'.$row['currency_name'].'</option>';
                                }
                            ?>
                          </select>
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
                          <select class="form-control required" name="release">
                            <?php 
							echo '<option class="nochange" value="'.htmlentities($result[1]['release_version']).'">'.htmlentities($result[1]['release_version']).' (No Change)</option>';
							?>
                            <?php 
                                foreach($options['releaseversion'] as $row) {
                                    echo '<option value="'.$row['releaseversion_name'].'">'.$row['releaseversion_name'].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                      </div>
					<div class="item form-group">
					  <label class="control-label col-md 3 col-sm-3 col-xs-12">Warranty Expiry Date (MM/DD/YYYY)
					  </label>
					  <fieldset class="col-md-6 col-sm-6 col-xs-12">
                          <div class="control-group">
                            <div class="controls">
                              <div class="xdisplay_inputx form-group">
							  
                                <input type="text" class="form-control " id="single_cal3" name="expirydate" aria-describedby="inputSuccess2Status4">
                                
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                              </div>
                            </div>
                          </div>
                        </fieldset>
					</div>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent Asset
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="parent" id="parent" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control required" name="status">
                            <?php 
							echo '<option class="nochange" value="'.htmlentities($result[1]['status']).'">'.htmlentities($result[1]['status']).' (No Change)</option>';
							?>
                            <?php 
                                foreach($options['status'] as $row) {
                                    echo '<option value="'.$row['status_name'].'">'.$row['status_name'].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Remarks</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12"  name="remarks"></textarea>
                        </div>
					</div>
				    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Class</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control required" name="class">
                            <?php 
							echo '<option class="nochange" value="'.htmlentities($result[1]['class']).'">'.htmlentities($result[1]['class']).' (No Change)</option>';
							?>
                            <?php 
                                foreach($options['class'] as $row) {
                                    echo '<option value="'.$row['class_name'].'">'.$row['class_name'].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                    </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control required" name="brand">
                            <?php 
							echo '<option class="nochange" value="'.htmlentities($result[1]['brand']).'">'.htmlentities($result[1]['brand']).' (No Change)</option>';
							?>
                            <?php 
                                foreach($options['brand'] as $row) {
                                    echo '<option value="'.$row['brand_name'].'">'.$row['brand_name'].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Audit Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="auditdate" >
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Component</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="component" >
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Label</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="label" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Serial</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="serial" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control required" name="location">
                            <?php 
							echo '<option class="nochange" value="'.htmlentities($result[1]['location']).'">'.htmlentities($result[1]['location']).' (No Change)</option>';
							?>
                            <?php 
                                foreach($options['location'] as $row) {
                                    echo '<option value="'.$row['location_name'].'">'.$row['location_name'].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">RMA</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="replacing" id="replacing" class="form-control col-md-7 col-xs-12" >
                        </div>
                      </div>
						<div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						  <a class="btn btn-primary" href="assetlist.php">Cancel</a>
						  <button class="btn btn-primary" type="button" onclick="resetFields()">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
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
	<script>
			function resetFields() {
				document.getElementById("demo-form2").reset();
				document.getElementsByName("assetid")[0].value = <?php echo json_encode($result[1]['asset_ID']);?>;
				document.getElementsByName("description")[0].innerHTML = <?php echo json_encode($result[1]['description']);?>;
				document.getElementsByName("quantity")[0].value = <?php echo json_encode($result[1]['quantity']);?>;
				document.getElementsByName("price")[0].value = <?php echo json_encode($result[1]['price']);?>;
				document.getElementsByName("crtrno")[0].value = <?php echo json_encode($result[1]['crtrno']);?>;
				document.getElementsByName("pono")[0].value = <?php echo json_encode($result[1]['purchaseorder_id']);?>;
				document.getElementsByName("expirydate")[0].value = <?php echo json_encode($result[1]['expirydate']);?>;
				document.getElementsByName("remarks")[0].innerHTML = <?php echo json_encode($result[1]['remarks']);?>;
				document.getElementsByName("parent")[0].value = <?php echo json_encode($result[1]['parent']);?>;
				
				document.getElementsByName("auditdate")[0].value = <?php echo json_encode($result[1]['audit_date']);?>;
				document.getElementsByName("component")[0].value = <?php echo json_encode($result[1]['component']);?>;
				document.getElementsByName("label")[0].value = <?php echo json_encode($result[1]['label']);?>;
				document.getElementsByName("serial")[0].value = <?php echo json_encode($result[1]['serial']);?>;
				document.getElementsByName("location")[0].value = <?php echo json_encode($result[1]['location']);?>;
				document.getElementsByName("replacing")[0].value = <?php echo json_encode($result[1]['replacing']);?>;
			}
			resetFields();
		</script>    
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
