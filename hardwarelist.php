<?php
	include_once('components/config.php');
	include('components/sidebar.php');
	
	$hardware = $user->getHardwareList();
				
	function printHardwareRow($hardware) {
		echo '<tr>';
		echo "<td>";
		echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($hardware['asset_tag'])."view href="."#".htmlentities($hardware['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
		echo "<a href=\"edithardware.php?id=".htmlentities($hardware['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a>";
		echo "</td>";
		echo "<td>".htmlentities($hardware['asset_ID'])."</td>";
		$GLOBALS['user']->printAssetRow($hardware);
		echo "<td>".htmlentities($hardware['price'])			." ".htmlentities($hardware['currency'])."</td>";
		echo "<td>".htmlentities($hardware['IHiS_Asset_ID'])."</td>";
		echo "<td>".htmlentities($hardware['CR359 / CR506'])."</td>";
		echo "<td>".htmlentities($hardware['CR560'])."</td>";
		echo "<td>".htmlentities($hardware['POST-CR560'])."</td>";
		echo "<td>".htmlentities($hardware['class'])."</td>";
		echo "<td>".htmlentities($hardware['brand'])."</td>";
		echo "<td>".htmlentities($hardware['audit_date'])."</td>";
		echo "<td>".htmlentities($hardware['component'])."</td>";
		echo "<td>".htmlentities($hardware['label'])."</td>";
		echo "<td>".htmlentities($hardware['serial'])."</td>";
		echo "<td>".htmlentities($hardware['location'])."</td>";
		echo "<td>".htmlentities($hardware['replacing'])."</td>";
		echo "<td>".htmlentities($hardware['excelsheet'])."</td>";
		echo "<td>".htmlentities($hardware['remarks'])."</td>";
		
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
			<table style="width:100%"id="datatable" class="table table-striped table-bordered dt-responsive">
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
				  <th>Price</th>
				  <th>IHiS_Asset_ID</th>
				  <th>CR359/CR506</th>
				  <th>CR560</th>
				  <th>Post-CR560</th>
				  <th>Class</th>
				  <th>Brand</th>
				  <th>Audit Date</th>
				  <th>Component</th>
				  <th>Label</th>
				  <th>Serial</th>
				  <th>Location</th>
				  <th>RMA</th>
				  <th>ExcelSheet</th>
				  <th>Remarks</th>
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
