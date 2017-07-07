<?php 
	include_once('components/config.php');
	$noversion = 0;
	$current = 0;
	$success = 0;
	
	if(!(isset($_GET['id']))) {
			header('Location: adminassetlist.php');
	}
	
	$result = $user->getSoftwareVersions($_GET['id']);
	$options = $user->getOptions();
	
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
		
		else {/*
			foreach($result[1] as $row) {
				if ($row['version'] == $_POST['version']) {
					$row['version'] = $currentversion + 1;
					$user->editSoftware($row);
					break;
				}
			}
			$result = $user->getSoftwareVersions($_GET['id']);
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
			<h2>Edit Software Asset Tag <?php echo $_GET['id'];?></h2>
			
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
				include 'components/asset.php';
				include 'components/software.php';
			  ?>
			  </div>
				<div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a class="btn btn-primary" href="adminassetlist.php">Cancel</a>
				  <!--<button type="submit" class="btn btn-danger">Revert</button>--> 
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
		document.getElementsByName("price")[0].value = versions[p1]["price"];
		document.getElementsByName("crtrno")[0].value = versions[p1]["crtrno"];
		document.getElementsByName("pono")[0].value = versions[p1]["purchaseorder_id"];
		document.getElementsByName("release")[0].value = versions[p1]["release_version"];
		document.getElementsByName("expirydate")[0].value = versions[p1]["expirydate"];
		document.getElementsByName("parent")[0].value= versions[p1]["parent"];
		document.getElementsByName("remarks")[0].innerHTML = versions[p1]["remarks"];
		
		document.getElementsByName("vendor")[0].value = versions[p1]["vendor"];
		document.getElementsByName("procure")[0].value = versions[p1]["procured_from"];
		document.getElementsByName("shortname")[0].value = versions[p1]["shortname"];
		document.getElementsByName("purpose")[0].value = versions[p1]["purpose"];
		document.getElementsByName("contracttype")[0].value = versions[p1]["contract_type"];
		document.getElementsByName("startdate")[0].value = versions[p1]["start_date"];
		document.getElementsByName("license")[0].value = versions[p1]["license_explanation"];
		document.getElementsByName("verification")[0].value = versions[p1]["verification"];
	}
	document.getElementsByTagName("BODY")[0].setAttribute("class", "nav-md");
</script>    
<!-- /page content -->

<?php
	include 'components/footer.php';
	include 'components/closing.php';
?>