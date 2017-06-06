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
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['vendor'])) {
            $user->addOption('vendor', $_POST['vendor']);
        }
        else if (isset($_POST['vendordelete'])) {
            $user->deleteOption('vendor', $_POST['vendordelete']);
        }
        else if (isset($_POST['procured_from'])) {
            $user->addOption('procured_from', $_POST['procured_from']);
        }
        else if (isset($_POST['procured_fromdelete'])) {
            $user->deleteOption('procured_from', $_POST['procured_fromdelete']);
        }
        else if (isset($_POST['shortname'])) {
            $user->addOption('shortname', $_POST['shortname']);
        }
        else if (isset($_POST['shortnamedelete'])) {
            $user->deleteOption('shortname', $_POST['shortnamedelete']);
        }
        else if (isset($_POST['purpose'])) {
            $user->addOption('purpose', $_POST['purpose']);
        }
        else if (isset($_POST['purposedelete'])) {
            $user->deleteOption('purpose', $_POST['purposedelete']);
        }
        else if (isset($_POST['contracttype'])) {
            $user->addOption('contracttype', $_POST['contracttype']);
        }
        else if (isset($_POST['contracttypedelete'])) {
            $user->deleteOption('contracttype', $_POST['contracttypedelete']);
        }
        else if (isset($_POST['class'])) {
            $user->addOption('class', $_POST['class']);
        }
        else if (isset($_POST['classdelete'])) {
            $user->deleteOption('class', $_POST['classdelete']);
        }
        else if (isset($_POST['brand'])) {
            $user->addOption('brand', $_POST['brand']);
        }
        else if (isset($_POST['branddelete'])) {
            $user->deleteOption('brand', $_POST['branddelete']);
        }
        else if (isset($_POST['server'])) {
            $user->addOption('server', $_POST['server']);
        }
        else if (isset($_POST['serverdelete'])) {
            $user->deleteOption('server', $_POST['serverdelete']);
        }
        $result = $user->getOptions();
	}
	
?>  
  
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <?php include('sidebar.php')?>
        <script>console.log(<?php json_encode($result)?>);</script>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Asset Management Options </h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
				

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Vendor (Software)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>

                        <?php 
                        foreach($result['vendor'] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row['vendor_name'].'</td>';
                        echo '<input type="hidden" name="vendordelete" value="'.$row['vendor_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        ?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="vendor"></td>
                        <td><button type="submit" class="btn btn-success btn-xs">Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Procured From (Software)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>

                        <?php 
                        foreach($result['procured_from'] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row['procured_from_name'].'</td>';
                        echo '<input type="hidden" name="procured_fromdelete" value="'.$row['procured_from_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        ?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="procured_from"></td>
                        <td><button type="submit" class="btn btn-success btn-xs">Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Shortname (Software)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>

                        <?php 
                        foreach($result['shortname'] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row['shortname_name'].'</td>';
                        echo '<input type="hidden" name="shortnamedelete" value="'.$row['shortname_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        ?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="shortname"></td>
                        <td><button type="submit" class="btn btn-success btn-xs">Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              </div>
              <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Purpose (Software)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>

                        <?php 
                        foreach($result['purpose'] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row['purpose_name'].'</td>';
                        echo '<input type="hidden" name="purposedelete" value="'.$row['purpose_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        ?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="purpose"></td>
                        <td><button type="submit" class="btn btn-success btn-xs">Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Contract type (Software)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>

                        <?php 
                        foreach($result['contracttype'] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row['contracttype_name'].'</td>';
                        echo '<input type="hidden" name="contracttypedelete" value="'.$row['contracttype_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        ?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="contracttype"></td>
                        <td><button type="submit" class="btn btn-success btn-xs">Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Class (Hardware)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>

                        <?php 
                        foreach($result['class'] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row['class_name'].'</td>';
                        echo '<input type="hidden" name="classdelete" value="'.$row['class_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        ?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="class"></td>
                        <td><button type="submit" class="btn btn-success btn-xs">Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Brand (Hardware)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>

                        <?php 
                        foreach($result['brand'] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row['brand_name'].'</td>';
                        echo '<input type="hidden" name="branddelete" value="'.$row['brand_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        ?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="brand"></td>
                        <td><button type="submit" class="btn btn-success btn-xs">Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Servers to Monitor</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                          <th>Field</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                    
                    <tbody>

                        <?php 
                        foreach($result['server'] as $row) {
                        echo '<tr>';
                        echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
                        echo '<td>'.$row['server_name'].'</td>';
                        echo '<input type="hidden" name="serverdelete" value="'.$row['server_id'].'">';
                        echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i>Delete</button></td>';
                        echo '</form>';
                        echo '</tr>';
                        }
                        ?>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
                        <td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="server"></td>
                        <td><button type="submit" class="btn btn-success btn-xs">Add</button></td>
                    </form>
                    </tr>
                    </tbody>
                    </table>
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

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	
  </body>
</html>
