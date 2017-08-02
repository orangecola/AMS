<?php 
	include_once('components/config.php');
	include('components/sidebar.php');
			
	$software = $user->getSoftwareList();
	
	function printSoftwareRow($software) {
		echo '<tr>';
		echo "<td>";
		echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($software['asset_tag'])."view href="."#".htmlentities($software['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
		echo "<a href=\"editsoftware.php?id=".htmlentities($software['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a>";
		echo "</td>";
		echo "<td>".htmlentities($software['asset_ID'])."</td>";
		$GLOBALS['user']->printAssetRow($software);
		echo "<td>".htmlentities($software['vendor'])				."</td>";
		echo "<td>".htmlentities($software['procured_from'])		."</td>";
		echo "<td>".htmlentities($software['shortname'])			."</td>";
		echo "<td>".htmlentities($software['purpose'])				."</td>";
		echo "<td>".htmlentities($software['contract_type'])		."</td>";
		echo "<td>".htmlentities($software['start_date'])			."</td>";
		echo "<td>".htmlentities($software['license_explanation'])	."</td>";
		echo "<td>".htmlentities($software['remarks'])				."</td>";
		echo '</tr>';
	}
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
			<h2>Software Assets list</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">

			
			<table id="datatable" class="table table-striped table-bordered dt-responsive">
			  <thead>
				<tr>
				  <th>Actions</th>
				  <th>Asset ID</th>
				  <th>Description</th>
				  <th>Quantity</th>
				  <th>CR / TR Number</th>
				  <th>PO Number</th>
				  <th>Release version</th>
				  <th>Expiry Date</th>
				  <th>Status</th>
				  <th>Vendor</th>
				  <th>Procured From</th>
				  <th>Short Name</th>
				  <th>Purpose</th>
				  <th>Contract Type</th>
				  <th>Start Date</th>
				  <th>License Explanation</th>
				  <th>Remarks</th>
				</tr>
			  </thead>


			  <tbody>
				<?php 							
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