<?php 
	include_once('components/config.php');
	$noversion = 0;
	$current = 0;
	$success = 0;
	
	if(!(isset($_GET['id']))) {
			header('Location: adminassetlist.php');
	}
	
	$result = $user->getHardwareVersions($_GET['id']);
	$options = $user->getOptions('nehr_Options', ['currency', 'releaseversion', 'status', 'class', 'brand']);
	
	if (!$result[0]) {
		header('Location: adminassetlist.php');
	}

	$currentversion = $user->getCurrentVersion($_GET['id'])['current_version'];

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$versioncheck = false;
		foreach($result[1] as $row) {
			if($row['version'] == $_POST['version']) {
				$versioncheck = true;
				break;
			}
		}
		
		if (!$versioncheck) {
			$noversion = 1;
		}

		
		else if ($_POST['version'] == $currentversion) {
			$current = 1;
		}
		
		else {
			/*
			foreach($result[1] as $row) {
				if ($row['version'] == $_POST['version']) {
					$row['version'] = $currentversion + 1;
					$user->editHardware($row);
					break;
				}
			}
			$result = $user->getHardwareVersions($_GET['id']);
			$success = 1;
			*/
		}
	}
	include('components/sidebar.php');
?>
<script>
	document.getElementById('adminassetlist.php').setAttribute("class", "current-page");
	var versions = new Array();
	
	<?php 
		foreach ($result[1] as $row) {
			echo "versions[{$row['version']}] = ".json_encode($row).";";
		}
	?>
	console.log(versions);
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
			<h2>Hardware Asset Versions of Asset Tag <?php echo $_GET['id'];?></h2>
			
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
		  <?php
		  if ($noversion == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> Version not found
		  </div>';} 
		  
		  if ($current == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> Version is already the current version
		  </div>';}
		  
		  if ($success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Success</strong> Asset reverted successfully
		  </div>';}
		  
		  ?>
			<br />
			<form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Version</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <select class="form-control" name="version" onchange="populate()">
					<option>Select version</option>
					<?php 
						foreach($result[1] as $row) {
							echo "<option value={$row['version']}>{$row['version']}</option>";
						}
					?>
				  </select>
				</div>
			  </div>
			  <?php 
				require 'components/asset.php';
				require 'components/hardware.php'
			  ?>
			  <div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a class="btn btn-primary" href="adminassetlist.php">Cancel</a>
				  <!--<button type="submit" class="btn btn-danger">Revert</button>-->
				</div>
			  </div>
			</div>
		  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>
<script>
	function populate() {
		p1 = document.getElementsByName("version")[0].value;
		document.getElementsByName("assetid")[0].value = versions[p1]["asset_ID"];
		document.getElementsByName("description")[0].innerHTML = versions[p1]["description"];
		document.getElementsByName("quantity")[0].value = versions[p1]["quantity"];
		document.getElementsByName("crtrno")[0].value = versions[p1]["crtrno"];
		document.getElementsByName("pono")[0].value = versions[p1]["purchaseorder_id"];
		document.getElementsByName("release")[0].value = versions[p1]["release_version"];
		document.getElementsByName("expirydate")[0].value = versions[p1]["expirydate"];
		document.getElementsByName("remarks")[0].innerHTML = versions[p1]["remarks"];
		
		document.getElementsByName("price")[0].value = versions[p1]["price"];
		document.getElementsByName("currency")[0].value = versions[p1]["currency"];
		document.getElementsByName("IHiS_Asset_ID")[0].value = versions[p1]["IHiS_Asset_ID"];
		document.getElementsByName("CR359")[0].value = versions[p1]["CR359 / CR506"];
		document.getElementsByName("CR560")[0].value = versions[p1]["CR560"];
		document.getElementsByName("POST-CR560")[0].value = versions[p1]["POST-CR560"];
		document.getElementsByName("class")[0].value = versions[p1]["class"];
		document.getElementsByName("brand")[0].value = versions[p1]["brand"];
		document.getElementsByName("auditdate")[0].value = versions[p1]["audit_date"];
		document.getElementsByName("component")[0].value = versions[p1]["component"];
		document.getElementsByName("label")[0].value = versions[p1]["label"];
		document.getElementsByName("serial")[0].value = versions[p1]["serial"];
		document.getElementsByName("location")[0].value = versions[p1]["location"];
		document.getElementsByName("status")[0].value = versions[p1]["status"];
		document.getElementsByName("replacing")[0].value = versions[p1]["replacing"];
		document.getElementsByName("excelsheet")[0].value = versions[p1]["excelsheet"];
	}
	
	document.getElementsByName("assetid")[0].disabled = true;
	document.getElementsByName("description")[0].disabled = true;
	document.getElementsByName("quantity")[0].disabled = true;
	document.getElementsByName("price")[0].disabled = true;
	document.getElementsByName("crtrno")[0].disabled = true;
	document.getElementsByName("pono")[0].disabled = true;
	document.getElementsByName("release")[0].disabled = true;
	document.getElementsByName("expirydate")[0].disabled = true;
	document.getElementsByName("status")[0].disabled = true;
	document.getElementsByName("remarks")[0].disabled = true;
	document.getElementsByName("currency")[0].disabled = true;
	document.getElementsByName("class")[0].disabled = true;
	document.getElementsByName("brand")[0].disabled = true;
	document.getElementsByName("auditdate")[0].disabled = true;
	document.getElementsByName("component")[0].disabled = true;
	document.getElementsByName("label")[0].disabled = true;
	document.getElementsByName("serial")[0].disabled = true;
	document.getElementsByName("location")[0].disabled = true;
	document.getElementsByName("replacing")[0].disabled = true;
	document.getElementsByName("excelsheet")[0].disabled = true;
	document.getElementsByName("IHiS_Asset_ID")[0].disabled = true;
	document.getElementsByName("CR359")[0].disabled = true;
	document.getElementsByName("CR560")[0].disabled = true;
	document.getElementsByName("POST-CR560")[0].disabled = true;
	
</script>    
<!-- /page content -->

<?php
	include 'components/footer.php';
	include 'components/closing.php';
?>