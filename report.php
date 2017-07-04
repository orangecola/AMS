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
	<!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

  </head>

<?php 
	include('config.php');
	$total = 0;
	$header = "";
	
	if(isset($_POST['purchaseorderid'])) {
		$header = "Purchase Order ". $_POST['purchaseorderid'];
		$result = $user->generateReport('purchaseorder_id', $_POST['purchaseorderid']);
		$purchaseorder = $user->getPurchaseOrder($_POST['purchaseorderid']);
	}
	else if(isset($_POST['release'])) {
		$header = 'Release ' . $_POST['release'];
		$result = $user->generateReport('release_version', $_POST['release']);
	}
	else if (isset($_POST['crtrno'])) {
		
		$header = 'CR / TR No ' . $_POST['crtrno'];
		$result = $user->generateReport('crtrno', $_POST['crtrno']);
	}
	else {
		header('Location: generatereport.php');
	}
	
	date_default_timezone_set('Asia/Singapore');
	$time = date("Y-m-d H:i:s");
	
?>  
  
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <?php include('sidebar.php')?>
		<script>
			document.getElementById('generatereport.php').setAttribute("class", "current-page");
			var purchaseorderid = <?php echo json_encode($result[0]); ?>;
			console.log(<?php echo json_encode($purchaseorder);?>);
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
                  <div class="x_content">

                    <section class="content invoice">
                      <!-- title row -->
                      <div class="row">
                        <div class="col-xs-12 invoice-header">
                          <h1>
                                          <i class="fa fa-globe"></i> <?php echo $header; ?>
                                          <small class="pull-right">Time Generated: <?php echo $time; ?></small>
                                      </h1>
                        </div>
                        <!-- /.col -->
                      </div>


                      <!-- Table row -->
                      <div class="row">
                        <div class="col-xs-12 table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Qty</th>
								<th>Asset ID</th>
                                <th style="width: 59%">Description</th>
								<th>Expiry Date</th>
                                <th>Price</th>
                              </tr>
                            </thead>
                            <tbody>
							<?php 
								foreach($result as $row) {
									echo '<tr>';
									echo "<td>".htmlentities($row['quantity'])		."</td>";
									echo "<td>".htmlentities($row['asset_ID'])		."</td>";
									echo "<td>".htmlentities($row['description'])	."</td>";
									echo "<td>".htmlentities($row['expirydate'])	."</td>";
									echo "<td>$".htmlentities($row['price'])		."</td>";
									echo '</tr>';
									$total += $row['price'];
								}
							?>

                            </tbody>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
						<div class="row">
                        
                        <div class="col-xs-6">
                          
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                          <p class="lead pull-right">Calculated Total $<?php echo $total;?>
						  <?php if(isset($_POST['purchaseorderid']) and $purchaseorder['exists']) {
							echo "<br />Discount \${$purchaseorder['purchaseorder']['discount']}";
							echo "<br />Saved Total \${$purchaseorder['purchaseorder']['total']}";
						}?>
						</p>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                      <!-- this row will not appear when printing -->
                      <div class="row no-print">
                        <div class="col-xs-12">
                          <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
						  <a class="btn btn-default" href="downloadreport.php?<?php
							if(isset($_POST['purchaseorderid'])) {
								echo 'purchaseorderid='.$_POST['purchaseorderid'];
							}
							else if(isset($_POST['release'])) {
								echo 'release='.$_POST['release'];
							}
							else if (isset($_POST['crtrno'])) {
								echo 'crtrno='. $_POST['crtrno'];
							};
						  ?>"><i class="fa fa-save"></i> Download Report</a>
                        </div>
                      </div>
                    </section>
                  </div>
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
  </body>
</html>
