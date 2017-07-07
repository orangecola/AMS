<?php 
	include('components/config.php');
	$wrongPassword = 0;
	$Success = 0;
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tmpName = $_FILES['csv']['tmp_name'];
        
        $csv = array_map('str_getcsv', file($tmpName));

        //Array Manipulation here.
        foreach($csv as &$Row) {
            $Row = str_getcsv($Row[0], ";");
        }
        
        $user->addBulkUsers($csv);
        $Success=1;
	}

	include('components/sidebar.php')
?>  
  
<script>
	document.getElementById('bulkaddrenewal.php').setAttribute("class", "current-page");
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
			<h2>Bulk Add Renewals</h2>
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
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Excel File to import
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="file" class="form-control col-md-7 col-xs-12"  name="csv">
				</div>
			  </div>
			  <div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a class="btn btn-default" href="downloadtemplate.php?type=renewal"><i class="fa fa-download"></i> Download Template</a></a>
				  <button type="submit" class="btn btn-success">Submit</button>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>
<!-- /page content -->

<?php 
	require 'components/footer.php';
	require 'components/closing.php';
?>
