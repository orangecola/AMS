<?php 
	include('components/config.php');
	$total = 0;
	$header = "";
	
	if(isset($_POST['purchaseorderid'])) {
		$header = "Purchase Order ". $_POST['purchaseorderid'];
		$result = $user->generateReport('purchaseorder_id', $_POST['purchaseorderid']);
		$purchaseorder = $user->getPurchaseOrder($_POST['purchaseorderid']);
	}
	else if(isset($_POST['release'])) {
		$header = 'Release ' . $_POST['release'];
		$result = $user->generateReport('release_version', $_POST['release']);
	}
	else if (isset($_POST['crtrno'])) {
		
		$header = 'CR / TR No ' . $_POST['crtrno'];
		$result = $user->generateReport('crtrno', $_POST['crtrno']);
	}
	else if (isset($_POST['expirydate'])) {
		$header = 'Expiring before ' . $_POST['expirydate'];
		$result = $user->generateReport('expirydate', $_POST['expirydate']);
	}
	else {
		header('Location: generatereport.php');
	}
	
	date_default_timezone_set('Asia/Singapore');
	$time = date("Y-m-d H:i:s");
	
	include('components/sidebar.php')
?>
<script>
	document.getElementById('generatereport.php').setAttribute("class", "current-page");
	var purchaseorderid = <?php echo json_encode($result[0]); ?>;
	console.log(<?php echo json_encode($purchaseorder);?>);
</script>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>Reports</h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_content">
			<section class="content invoice">
			  <!-- title row -->
			  <div class="row">
				<div class="col-xs-12 invoice-header">
				  <h1>
					  <i class="fa fa-globe"></i> <?php echo $header; ?>
					  <small class="pull-right">Time Generated: <?php echo $time; ?></small>
				  </h1>
				</div>
				<!-- /.col -->
			  </div>

			  <!-- Table row -->
			  <div class="row">
				<div class="col-xs-12 table">
				  <table class="table table-striped">
					<thead>
					  <tr>
						<th>Qty</th>
						<th>Asset ID</th>
						<th style="width: 59%">Description</th>
						<th>Expiry Date</th>
						<th>Price</th>
					  </tr>
					</thead>
					<tbody>
					<?php 
						foreach($result['asset'] as $row) {
							echo '<tr>';
							echo "<td>".htmlentities($row['quantity'])		."</td>";
							echo "<td>".htmlentities($row['asset_ID'])		."</td>";
							echo "<td>".htmlentities($row['description'])	."</td>";
							echo "<td>".htmlentities($row['expirydate'])	."</td>";
							if (isset($row['price'])) {
								echo "<td>$".htmlentities($row['price'])		."</td>";
								$total += $row['price'];
							}
							else {
								echo "<td>NA</td>";
							}
							echo '</tr>';
						}
						if (isset($result['renewal'])) {
							foreach($result['renewal'] as $row) {
								echo '<tr>';
								echo "<td>1</td>";
								echo "<td>"						.htmlentities($row['asset_ID'])		."</td>";
								echo "<td>Renewal for Asset "	.htmlentities($row['parent_ID'])	."</td>";
								echo "<td>"						.htmlentities($row['expiry_date'])	."</td>";
								echo "<td>NA</td>";
								echo '</tr>';
							}
						}
					?>

					</tbody>
				  </table>
				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
				<div class="row">
				<div class="col-xs-6">
				</div>
				<!-- /.col -->
				<div class="col-xs-6">
				  <p class="lead pull-right">Calculated Total $<?php echo $total;?>
				  <?php if(isset($_POST['purchaseorderid']) and $purchaseorder['exists']) {
					echo "<br />Discount \${$purchaseorder['purchaseorder']['discount']}";
					echo "<br />Saved Total \${$purchaseorder['purchaseorder']['total']}";
				}?>
				</p>
				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			  <!-- this row will not appear when printing -->
			  <div class="row hidden-print">
				<div class="col-xs-12">
				  <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
				  <a class="btn btn-default" href="downloadreport.php?<?php
					if(isset($_POST['purchaseorderid'])) {
						echo 'purchaseorderid='.$_POST['purchaseorderid'];
					}
					else if(isset($_POST['release'])) {
						echo 'release='.$_POST['release'];
					}
					else if (isset($_POST['crtrno'])) {
						echo 'crtrno='. $_POST['crtrno'];
					}
					else if (isset($_POST['expirydate'])) {
						echo 'expirydate='. $_POST['expirydate'];
					};
				  ?>"><i class="fa fa-download"></i> Download Report</a>
				</div>
			  </div>
			</section>
		  </div>
		</div>
	  </div>
	  </div>
	</div>
  </div>
<!-- /page content -->

<?php 
	include 'components/footer.php';
	include 'components/closing.php';
?>