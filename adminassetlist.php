<?php
	include_once('components/config.php');
	if(!($_SESSION['role'] == 'admin'))
	  {
		 header('Location: logout.php');
	  }

	include('components/sidebar.php');
	
	$software = $user->getSoftwareList();
	$hardware = $user->getHardwareList();
	
	function printHardwareRow($hardware) {
		echo '<tr>';
		echo "<td>";
		echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($hardware['asset_tag'])."view href="."#".htmlentities($hardware['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
		echo "<a href=\"hardwareversions.php?id=".htmlentities($hardware['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Versions</a>";
		echo "</td>";
		echo "<td>".htmlentities($hardware['asset_ID'])."</td>";
		echo "<td>Hardware</td>";
		$GLOBALS['user']->printAssetRow($hardware);
		echo '</tr>';
	}
	
	function printSoftwareRow($software) {
		echo '<tr>';
		echo "<td>";
		echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($software['asset_tag'])."view href="."#".htmlentities($software['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
		echo "<a href=\"softwareversions.php?id=".htmlentities($software['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Versions</a>";
		echo "</td>";
		echo "<td>".htmlentities($software['asset_ID'])."</td>";
		echo "<td>Software</td>";
		$GLOBALS['user']->printAssetRow($software);
		echo '</tr>';
	}
?>
<script>
	document.getElementById('adminassetlist.php').setAttribute("class", "current-page");
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
			<h2>Assets list</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable" class="table table-striped table-bordered">
			  <thead>
				<tr>
				  <th>Actions</th>
				  <th>Asset ID</th>
				  <th>Type</th>
				  <th>Description</th>
				  <th>Qty</th>
				  <th>CR / TR Number</th>
				  <th>PO Number</th>
				  <th>Release version</th>
				  <th>Expiry Date</th>
				  <th>Status</th>
				  <th>Point of Contact</th>
				</tr>
			  </thead>
			  <tbody>
				<?php 
					foreach($hardware as $row) {
						printHardwareRow($row);
						$user->printHardwareModal($row);
					}
					
					foreach($software as $row) {
						printSoftwareRow($row);
						$user->printSoftwareModal($row);
					}
				?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<!-- /page content -->
<?php
	require 'components/footer.php';
	require 'components/datatables.php';
	require 'components/closing.php';
?>