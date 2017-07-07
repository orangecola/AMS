<?php 
	include_once('components/config.php');
	$Success=0;
	$User_Exists=0;
	
	if(!($_SESSION['role'] == 'admin'))
	  {
		 header('Location: logout.php');
	  }
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		
		
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$role = $_POST['role'];
		
		$result = $user->check($_POST['username']);
		if ($result) {
			$user->register($username, $password, $role);
			$Success = 1;
			//$user->log();
		}
		else {
			$User_Exists = 1;
		}
	}
	include('components/sidebar.php');
?>  

<script>
	document.getElementById('addpurchaseorder.php').setAttribute("class", "current-page");
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
			<h2>Add Purchase Order</h2>
			
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
		  <?php if ($User_Exists == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> Username already exists
		  </div>';} 
		  
		  if ($Success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Success</strong> User created successfully
		  </div>';}
		  ?>
			<br />
			<form id="demo-form2" enctype="multipart/form-data" class="form-horizontal form-label-left" method="post">
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Purchase Order ID <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="orderid" class="form-control col-md-7 col-xs-12 required"  name="orderid">
				</div>
			  </div>	
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Vendor <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="vendor" class="form-control col-md-7 col-xs-12 required"  name="vendor">
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order File
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="price" name="price" class="form-control col-md-7 col-xs-12 required">
				</div>
			  </div>
			  <div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <button class="btn btn-primary" type="reset">Reset</button>
				  <button type="submit" class="btn btn-success">Submit</button>
				</div>
			  </div>

			</form>
		  </div>
		</div>
	  </div>
	</div>

	
<!-- /page content -->

<?php 
	include 'components/footer.php';
	include 'components/closing.php';
?>