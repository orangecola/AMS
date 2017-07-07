<?php
	include_once('components/config.php');
	include('components/sidebar.php');
	
	$hardware = $user->getHardwareList();
				
	function printHardwareRow($hardware) {
		echo '<tr>';
		echo "<td>".htmlentities($hardware['asset_ID'])."</td>";
		$GLOBALS['user']->printAssetRow($hardware);
		echo "<td>";
		echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($hardware['asset_tag'])."view href="."#".htmlentities($hardware['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
		echo "<a href=\"edithardware.php?id=".htmlentities($hardware['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a>";
		echo "</td>";
		echo '</tr>';
	}
?>
<script>
	document.getElementById('hardwarelist.php').setAttribute("class", "current-page");
</script>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>Hardware Asset Management</h3>
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
				  <th>Asset ID</th>
				  <th>Description</th>
				  <th>Quantity</th>
				  <th>Price</th>
				  <th>CR / TR Number</th>
				  <th>PO Number</th>
				  <th>Release version</th>
				  <th>Expiry Date</th>
				  <th>Remarks</th>
				  <th>Actions</th>
				</tr>
			  </thead>
			  <tbody>
				<?php 
					foreach($hardware as $row) {
						printHardwareRow($row);
						$user->printHardwareModal($row);
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
	include 'components/footer.php';
	include 'components/datatables.php';
	include 'components/closing.php';
?>
