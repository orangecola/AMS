<?php 
	include_once('components/config.php');
	$DateError=0;
	$Success=0;
	$options = $user->getOptions('gpc_Options', ['gpc_Gwgc', 'gpc_Environment', 'gpc_Tier', 'gpc_Item', 'gpc_Ami', 'gpc_halb', 'gpc_OS', 'gpc_Ops', 'gpc_Phase']);
		
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$asset['gpc_Environment'] 		= $_POST['gpc_Environment'];
		$asset['gpc_Tier']				= $_POST['gpc_Tier'];
		$asset['gpc_Phase']				= $_POST['gpc_Phase'];
		$asset['gpc_Item']				= $_POST['gpc_Item'];
		$asset['gpc_Remarks']			= $_POST['gpc_Remarks'];
		$asset['gpc_Ami']				= $_POST['gpc_Ami'];
		$asset['gpc_Startdate']			= $_POST['gpc_Startdate'];
		$asset['gpc_Expirydate']		= $_POST['gpc_Expirydate'];
		$asset['gpc_halb']				= $_POST['gpc_halb'];
		$asset['gpc_quantity']			= $_POST['gpc_quantity'];
		$asset['gpc_Application']		= $_POST['gpc_Application'];
		$asset['gpc_Data']				= $_POST['gpc_Data'];
		$asset['gpc_IOPS']				= $_POST['gpc_IOPS'];
		$asset['gpc_Backup']			= $_POST['gpc_Backup'];
		$asset['gpc_OS']				= $_POST['gpc_OS'];
		$asset['gpc_Y1_Qt']				= $_POST['gpc_Y1_Qt'];
		$asset['gpc_Y2_Qt']				= $_POST['gpc_Y2_Qt'];
		$asset['gpc_Y1_Ops']			= $_POST['gpc_Y1_Ops'];
		$asset['gpc_Y2_Ops']			= $_POST['gpc_Y2_Ops'];
		$asset['gpc_Gwgc']				= $_POST['gpc_Gwgc'];
		
		if (!($user->check_date($asset['gpc_Startdate']))) {
				$DateError = 1;
		}
		
		else if (!($user->check_date($asset['gpc_Expirydate']))) {
				$DateError = 1;
		}
		
		else {
			$user->addGPCAsset($asset);
			$Success = 1;
		}
		
	}


	include('components/sidebar.php');
?>  
  
<script>
	document.getElementById('addgpc_asset.php').setAttribute("class", "current-page");
	document.getElementsByTagName("BODY")[0].setAttribute("class", "nav-md");
	console.log(<?php echo json_encode($options)?>);
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
			  <?php require 'components/gpc_asset.php'; ?>

			<div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <button class="btn btn-primary" type="reset">Cancel</button>
				  <button type="submit" class="btn btn-success">Submit</button>
				</div>
			  </div>
			</div>
			<!-- /tabs -->
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