<!DOCTYPE html>
<html lang="en">


<?php 
	include('config.php');
	$total = "";
	$discount = "";
	if(isset($_POST['purchaseorderid'])) {
		$result = $user->getPurchaseOrder($_POST['purchaseorderid']);
		if(!$result['validation']) {
			exit();
		}
		if($result['exists']) {
			$total = $result['purchaseorder']['total'];
			$discount = $result['purchaseorder']['discount'];
		}
		if(isset($_POST['update'])) {
			if ($result['exists']) {
				$user->updatePurchaseOrder($_POST['purchaseorderid'], $_POST['update'], $_POST['value']);
			}
			else {
				$user->newPurchaseOrder($_POST['purchaseorderid'], $_POST['update'], $_POST['value']);
			}
			
			$result = $user->getPurchaseOrder($_POST['purchaseorderid']);
			if($result['exists']) {
				$total = $result['purchaseorder']['total'];
				$discount = $result['purchaseorder']['discount'];
			}
		}
	}	
?>  
	<form id="demo-form2" class="form-horizontal form-label-left" method="post" action="report.php">
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Discount
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="input-group">
					<input type="text" class="form-control" id="discount" name="discount" value="<?php echo htmlentities($discount);?>">
					<span class="input-group-btn">
						<button type="button" class="btn btn-primary" onclick="savepurchaseorder('discount');" >Save</button>
					</span>
				</div>
			</div>
		</div>
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Total Cost (After discount)
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="input-group">
					<input type="text" class="form-control" id="total" name="total" value="<?php echo htmlentities($total);?>">
					<span class="input-group-btn">
						<button type="button" class="btn btn-primary" onclick="savepurchaseorder('total');" >Save</button>
					</span>
				</div>
			</div>
		</div>
	</form>
		<table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Asset ID</th>
						  <th>Type</th>
						  <th style="width: 59%">Description</th>
						  <th>Quantity</th>
						  <th>Price</th>
						  <th>Actions</th>
                        </tr>
                      </thead>


                      <tbody>
						<?php 
							foreach($result['hardware'] as $row) {
								echo '<tr>';
								echo "<td>".htmlentities($row['asset_ID'])."</td>";
								echo "<td>Hardware</td>";
								echo "<td>".htmlentities($row['description'])		."</td>";
								echo "<td>".htmlentities($row['quantity'])			."</td>";
								echo "<td>".htmlentities($row['price'])				."</td>";
								echo "<td>";
								echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($row['asset_tag'])."view href="."#".htmlentities($row['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
								echo "<a href=\"edithardware.php?id=".htmlentities($row['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a>";
								echo "</td>";
								echo '</tr>';
								#Modal for more information
								echo "<div id='".htmlentities($row['asset_tag'])."view' class='modal fade' role='dialog'>";
								echo 	"<div class='modal-dialog'>";
								echo 		"<div class='modal-content'>";
								echo 			"<div class='modal-header'>";
								echo 				"<button type='button' class='close' data-dismiss='modal'>&times;</button>";
								echo 					"<h3 class='modal-title'>Asset ".htmlentities($row['asset_ID'])." Information</h3>";
								echo 			"</div>";
								echo	 		"<div class='modal-body'>";
								echo				"<h4>Asset Information</h4>";
								echo				"<p>Description			: ".htmlentities($row['description'])		."</p>";
								echo				"<p>Quantity			: ".htmlentities($row['quantity'])			."</p>";
								echo				"<p>Price				: ".htmlentities($row['price'])				."</p>";
								echo				"<p>CR / TR No			: ".htmlentities($row['crtrno'])			."</p>";
								echo				"<p>Purchase Order ID	: ".htmlentities($row['purchaseorder_id'])	."</p>";
								echo				"<p>Release Version		: ".htmlentities($row['release_version']) 	."</p>";
								echo				"<p>Expiry Date			: ".htmlentities($row['expirydate']) 		."</p>";
								echo				"<p>Remarks				: ".htmlentities($row['remarks']) 			."</p>";
								echo				"<h4>Hardware Information</h4>";
								echo				"<p>Class				: ".htmlentities($row['class']) 			."</p>";
								echo				"<p>Brand				: ".htmlentities($row['brand']) 			."</p>";
								echo				"<p>Audit Date			: ".htmlentities($row['audit_date']) 		."</p>";
								echo				"<p>Component			: ".htmlentities($row['component']) 		."</p>";
								echo 				"<p>Label				: ".htmlentities($row['label']) 			."</p>";
								echo				"<p>Serial				: ".htmlentities($row['serial']) 			."</p>";
								echo				"<p>Location 			: ".htmlentities($row['location']) 			."</p>";
								echo				"<p>Status				: ".htmlentities($row['status'])			."</p>";
								echo				"<p>Replacing			: ".htmlentities($row['replacing']) 		."</p>";
								echo 			"</div>";
								echo 		"<div class='modal-footer'>";
								echo			"<a href=\"edithardware.php?id=".htmlentities($row['asset_tag'])."\" class=\"btn btn-info\"><i class='fa fa-edit'></i>Edit</a>";
								echo 			"<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
								echo		"</div>";
								echo	"</div>";
								echo "</div>";
							}
							
							foreach($result['software'] as $row) {
								echo '<tr>';
								echo "<td>".htmlentities($row['asset_ID'])			."</td>";
								echo "<td>Software</td>";
								echo "<td>".htmlentities($row['description'])		."</td>";
								echo "<td>".htmlentities($row['quantity'])			."</td>";
								echo "<td>".htmlentities($row['price'])				."</td>";
								echo "<td>";
								echo "<a class='btn btn-primary btn-xs' data-toggle='modal' data-target="."#".htmlentities($row['asset_tag'])."view href="."#".htmlentities($row['asset_tag'])."view><i class='fa fa-folder'></i> View </a>";
								echo "<a href=\"editsoftware.php?id=".htmlentities($row['asset_tag'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a>";
								echo "</td>";
								echo '</tr>';
								#Modal for more information
								echo "<div id='".htmlentities($row['asset_tag'])."view' class='modal fade' role='dialog'>";
								echo 	"<div class='modal-dialog'>";
								echo 		"<div class='modal-content'>";
								echo 			"<div class='modal-header'>";
								echo 				"<button type='button' class='close' data-dismiss='modal'>&times;</button>";
								echo 					"<h3 class='modal-title'>Asset ".htmlentities($row['asset_ID'])." Information</h3>";
								echo 			"</div>";
								echo	 		"<div class='modal-body'>";
								echo				"<h4>Asset Information</h4>";
								echo				"<p>Description			: ".htmlentities($row['description'])			."</p>";
								echo				"<p>Quantity			: ".htmlentities($row['quantity'])				."</p>";
								echo				"<p>Price				: ".htmlentities($row['price'])					."</p>";
								echo				"<p>CR / TR No			: ".htmlentities($row['crtrno']) 				."</p>";
								echo				"<p>Purchase Order ID	: ".htmlentities($row['purchaseorder_id']) 		."</p>";
								echo				"<p>Release Version		: ".htmlentities($row['release_version'])		."</p>";
								echo				"<p>Expiry Date			: ".htmlentities($row['expirydate']) 			."</p>";
								echo				"<p>Remarks				: ".htmlentities($row['remarks']) 				."</p>";
								echo				"<h4>Software Information</h4>";
								echo				"<p>Vendor				: ".htmlentities($row['vendor'])				."</p>";
								echo				"<p>Procured From		: ".htmlentities($row['procured_from']) 		."</p>";
								echo				"<p>Short Name			: ".htmlentities($row['shortname']) 			."</p>";
								echo				"<p>Purpose				: ".htmlentities($row['purpose']) 				."</p>";
								echo 				"<p>Contract type		: ".htmlentities($row['contract_type']) 		."</p>";
								echo				"<p>Start Date			: ".htmlentities($row['start_date']) 			."</p>";
								echo				"<p>License Explanation	: ".htmlentities($row['license_explanation']) 	."</p>";
								echo				"<p>Verification		: ".htmlentities($row['verification']) 			."</p>";
								echo 			"</div>";
								echo 		"<div class='modal-footer'>";
								echo			"<a href=\"editsoftware.php?id=".htmlentities($row['asset_tag'])."\" class=\"btn btn-info\"><i class='fa fa-edit'></i>Edit</a>";
								echo 			"<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
								echo		"</div>";
								echo	"</div>";
								echo "</div>";
							}
							
							
						?>
                      </tbody>
                    </table>
						<!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
	
	
</html>
