<?php 
	include_once('components/config.php');
	$DateError=0;
	$Success=0;
	$same = false;
	$result = $user->getGPCAsset($_GET['id']);
	if (!$result[0]) {
		header('Location: gpcassetlist.php');
	}
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
		
		$same = true;
		//Similarility Check
		foreach ($asset as $key=>$value) {
			if ($asset[$key] != $result[1][$key]) {
				$same = false;
				break;
			}
		}
		unset($key);
		
		if ($same) {
			// Do nothing, display error message below
		}
		
		else if (!($user->check_date($asset['gpc_Startdate']))) {
				$DateError = 1;
		}
		
		else if (!($user->check_date($asset['gpc_Expirydate']))) {
				$DateError = 1;
		}
		
		else {
			$asset['gpc_version'] = $result[1]['gpc_version'] + 1;
			$asset['gpc_asset_tag'] = $result[1]['gpc_asset_tag'];
			$user->editGPCAsset($asset);
			$Success = 1;
		}
		
	}


	include('components/sidebar.php');
?>  
  
<script>
	document.getElementById('gpcassetlist.php').setAttribute("class", "current-page");
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
			<h2>Edit Asset</h2>
			
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
		  <?php
		  if ($same) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> No Changes Made
		  </div>';}
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
				  <button class="btn btn-primary" type="button" onclick="discardChanges()">Discard Changes</button>
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
?>
<script>
function discardChanges() {
		console.log('reset');
		document.getElementById("demo-form2").reset();
		document.getElementsByName("gpc_Environment")[0].value 	= <?php echo json_encode($result[1]["gpc_Environment"]);?>;
		//document.getElementsByName("gpc_Tier")[0].value 		= <?php echo json_encode($result[1]["gpc_Tier"]);?>;
		document.getElementsByName("gpc_Phase")[0].value	 	= <?php echo json_encode($result[1]["gpc_Phase"]);?>;
		document.getElementsByName("gpc_Item")[0].value 		= <?php echo json_encode($result[1]["gpc_Item"]);?>;
		document.getElementsByName("gpc_Remarks")[0].value 		= <?php echo json_encode($result[1]["gpc_Remarks"]);?>;
		document.getElementsByName("gpc_Ami")[0].value 			= <?php echo json_encode($result[1]["gpc_Ami"]);?>;
		document.getElementsByName("gpc_Startdate")[0].value 	= <?php echo json_encode($result[1]["gpc_Startdate"]);?>;
		document.getElementsByName("gpc_Expirydate")[0].value 	= <?php echo json_encode($result[1]["gpc_Expirydate"]);?>;
		document.getElementsByName("gpc_halb")[0].value 		= <?php echo json_encode($result[1]["gpc_halb"]);?>;
		document.getElementsByName("gpc_quantity")[0].value 	= <?php echo json_encode($result[1]["gpc_quantity"]);?>;
		document.getElementsByName("gpc_Application")[0].value 	= <?php echo json_encode($result[1]["gpc_Application"]);?>;
		document.getElementsByName("gpc_Data")[0].value			= <?php echo json_encode($result[1]["gpc_Data"]);?>;
		document.getElementsByName("gpc_IOPS")[0].value 		= <?php echo json_encode($result[1]["gpc_IOPS"]);?>;
		document.getElementsByName("gpc_Backup")[0].value 		= <?php echo json_encode($result[1]["gpc_Backup"]);?>;
		document.getElementsByName("gpc_OS")[0].value 			= <?php echo json_encode($result[1]["gpc_OS"]);?>;
		document.getElementsByName("gpc_Y1_Qt")[0].value 		= <?php echo json_encode($result[1]["gpc_Y1_Qt"]);?>;
		document.getElementsByName("gpc_Y2_Qt")[0].value 		= <?php echo json_encode($result[1]["gpc_Y2_Qt"]);?>;
		document.getElementsByName("gpc_Y1_Ops")[0].value 		= <?php echo json_encode($result[1]["gpc_Y1_Ops"]);?>;
		document.getElementsByName("gpc_Y2_Ops")[0].value		= <?php echo json_encode($result[1]["gpc_Y2_Ops"]);?>;
		document.getElementsByName("gpc_Gwgc")[0].value			= <?php echo json_encode($result[1]["gpc_Gwgc"]);?>;
	}

document.getElementsByName("gpc_Environment")[0].children[0].value 	= <?php echo json_encode($result[1]["gpc_Environment"]);?>;
document.getElementsByName("gpc_Tier")[0].children[0].value 		= <?php echo json_encode($result[1]["gpc_Tier"]);?>;
document.getElementsByName("gpc_Phase")[0].children[0].value	 	= <?php echo json_encode($result[1]["gpc_Phase"]);?>;
document.getElementsByName("gpc_Item")[0].children[0].value 		= <?php echo json_encode($result[1]["gpc_Item"]);?>;
document.getElementsByName("gpc_Ami")[0].children[0].value 			= <?php echo json_encode($result[1]["gpc_Ami"]);?>;
document.getElementsByName("gpc_halb")[0].children[0].value 		= <?php echo json_encode($result[1]["gpc_halb"]);?>;
document.getElementsByName("gpc_OS")[0].children[0].value 			= <?php echo json_encode($result[1]["gpc_OS"]);?>;
document.getElementsByName("gpc_Y1_Ops")[0].children[0].value 		= <?php echo json_encode($result[1]["gpc_Y1_Ops"]);?>;
document.getElementsByName("gpc_Y2_Ops")[0].children[0].value		= <?php echo json_encode($result[1]["gpc_Y2_Ops"]);?>;
document.getElementsByName("gpc_Gwgc")[0].children[0].value			= <?php echo json_encode($result[1]["gpc_Gwgc"]);?>;

document.getElementsByName("gpc_Environment")[0].children[0].innerHTML 	= <?php echo json_encode($result[1]["gpc_Environment"].' (No Change) ');?>;
document.getElementsByName("gpc_Tier")[0].children[0].innerHTML 		= <?php echo json_encode($result[1]["gpc_Tier"].' (No Change) ');?>;
document.getElementsByName("gpc_Phase")[0].children[0].innerHTML	 	= <?php echo json_encode($result[1]["gpc_Phase"].' (No Change) ');?>;
document.getElementsByName("gpc_Item")[0].children[0].innerHTML 		= <?php echo json_encode($result[1]["gpc_Item"].' (No Change) ');?>;
document.getElementsByName("gpc_Ami")[0].children[0].innerHTML 			= <?php echo json_encode($result[1]["gpc_Ami"].' (No Change) ');?>;
document.getElementsByName("gpc_halb")[0].children[0].innerHTML 		= <?php echo json_encode($result[1]["gpc_halb"].' (No Change) ');?>;
document.getElementsByName("gpc_OS")[0].children[0].innerHTML 			= <?php echo json_encode($result[1]["gpc_OS"].' (No Change) ');?>;
document.getElementsByName("gpc_Y1_Ops")[0].children[0].innerHTML 		= <?php echo json_encode($result[1]["gpc_Y1_Ops"].' (No Change) ');?>;
document.getElementsByName("gpc_Y2_Ops")[0].children[0].innerHTML		= <?php echo json_encode($result[1]["gpc_Y2_Ops"].' (No Change) ');?>;
document.getElementsByName("gpc_Gwgc")[0].children[0].innerHTML			= <?php echo json_encode($result[1]["gpc_Gwgc"].' (No Change) ');?>;
discardChanges();
</script>
<?php
require 'components/closing.php';
?>