<?php 
	include_once('components/config.php');
	$Success=0;
	$noChanges=0;
		
	if(!(isset($_GET['id']))) {
			header('Location: userlist.php');
	}
	
	$result = $user->getRenewal($_GET['id']);
	
	if (!$result[0]) {
		header('Location: renewallist.php');
	}
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		/*
		$candidate['username'] 	= trim($_POST['username']);
		$candidate['password'] 	= password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
		$candidate['role'] 		= trim($_POST['role']);
		$candidate['status']	= trim($_POST['status']);
		
		$same = true;
		
		foreach ($user->userFields as $value) {
			
			if ($candidate[$value] != $result[1][$value]) {
				$same = false;
				break;
			}
		}
		unset($value);
		
		if ($same) {
			$noChanges = 1;
		}
		*/
	}

	include 'components/sidebar.php';
?>  
  
<script>
	document.getElementById('renewallist.php').setAttribute("class", "current-page");
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
			<h2>Editing Renewal <?php echo htmlentities($_GET['id']);?></h2>
			
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
		  <?php
				// Error / Success Messages
		  ?>
			<br />
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
				<?php require 'components/renewal.php' ?>
			  
			  <div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a href="userlist.php" class="btn btn-primary" type="cancel">Cancel</a>
				  <button class="btn btn-primary" type="button" onclick="resetFields();">Reset</button>
				  <button type="submit" class="btn btn-success">Submit</button>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>

<script>
	function resetFields() {
	document.getElementsByName("assetid")[0].value =	<?php echo json_encode($result[1]['asset_ID']);?>;
	document.getElementsByName("parent")[0].value = 	<?php echo json_encode($result[1]['parent_ID']);?>;
	document.getElementsByName("pono")[0].value = 		<?php echo json_encode($result[1]['purchaseorder_id']);?>;
	document.getElementsByName("startdate")[0].value = 	<?php echo json_encode($result[1]['startdate']);?>;
	document.getElementsByName("expiry_date")[0].value = <?php echo json_encode($result[1]['expiry_date']);?>;
	}
	resetFields();
</script>
<!-- /page content -->
<?php
	include 'components/footer.php';
	include 'components/closing.php';
?>