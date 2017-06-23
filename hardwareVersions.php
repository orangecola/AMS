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
	$noversion = 0;
	$current = 0;
	$success = 0;
	
	if(!(isset($_GET['id']))) {
			header('Location: adminassetlist.php');
	}
	
	$result = $user->getHardwareVersions($_GET['id']);
	
	if (!$result[0]) {
		header('Location: adminassetlist.php');
	}

	$currentversion = $user->getCurrentVersion($_GET['id'])['current_version'];

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$versioncheck = false;
		foreach($result[1] as $row) {
			if($row['version'] == $_POST['version']) {
				$versioncheck = true;
				break;
			}
		}
		
		if (!$versioncheck) {
			$noversion = 1;
		}

		
		else if ($_POST['version'] == $currentversion) {
			$current = 1;
		}
		
		else {
			/*
			foreach($result[1] as $row) {
				if ($row['version'] == $_POST['version']) {
					$row['version'] = $currentversion + 1;
					$user->editHardware($row);
					break;
				}
			}
			$result = $user->getHardwareVersions($_GET['id']);
			$success = 1;
			*/
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
            var versions = new Array();
            
            <?php 
                foreach ($result[1] as $row) {
                    echo "versions[{$row['version']}] = ".json_encode($row).";";
                }
            ?>
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
                    <h2>Hardware Asset Versions of Asset Tag <?php echo $_GET['id'];?></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  <?php
				  if ($noversion == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> Version not found
                  </div>';} 
				  
				  if ($current == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Error</strong> Version is already the current version
                  </div>';}
				  
				  if ($success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Success</strong> Asset reverted successfully
                  </div>';}
				  
				  ?>
                    <br />
                    <form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Version</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="version" onchange="populate()">
                            <option>Select version</option>
                            <?php 
                                foreach($result[1] as $row) {
                                    echo "<option value={$row['version']}>{$row['version']}</option>";
                                }
                            ?>
                          </select>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Asset ID
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  class="form-control col-md-7 col-xs-12"  name="assetid" disabled>
                        </div>
                      </div>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Description
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" rows="5"  name="description" disabled></textarea>
                        </div>
                      </div>					  
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Quantity
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="quantity" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Price
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="price" disabled>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Change Request / Tech Refresh Number
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="crtrno" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order ID
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="pono" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Release version
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="release" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
					  <label class="control-label col-md 3 col-sm-3 col-xs-12">Expiry Date
					  </label>
					  <fieldset class="col-md-6 col-sm-6 col-xs-12">
                          <div class="control-group">
                            <div class="controls">
                              <div class="xdisplay_inputx form-group">
							  
                                <input type="text" class="form-control " id="single_cal3" name="expirydate" aria-describedby="inputSuccess2Status4" disabled>
                                
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
                          <input type="text" name="parent" id="parent" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                    </div>
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor disabled">Remarks
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12"  name="remarks" disabled></textarea>
                        </div>
                      </div>
					  <div class="x_content">
                          <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Class</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="class" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="brand" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Audit Date</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="auditdate" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Component</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12"  name="component" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Label</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="label" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Serial</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="serial" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="location" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="status" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                      </div>
					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Replacing</label>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="replacing" class="form-control col-md-7 col-xs-12" disabled>
                        </div>
                      </div>
						<div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						  <a class="btn btn-primary" href="adminassetlist.php">Cancel</a>
						  <!--<button type="submit" class="btn btn-danger">Revert</button>-->
                        </div>
                      </div>
                        
                    </div>
                  </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

        <script>
			function populate() {
                p1 = document.getElementsByName("version")[0].value;
				document.getElementsByName("assetid")[0].value = versions[p1]["asset_ID"];
				document.getElementsByName("description")[0].innerHTML = versions[p1]["description"];
				document.getElementsByName("quantity")[0].value = versions[p1]["quantity"];
				document.getElementsByName("price")[0].value = versions[p1]["price"];
				document.getElementsByName("crtrno")[0].value = versions[p1]["crtrno"];
				document.getElementsByName("pono")[0].value = versions[p1]["purchaseorder_id"];
				document.getElementsByName("release")[0].value = versions[p1]["release_version"];
				document.getElementsByName("expirydate")[0].value = versions[p1]["expirydate"];
				document.getElementsByName("parent")[0].value= versions[p1]["parent"];
				document.getElementsByName("remarks")[0].innerHTML = versions[p1]["remarks"];
				
				document.getElementsByName("class")[0].value = versions[p1]["class"];
				document.getElementsByName("brand")[0].value = versions[p1]["brand"];
				document.getElementsByName("auditdate")[0].value = versions[p1]["audit_date"];
				document.getElementsByName("component")[0].value = versions[p1]["component"];
				document.getElementsByName("label")[0].value = versions[p1]["label"];
				document.getElementsByName("serial")[0].value = versions[p1]["serial"];
				document.getElementsByName("location")[0].value = versions[p1]["location"];
				document.getElementsByName("status")[0].value = versions[p1]["status"];
				document.getElementsByName("replacing")[0].value = versions[p1]["replacing"];
			}
		</script>    
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
