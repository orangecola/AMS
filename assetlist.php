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
	<?php include_once('config.php');?>
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <?php
			include('sidebar.php');
			
			$software = $user->getSoftwareList();
			$hardware = $user->getHardwareList();
			
			function printAssetRow($asset) {
				echo "<td>".htmlentities($asset['description'])			."</td>";
				echo "<td>".htmlentities($asset['quantity'])			."</td>";
				echo "<td>".htmlentities($asset['price'])			." ".htmlentities($asset['currency'])."</td>";
				echo "<td>".htmlentities($asset['crtrno'])				."</td>";
				echo "<td>".htmlentities($asset['purchaseorder_id'])	."</td>";
				echo "<td>".htmlentities($asset['release_version'])		."</td>";
				echo "<td>".htmlentities($asset['expirydate'])			."</td>";
				echo "<td>".htmlentities($asset['remarks'])				."</td>";
			}
			
			function printSoftwareRow($software) {
				echo '<tr>';
				echo "<td>".htmlentities($software['asset_ID'])."</td>";
				echo "<td>Software</td>";
				printAssetRow($software);
				echo "<td>";
				echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($software['asset_tag'])."view href="."#".htmlentities($software['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
				echo "<a href=\"editsoftware.php?id=".htmlentities($software['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a>";
				echo "</td>";
				echo '</tr>';
			}
			
			function printHardwareRow($hardware) {
				echo '<tr>';
				echo "<td>".htmlentities($hardware['asset_ID'])."</td>";
				echo "<td>Hardware</td>";
				printAssetRow($hardware);
				echo "<td>";
				echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($hardware['asset_tag'])."view href="."#".htmlentities($hardware['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
				echo "<a href=\"edithardware.php?id=".htmlentities($hardware['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a>";
				echo "</td>";
				echo '</tr>';
			}
		?>
		<script>
			document.getElementById('assetlist.php').setAttribute("class", "current-page");
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
                    <h2>Assets list</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

					
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Asset ID</th>
						  <th>Type</th>
						  <th>Description</th>
						  <th>Quantity</th>
						  <th>Price</th>
                          <th>CR / TR Number</th>
                          <th>PO Number</th>
						  <th>Release version</th>
                          <th>Expiry Date</th>
						  <th>Remarks</th>
						  <th>Actions</th>
                        </tr>
                      </thead>


                      <tbody>
						<?php 
							foreach($hardware as $row) {
								printHardwareRow($row);
								$user->printHardwareModal($row);
							}
							
							foreach($software as $row) {
								printSoftwareRow($row);
								$user->printSoftwareModal($row);
							}
						?>
                      </tbody>
                    </table>
                  </div>
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
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="vendors/starrr/dist/starrr.js"></script>
	<!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
	
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	
	
	
  </body>
</html>
