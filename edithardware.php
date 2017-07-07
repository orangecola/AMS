<?php 
	include_once('components/config.php');
	$NoChanges=0;
	$DateError=0;
	$NumberError = 0;
	$Success=0;
	$ParentError = 0;
	$distinct = $user->getDistinct();
	$options = $user->getOptions();
	
	foreach($distinct[3] as &$value) {
		$value = $value[0];
	}
	if(!(isset($_GET['id']))) {
			header('Location: assetlist.php');
	}
	
	$result = $user->getHardware($_GET['id']);
	
	if (!$result[0]) {
		header('Location: assetlist.php');
	}
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$candidate['asset_ID'] 			= trim($_POST['assetid']);
		$candidate['description']		= trim($_POST['description']);
		$candidate['quantity']			= trim($_POST['quantity']);
		$candidate['price']				= trim($_POST['price']);
		$candidate['currency']			= trim($_POST['currency']);
		$candidate['crtrno']			= trim($_POST['crtrno']);
		$candidate['purchaseorder_id']	= trim($_POST['pono']);
		$candidate['release_version']	= trim($_POST['release']);
		$candidate['expirydate']		= trim($_POST['expirydate']);
		$candidate['remarks']			= trim($_POST['remarks']);
		$candidate['parent']			= trim($_POST['parent']);
		
		$candidate['class']				= trim($_POST['class']);
		$candidate['brand']				= trim($_POST['brand']);
		$candidate['audit_date']		= trim($_POST['auditdate']);
		$candidate['component']			= trim($_POST['component']);
		$candidate['label']				= trim($_POST['label']);
		$candidate['serial']			= trim($_POST['serial']);
		$candidate['location']			= trim($_POST['location']);
		$candidate['status']			= trim($_POST['status']);
		$candidate['replacing']			= trim($_POST['replacing']);
		
		$same = true;
		//Similarility Check
		foreach ($user->assetFields as $value) {
			if ($candidate[$value] != $result[1][$value]) {
				$same = false;
				break;
			}
		}
		unset($value);
		
		foreach ($user->hardwareFields as $value) {
			
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
		if (!(($user->validatesAsInt($candidate['price']) or $user->validatesAsDouble($candidate['price'])) and $user->validatesAsInt($candidate['quantity']))) {
			$NumberError = 1;
		}
		
		//Check Dates
		if (!($user->check_date($candidate['expirydate']))) {
				$DateError = 1;
		}
		
		if (!(in_array($candidate['parent'], $distinct[3])) and $candidate['parent'] != "") {
				$ParentError = 1;
		}
		
		if (!(in_array($candidate['replacing'], $distinct[3])) and $candidate['replacing'] != "") {
				$ParentError = 1;
		}
		
		if (!$same and $DateError == 0 and $NumberError == 0 and $ParentError == 0) {
			$candidate['version'] = $result[1]['version'] + 1;
			$candidate['asset_tag'] = $result[1]['asset_tag'];
			$user->editHardware($candidate);
			$result = $user->getHardware($_GET['id']);
			$Success = 1;
		}
	}

	include 'components/sidebar.php';
?>  
  
<script>
	document.getElementById('assetlist.php').setAttribute("class", "current-page");
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
			<h2>Edit Hardware Asset <?php echo $result[1]['asset_ID'];?><small>Last Edited: <?php echo $result[1]['lastedited']?></small></h2>
			
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
			<strong>Success</strong> Hardware edits successful
		  </div>';}
		  
		  if ($ParentError == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> Parent Asset ID Does not exist
		  </div>';}
		  
		  ?>
			<br />
			<form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
			  <?php 
				require 'asset.php';
				require 'hardware.php';
			  ?>
				<div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a class="btn btn-primary" href="assetlist.php">Cancel</a>
				  <button class="btn btn-primary" type="button" onclick="resetFields()">Reset</button>
				  <button type="submit" class="btn btn-success">Submit</button>
				</div>
			  </div>
				
			</div>
		  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>
<!-- /page content -->

<?php include 'components/footer.php';?>
<script>
	$('#parent').autocomplete({
		lookup: asset_ID,
		onSelect: function () {

    }
	});
	$('#replacing').autocomplete({
		lookup: asset_ID,
		onSelect: function () {

    }
	});
	
	function resetFields() {
				document.getElementById("demo-form2").reset();
				document.getElementsByName("assetid")[0].value = <?php echo json_encode($result[1]['asset_ID']);?>;
				document.getElementsByName("description")[0].innerHTML = <?php echo json_encode($result[1]['description']);?>;
				document.getElementsByName("quantity")[0].value = <?php echo json_encode($result[1]['quantity']);?>;
				document.getElementsByName("price")[0].value = <?php echo json_encode($result[1]['price']);?>;
				document.getElementsByName("crtrno")[0].value = <?php echo json_encode($result[1]['crtrno']);?>;
				document.getElementsByName("pono")[0].value = <?php echo json_encode($result[1]['purchaseorder_id']);?>;
				document.getElementsByName("expirydate")[0].value = <?php echo json_encode($result[1]['expirydate']);?>;
				document.getElementsByName("remarks")[0].innerHTML = <?php echo json_encode($result[1]['remarks']);?>;
				document.getElementsByName("parent")[0].value = <?php echo json_encode($result[1]['parent']);?>;
				
				document.getElementsByName("auditdate")[0].value = <?php echo json_encode($result[1]['audit_date']);?>;
				document.getElementsByName("component")[0].value = <?php echo json_encode($result[1]['component']);?>;
				document.getElementsByName("label")[0].value = <?php echo json_encode($result[1]['label']);?>;
				document.getElementsByName("serial")[0].value = <?php echo json_encode($result[1]['serial']);?>;
				document.getElementsByName("location")[0].value = <?php echo json_encode($result[1]['location']);?>;
				document.getElementsByName("replacing")[0].value = <?php echo json_encode($result[1]['replacing']);?>;
			}
			resetFields();
	</script>
<?php require 'components/closing.php'; ?>