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
	include('config.php');
    $result = $user->getOptions();
	$options = $user->options;
	$optionheaders = [
		'Status',
		'Vendors (Software)',
		'Procured From (Software)',
		'Shortname (Software)',
		'Purpose (Software)',
		'Contract type (Software)',
		'Release Version',
		'Class (Hardware)',
		'Brand (Hardware)',
		'Location (Hardware)',
		'Servers to Monitor',
		'Currency'
	];
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		foreach($options as $option) {
			if (isset($_POST[$option])) {
				$user->addOption($option, $_POST[$option]);
			}
			else if (isset($_POST["{$option}delete"])) {
				$user->deleteOption($option, $_POST["{$option}delete"]);
			}
		}
        $result = $user->getOptions();
	}
	
?>  
  
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <?php include('sidebar.php')?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Asset Management Options </h3>
              </div>
            </div>
            <div class="clearfix"></div>
			<?php foreach ($options as $header=>$option) {
				echo '
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel" style="height: auto;">
                  <div class="x_title">
                    <h2>'.$optionheaders[$header].'</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="display: none;">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>
                        '; 
                        foreach($result[$option] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row[$option.'_name'].'</td>';
                        echo '<input type="hidden" name="'.$option.'delete" value="'.$row[$option.'_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        };
					echo '
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="'.$option.'"></td>
                        <td><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
			</div>';};
			 ?>     
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
