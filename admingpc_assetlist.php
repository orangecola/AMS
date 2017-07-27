<?php 
	include_once('components/config.php');
	if(!($_SESSION['role'] == 'admin'))
	  {
		 header('Location: logout.php');
	  }
	include('components/sidebar.php');
			
	$asset = $user->getGPCAssetList();
	
	function printAssetRow($asset) {
		echo '<tr>';
		echo "<td>";
		echo "<a href=\"gpc_assetversions.php?id=".htmlentities($asset['gpc_asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Versions</a>";
		echo "</td>";
		echo "<td>".htmlentities($asset['gpc_Environment'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Tier'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Phase'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Item'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Ami'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Startdate'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Expirydate'])."</td>";
		echo "<td>".htmlentities($asset['gpc_halb'])."</td>";
		echo "<td>".htmlentities($asset['gpc_quantity'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Application'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Data'])."</td>";
		echo "<td>".htmlentities($asset['gpc_IOPS'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Backup'])."</td>";
		echo "<td>".htmlentities($asset['gpc_OS'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Y1_Qt'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Y2_Qt'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Y1_Ops'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Y2_Ops'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Gwgc'])."</td>";
		echo "<td>".htmlentities($asset['gpc_Remarks'])."</td>";
		echo '</tr>';
	}
?>
<script>
	document.getElementById('admingpc_assetlist.php').setAttribute("class", "current-page");
</script>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>GP Connect Asset Management</h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>GP Connect Assets list</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable" class="table table-striped table-bordered dt-responsive">
			  <thead>
				<tr>
				  <th>Actions</th>
				  <th>Environment</th>
				  <th>Tier</th>
				  <th>Phase</th>
				  <th>Item</th>
				  <th>AWS AMI</th>
				  <th>RI Invoked</th>
				  <th>Expiry Date</th>
				  <th>HA / LB</th>
				  <th>Quantity</th>
				  <th>OS + Application (GB)</th>
				  <th>Data (GB)</th>
				  <th>IOPS per Database Server</th>
				  <th>Backup Volume (GB)</th>
				  <th>OS Spec Required</th>
				  <th>Number of Servers in Year 1</th>
				  <th>Number of Servers in Year 2</th>
				  <th>Operating Requirements (Year 1)</th>
				  <th>Operating Requirements (Year 2)</th>
				  <th>GW / GC</th>
				  <th>Remarks</th>
				</tr>
			  </thead>


			  <tbody>
				<?php 							
					foreach($asset as $row) {
						printAssetRow($row);
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