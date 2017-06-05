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
	
	$result = $user->getDistinct();
	
	foreach($result as &$entry) {
		foreach($entry as &$value) {
			$value = $value[0];
		}
	}
?>  
  
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <?php include('sidebar.php')?>
		<script>
			document.getElementById('generatereport.php').setAttribute("class", "current-page");
			var purchaseorderid = <?php echo json_encode($result[0]); ?>;
		</script>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Reports</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
				

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Generate Report</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="report.php">

					  <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order ID
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12 awesomeplete"  id="purchaseorderid" name="purchaseorderid">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Release version</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" id="release">
                            <option value="">Choose option</option>
							<?php
								foreach($result[1] as $var) {
									echo "<option value=\"".$var."\">".$var."</option>";
								}
							?>
                          </select>
                        </div>
					  </div>
					  <div class="item form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Change Request / Tech Refresh No.</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" id="crtrno">
                            <option value="">Choose option</option>
                            <?php
								foreach($result[2] as $var) {
									echo "<option value=\"".$var."\">".$var."</option>";
								}
							?>
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
	<!-- jQuery autocomplete -->
    <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	<script>
	$('#purchaseorderid').autocomplete({
		lookup: purchaseorderid,
		onSelect: function () {
        $('#purchaseorderid').trigger('keyup');
    }
	});
	$("#purchaseorderid").keyup(function () {
		$('#crtrno').val("");
		$('#release').val("");
		$('#purchaseorderid').attr('name', 'purchaseorderid');
		$('#release').removeAttr('name');
		$('#crtrno').removeAttr('name');
    });
	$("#release").change(function () {
		$('#crtrno').val("");
		$('#purchaseorderid').val('');
        $('#release').attr('name', 'release');
		$('#purchaseorderid').removeAttr('name');
		$('#crtrno').removeAttr('name');
    });
	$("#crtrno").change(function () {
		$('#release').val("");
		$('#purchaseorderid').val('');
        $('#crtrno').attr('name', 'crtrno');
		$('#purchaseorderid').removeAttr('name');
		$('#release').val("");
		$('#release').removeAttr('name');
    });
	</script>
  </body>
</html>
