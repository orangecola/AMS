<?php 
	include_once('components/config.php');
	$DateError=0;
	$Success=0;
	$ParentError=0;
	$options = $user->getOptions();
	$distinct = $user->getDistinct();
	
	foreach($distinct[3] as &$value) {
		$value = $value[0];
	}
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$renewal['asset_ID']					= $_POST['assetid'];
		$renewal['parent_ID']					= $_POST['parent'];
		$renewal['purchaseorder_id']			= $_POST['pono'];			
		$renewal['startdate']					= $_POST['startdate'];
		$renewal['expiry_date']					= $_POST['expiry_date'];
		
		if ($renewal['asset_ID'] == "") {
			$renewal['asset_ID'] = $renewal['parent_ID'];
		}
		
		if (!($user->check_date($renewal['expiry_date']) and $user->check_date($renewal['startdate']))) {
				$DateError = 1;
		}
		
		if (!(in_array($renewal['parent_ID'], $distinct[3]))) {
				$ParentError = 1;
		}
		
		if ($DateError == 0 and $ParentError == 0) {
			$user->addRenewal($renewal);
			$Success = 1;
		}
	}



?>  
 
<?php
	include('components/sidebar.php');
?>
<script>
	document.getElementById('addrenewal.php').setAttribute("class", "current-page");
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
			<h2>Add Renewal</h2>
			
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
		  <?php				  
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
			<strong>Success</strong> Renewal created successfully
		  </div>';}
		  
		  ?>
			<br />
			<form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
			  <?php require 'components/renewal.php'; ?>

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
<?php require 'components/footer.php' ?>
		<script>
	$('#parent').autocomplete({
		lookup: asset_ID,
		onSelect: function () {

    }
	});
	</script>
        
<?php require 'components/closing.php'?>	
