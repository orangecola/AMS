<?php 
	include_once('components/config.php');
	
	if(!(isset($_GET['id']))) {
			header('Location: adminassetlist.php');
	}
	
	$result = $user->getGPCAssetVersions($_GET['id']);
	if (!$result[0]) {
		header('Location: adminassetlist.php');
	}
	$options = $user->getOptions('gpc_Options', ['gpc_Gwgc', 'gpc_Environment', 'gpc_Tier', 'gpc_Item', 'gpc_Ami', 'gpc_halb', 'gpc_OS', 'gpc_Ops', 'gpc_Phase']);
	include('components/sidebar.php');
?>
<script>
	document.getElementById('admingpc_assetlist.php').setAttribute("class", "current-page");
	var versions = new Array();
	
	<?php 
		foreach ($result[1] as $row) {
			echo "versions[{$row['gpc_version']}] = ".json_encode($row).";";
		}
	?>
</script>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>GPC Asset Management</h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		

	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>GPC Asset Versions of Asset Tag <?php echo $_GET['id'];?></h2>
			
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<br />
			<form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Version</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <select class="form-control" name="version" onchange="populate()">
					<option>Select version</option>
					<?php 
						foreach($result[1] as $row) {
							echo "<option value={$row['gpc_version']}>{$row['gpc_version']}</option>";
						}
					?>
				  </select>
				</div>
			  </div>
			  <?php 
				require 'components/gpc_asset.php';
			  ?>
			  <div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a class="btn btn-primary" href="admingpc_assetlist.php">Cancel</a>
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
		document.getElementsByName("gpc_Environment")[0].value 	= versions[p1]["gpc_Environment"];
		document.getElementsByName("gpc_Tier")[0].value 		= versions[p1]["gpc_Tier"];
		document.getElementsByName("gpc_Phase")[0].value	 	= versions[p1]["gpc_Phase"];
		document.getElementsByName("gpc_Item")[0].value 		= versions[p1]["gpc_Item"];
		document.getElementsByName("gpc_Remarks")[0].value 		= versions[p1]["gpc_Remarks"];
		document.getElementsByName("gpc_Ami")[0].value 			= versions[p1]["gpc_Ami"];
		document.getElementsByName("gpc_Startdate")[0].value 	= versions[p1]["gpc_Startdate"];
		document.getElementsByName("gpc_Expirydate")[0].value 	= versions[p1]["gpc_Expirydate"];
		document.getElementsByName("gpc_halb")[0].value 		= versions[p1]["gpc_halb"];
		document.getElementsByName("gpc_quantity")[0].value 	= versions[p1]["gpc_quantity"];
		document.getElementsByName("gpc_Application")[0].value 	= versions[p1]["gpc_Application"];
		document.getElementsByName("gpc_Data")[0].value			= versions[p1]["gpc_Data"];
		document.getElementsByName("gpc_IOPS")[0].value 		= versions[p1]["gpc_IOPS"];
		document.getElementsByName("gpc_Backup")[0].value 		= versions[p1]["gpc_Backup"];
		document.getElementsByName("gpc_OS")[0].value 			= versions[p1]["gpc_OS"];
		document.getElementsByName("gpc_Y1_Qt")[0].value 		= versions[p1]["gpc_Y1_Qt"];
		document.getElementsByName("gpc_Y2_Qt")[0].value 		= versions[p1]["gpc_Y2_Qt"];
		document.getElementsByName("gpc_Y1_Ops")[0].value 		= versions[p1]["gpc_Y1_Ops"];
		document.getElementsByName("gpc_Y2_Ops")[0].value		= versions[p1]["gpc_Y2_Ops"];
		document.getElementsByName("gpc_Gwgc")[0].value			= versions[p1]["gpc_Gwgc"];
	}
	
		document.getElementsByName("gpc_Environment")[0].disabled 	= true; 	
		document.getElementsByName("gpc_Tier")[0].disabled 			= true; 		
		document.getElementsByName("gpc_Phase")[0].disabled 		= true;	 	
		document.getElementsByName("gpc_Item")[0].disabled 			= true; 		
		document.getElementsByName("gpc_Remarks")[0].disabled 		= true; 		
		document.getElementsByName("gpc_Ami")[0].disabled 			= true; 			
		document.getElementsByName("gpc_Startdate")[0].disabled 	= true; 	
		document.getElementsByName("gpc_Expirydate")[0].disabled 	= true; 	
		document.getElementsByName("gpc_halb")[0].disabled 			= true; 		
		document.getElementsByName("gpc_quantity")[0].disabled 		= true; 	
		document.getElementsByName("gpc_Application")[0].disabled 	= true; 	
		document.getElementsByName("gpc_Data")[0].disabled 			= true;			
		document.getElementsByName("gpc_IOPS")[0].disabled 			= true; 		
		document.getElementsByName("gpc_Backup")[0].disabled 		= true; 		
		document.getElementsByName("gpc_OS")[0].disabled 			= true; 			
		document.getElementsByName("gpc_Y1_Qt")[0].disabled 		= true; 		
		document.getElementsByName("gpc_Y2_Qt")[0].disabled 		= true; 		
		document.getElementsByName("gpc_Y1_Ops")[0].disabled 		= true; 		
		document.getElementsByName("gpc_Y2_Ops")[0].disabled 		= true;		
		document.getElementsByName("gpc_Gwgc")[0].disabled 			= true;			
	
</script>    

<!-- /page content -->

<?php
	include 'components/footer.php';
	include 'components/closing.php';
?>