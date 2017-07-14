<?php 
	include_once('components/config.php');
	include('components/sidebar.php');
	$renewals = $user->getRenewals();
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
			<h2>Renewal list</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable" class="table table-striped table-bordered">
			  <thead>
				<tr>
				  <th>Asset ID</th>
				  <th>Parent ID</th>
				  <th>Purchase Order ID</th>
				  <th>Start Date</th>
				  <th>End Date</th>
				  <th>Actions</th>
				</tr>
			  </thead>
			  <tbody>
				<?php 
					foreach($renewals as $row) {
						$user->printRenewalRow($row);
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