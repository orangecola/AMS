<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <title>NEHR AMS</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

  </head>

<?php 
	include('config.php');
	
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
	
?>  
  
  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <?php include('sidebar.php')?>
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
                    <form id="demo-form2" class="form-horizontal form-label-left" method="post" action="report.php">
					  <div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order ID
                        </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="input-group">
								<input type="text" class="form-control" id="purchaseorderid" name="purchaseorderid">
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

            
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- validator -->
    <script src="vendors/validator/validator.js"></script>
	<!-- jQuery autocomplete -->
    <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
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
	</script>
  </body>
</html>
