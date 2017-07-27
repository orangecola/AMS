<?php 
	include('components/config.php');
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
	<?php if (isset($result['hardware']) or isset($result['software'])) {?>
		<h3>Assets</h3>
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
	<?php }?>
	<?php if (isset($result['renewal'])) { ?>
		<h3>Renewals</h3>
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
							foreach($result['renewal'] as $row) {
								$user->printRenewalRow($row);
							}
					  ?>
					  </tbody>
					</table>
	<?php } ?>
	
	
<?php require 'components/datatables.php';?>