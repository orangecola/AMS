<?php 
	include('components/config.php');
	
	$result = $user->getDistinct();
	
	foreach($result as &$entry) {
		foreach($entry as &$value) {
			$value = $value[0];
		}
	}
	
	unset($value);
	$parsed = array();
	foreach($result[2] as &$value) {		
		$value = array_map('trim', explode(",", $value));
		foreach($value as $row) {
			array_push($parsed, $row);
		}
	}
	unset($value);
	
	$result[2] = array_keys(array_flip($parsed)); 
	
    include('components/sidebar.php')
?>
<script>
	document.getElementById('generatereport.php').setAttribute("class", "current-page");
	var purchaseorderid = <?php echo json_encode($result[0]); ?>;
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
		  <div class="x_title">
			<h2>Generate Report</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<br />
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="report.php">
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order ID
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" class="form-control col-md-7 col-xs-12 awesomeplete"  id="purchaseorderid" name="purchaseorderid">
				</div>
			  </div>
			  <div class="item form-group">
				<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Release version</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <select class="form-control" id="release">
					<option value="">Choose option</option>
					<?php
						foreach($result[1] as $var) {
							echo "<option value=\"".$var."\">".$var."</option>";
						}
					?>
				  </select>
				</div>
			  </div>
			  <div class="item form-group">
				<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Change Request / Tech Refresh No.</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <select class="form-control" id="crtrno">
					<option value="">Choose option</option>
					<?php
						foreach($result[2] as $var) {
							echo "<option value=\"".$var."\">".$var."</option>";
						}
					?>
				  </select>
				</div>
			  </div>
			  <div class="item form-group">
				  <label class="control-label col-md 3 col-sm-3 col-xs-12">Expiry Date (MM/DD/YYYY)
				  </label>
				  <fieldset class="col-md-6 col-sm-6 col-xs-12">
					  <div class="control-group">
						<div class="controls">
						  <div class="xdisplay_inputx form-group">
						  
							<input type="text" class="form-control" id="single_cal3" aria-describedby="inputSuccess2Status4">
							
							<span id="inputSuccess2Status4" class="sr-only">(success)</span>
						  </div>
						</div>
					  </div>
					</fieldset>
				</div>
			  <div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <a class="btn btn-default" href="downloadreport.php?everything=1"><i class="fa fa-download"></i> Download Full Asset Register</a>
				  <button type="submit" class="btn btn-success">Submit</button>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<!-- /page content -->

<?php include 'components/footer.php';?>
<script>
$('#purchaseorderid').autocomplete({
	//Lookup helper for Purchase order ID
	lookup: purchaseorderid,
	onSelect: function () {
	$('#purchaseorderid').trigger('keyup');
}
});

//Whenever a field is changed, disable the other fields
$("#purchaseorderid").keyup(function () {
	$('#crtrno').val("");
	$('#release').val("");
	$('#single_cal3').val("");

	$('#crtrno').removeAttr('name');
	$('#release').removeAttr('name');
	$('#single_cal3').removeAttr('name');

	$('#purchaseorderid').attr('name', 'purchaseorderid');
});

$("#release").change(function () {
	$('#purchaseorderid').val('');
	$('#crtrno').val("");
	$('#single_cal3').val("");

	$('#purchaseorderid').removeAttr('name');
	$('#crtrno').removeAttr('name');
	$('#single_cal3').removeAttr('name');

	$('#release').attr('name', 'release');
});

$("#crtrno").change(function () {
	$('#purchaseorderid').val('');
	$('#release').val("");
	$('#single_cal3').val("");
	
	$('#purchaseorderid').removeAttr('name');
	$('#release').removeAttr('name');
	$('#single_cal3').removeAttr('name');
	
	$('#crtrno').attr('name', 'crtrno');
});

$("#single_cal3").change(function () {
	$('#purchaseorderid').val('');
	$('#crtrno').val("");
	$('#release').val("");

	$('#purchaseorderid').removeAttr('name');
	$('#crtrno').removeAttr('name');
	$('#release').removeAttr('name');

	$('#single_cal3').attr('name', 'expirydate');
});


</script>
<?php include 'components/closing.php';?>