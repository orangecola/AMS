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
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		do {
			$purchaseorder = $user->getPurchaseOrder($_POST['purchaseorderid']);
			if(!$purchaseorder['validation']) {
				break;
			}
			if ($_FILES['file']['size'] > 0 && $_POST['action'] == 'upload') {
				$user->savePurchaseOrderFile($purchaseorder, $_FILES['file']);
			}
			
			if ($_POST['action'] == 'delete') {
				$user->deletePurchaseOrderFile($purchaseorder['purchaseorder_id']);
			}
		} while (false);
	}
	
    include('components/sidebar.php')
?>
<script>
	document.getElementById('purchaseorder.php').setAttribute("class", "current-page");
	var purchaseorderid = <?php echo json_encode($result[0]); ?>;
</script>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>Purchase Orders</h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		

	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>View / Edit Purchase Orders</h2>
			
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">

			<br />
			<form id="demo-form2" class="form-horizontal form-label-left" method="post">
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order ID
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="input-group">
						<input type="text" class="form-control" id="purchaseorderid" name="purchaseorderid" value="<?php if (isset($_POST['purchaseorderid'])) {echo htmlentities($_POST['purchaseorderid']);}?>">
						<span class="input-group-btn">
							<button type="button" class="btn btn-primary" onclick="getpurchaseorder();">Go!</button>
						</span>
					</div>
				</div>
			</div>
			</form>
			<div id="purchaseorderdetails"></div>
		  </div>
		</div>
	  </div>
	</div>
	</div>
	</div>
<!-- /page content -->

<?php include 'components/footer.php'; ?>
<script>
	$('#purchaseorderid').autocomplete({
		lookup: purchaseorderid,
		onSelect: function () {
        $('#purchaseorderid').trigger('keyup');
    }
	});
	
	function getpurchaseorder() {
		var candidateid =  $('#purchaseorderid').val();
		
		if (candidateid == "") {
			candidateid = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();	
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("purchaseorderdetails").innerHTML = this.responseText;
				}
			};
			var params="purchaseorderid="
			params = params.concat(candidateid);
			xmlhttp.open("POST","getpurchaseorder.php",true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send(params);
		}
	};
	
	function savepurchaseorder(field) {
		field = encodeURIComponent(field);
		var candidateid =  encodeURIComponent($('#purchaseorderid').val());
		var value = encodeURIComponent($('#'.concat(field)).val());
		if (candidateid == "") {
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();	
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("purchaseorderdetails").innerHTML = this.responseText;
				}
			};
			var params="purchaseorderid="
			params = params.concat(candidateid);
			params = params.concat("&update=");
			params = params.concat(field);
			params = params.concat("&value=");
			params = params.concat(value);
			xmlhttp.open("POST","getpurchaseorder.php",true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send(params);
		}
	};
<?php
	if (isset($_POST['purchaseorderid'])) {
				echo 'getpurchaseorder()';
	}
?>
</script>
<?php require 'components/closing.php';?>