<?php 
	include_once('components/config.php');
	$NoChanges=0;
	$DateError=0;
	$NumberError = 0;
	$Success=0;
	
	$distinct = $user->getDistinct();
	$options = $user->getOptions('nehr_Options', ['currency', 'releaseversion', 'status', 'vendor', 'procured_from', 'shortname', 'purpose', 'contracttype']);
	
	foreach($distinct[3] as &$value) {
		$value = $value[0];
	}
	if(!(isset($_GET['id']))) {
			header('Location: softwarelist.php');
	}
	
	$result = $user->getSoftware($_GET['id']);
	
	if (!$result[0]) {
		header('Location: softwarelist.php');
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$candidate['asset_ID'] 				= trim($_POST['assetid']);
		$candidate['description']			= trim($_POST['description']);
		$candidate['quantity']				= trim($_POST['quantity']);
		$candidate['crtrno']				= trim($_POST['crtrno']);
		$candidate['purchaseorder_id']		= trim($_POST['pono']);
		$candidate['release_version']		= trim($_POST['release']);
		$candidate['expirydate']			= trim($_POST['expirydate']);
		$candidate['remarks']				= trim($_POST['remarks']);
		$candidate['status']				= trim($_POST['status']);
		
		$candidate['vendor']				= trim($_POST['vendor']);
		$candidate['procured_from']			= trim($_POST['procure']);
		$candidate['shortname']				= trim($_POST['shortname']);
		$candidate['purpose']				= trim($_POST['purpose']);
		$candidate['contract_type']			= trim($_POST['contracttype']);
		$candidate['start_date']			= trim($_POST['startdate']);
		$candidate['license_explanation']	= trim($_POST['license']);
		
		$same = true;
		//Similarility Check
		foreach ($user->assetFields as $value) {
			if ($candidate[$value] != $result[1][$value]) {
				$same = false;
				break;
			}
		}
		unset($value);
		
		foreach ($user->softwareFields as $value) {
			
			if ($candidate[$value] != $result[1][$value]) {
				$same = false;
				break;
			}
		}
		unset($value);
		
		if ($same) {
			$NoChanges = 1;
		}
		
		//Check price if it is integer / double
		//Check quantity if it is an integer
		if (!($user->validatesAsInt($candidate['quantity']))) {
			$NumberError = 1;
		}
		
		//Check Dates
		if (!($user->check_date($candidate['expirydate']) and $user->check_date($candidate['start_date']))) {
				$DateError = 1;
		}
		
		if ($NoChanges == 0 and $DateError == 0 and $NumberError == 0) {
			$candidate['version'] = $result[1]['version'] + 1;
			$candidate['asset_tag'] = $result[1]['asset_tag'];
			$user->editSoftware($candidate);
			$result = $user->getSoftware($_GET['id']);
			$Success = 1;
		}
		
	}

	include 'components/sidebar.php';
?>  
  
<script>
	document.getElementById('softwarelist.php').setAttribute("class", "current-page");
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
			<h2>Edit Software Asset <?php echo $result[1]['asset_ID'];?><small>Last Edited: <?php echo $result[1]['lastedited']?></small></h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
		  <?php
		  if ($NoChanges == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> No changes made
		  </div>';} 
		  
		  if ($DateError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> Date Error
		  </div>';}
		  
		  if ($NumberError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> Number Error. Please check quantity and price
		  </div>';}
		  
		  if ($Success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Success</strong> Software edits successful
		  </div>';}
		  ?>
			<br />
			<form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
			  <?php
				require 'components/asset.php';
				require 'components/software.php';
			  ?>
				<div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a class="btn btn-primary" href="softwarelist.php">Cancel</a>
				  <button type="button" class="btn btn-primary" onclick="resetFields()">Discard Changes</button>
				  <button type="submit" class="btn btn-success">Submit</button>
				</div>
				
			</div>
		  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>
  </div>	
<!-- /page content -->

<?php require ('components/footer.php');?>
<script>
		function resetFields() {
			document.getElementById("demo-form2").reset();
			document.getElementsByName("assetid")[0].value = <?php echo json_encode($result[1]['asset_ID']);?>;
			document.getElementsByName("description")[0].innerHTML = <?php echo json_encode($result[1]['description']);?>;
			document.getElementsByName("quantity")[0].value = <?php echo json_encode($result[1]['quantity']);?>;
			document.getElementsByName("crtrno")[0].value = <?php echo json_encode($result[1]['crtrno']);?>;
			document.getElementsByName("pono")[0].value = <?php echo json_encode($result[1]['purchaseorder_id']);?>;
			document.getElementsByName("expirydate")[0].value = <?php echo json_encode($result[1]['expirydate']);?>;
			document.getElementsByName("remarks")[0].innerHTML = <?php echo json_encode($result[1]['remarks']);?>;
			document.getElementsByName("startdate")[0].value = <?php echo json_encode($result[1]['start_date']);?>;
			document.getElementsByName("status")[0].value = <?php echo json_encode($result[1]['status']);?>;
			document.getElementsByName("license")[0].value = <?php echo json_encode($result[1]['license_explanation']);?>;
		}
		resetFields();

		//Change "Select Option" To Saved Fields
		document.getElementsByName("release")[0].children[0].innerHTML 		= <?php echo json_encode($result[1]['release_version'].' (No Change)');?>;
		document.getElementsByName("release")[0].children[0].value 			= <?php echo json_encode($result[1]['release_version']);?>;
		document.getElementsByName("vendor")[0].children[0].innerHTML		= <?php echo json_encode($result[1]['vendor'].' (No Change)');?>;
		document.getElementsByName("vendor")[0].children[0].value			= <?php echo json_encode($result[1]['vendor']);?>;
		document.getElementsByName("procure")[0].children[0].innerHTML		= <?php echo json_encode($result[1]['procured_from'].' (No Change)');?>;
		document.getElementsByName("procure")[0].children[0].value			= <?php echo json_encode($result[1]['procured_from']);?>;
		document.getElementsByName("shortname")[0].children[0].innerHTML	= <?php echo json_encode($result[1]['shortname'].' (No Change)');?>;
		document.getElementsByName("shortname")[0].children[0].value		= <?php echo json_encode($result[1]['shortname']);?>;
		document.getElementsByName("purpose")[0].children[0].innerHTML		= <?php echo json_encode($result[1]['purpose'].' (No Change)');?>;
		document.getElementsByName("purpose")[0].children[0].value			= <?php echo json_encode($result[1]['purpose']);?>;
		document.getElementsByName("contracttype")[0].children[0].innerHTML	= <?php echo json_encode($result[1]['contract_type'].' (No Change)');?>;
		document.getElementsByName("contracttype")[0].children[0].value		= <?php echo json_encode($result[1]['contract_type']);?>;
		
		validator.message.empty = 'Mandatory Field';
</script>  
<?php require ('components/closing.php');