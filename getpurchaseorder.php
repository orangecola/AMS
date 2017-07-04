<!DOCTYPE html>
<html lang="en">


<?php 
	include('config.php');
	$total = "";
	$discount = "";
	if(isset($_POST['purchaseorderid'])) {
		$result = $user->getPurchaseOrder($_POST['purchaseorderid']);
		if(!$result['validation']) {
			echo 'Purchase Order does not exist';
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
	<form id="demo-form2" class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
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
		<div class="item form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order Receipt
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="input-group">
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
					<input type="hidden" name="purchaseorderid" value="<?php echo htmlentities($_POST['purchaseorderid']);?>">
					<input name="file" type="file">				
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary" name="action" value="upload">Upload</button>
					</span>
				</div>
			</div>
			
		</div>
		<?php if (isset($result['purchaseorder']['filename']) and $result['purchaseorder']['filename'] != "") {?>
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Saved File
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="input-group">
					<?php
						echo "<a href='downloadpurchaseorder.php?id={$result['purchaseorder_id']}'>{$result['purchaseorder']['filename']}</a> ";
					?>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-danger" name="action" value="delete">Delete</button>
					</span>
				</div>
			</div>	

		<?php } ?>
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
							if (isset($result['hardware'])) {
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
									$user->printHardwareModal($row);
								}
							}
							if (isset($result['software'])) {
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
									$user->printSoftwareModal($row);
								}
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
