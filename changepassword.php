<?php 
	include('components/config.php');
	$wrongPassword = 0;
	$Success = 0;
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$oldpassword = $_POST['oldpassword'];
		$newpassword = $_POST['newpassword'];
		
		if ($user->checkPassword($oldpassword)) {
			$user->changePassword($newpassword);
			$Success = 1;
		} else {
			$wrongPassword = 1;
		}
	}
	include('components/sidebar.php')
?>  

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>User Management</h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Change Password</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
		  <?php if ($wrongPassword == 1) {echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Error</strong> Old password is incorrect
		  </div>';} 
		  
		  if ($Success == 1) {echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<strong>Success</strong> Password changed successfully
		  </div>';}
		  ?>
			<br />
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">

			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current Password <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="password" id="oldpassword" required="required" class="form-control col-md-7 col-xs-12"  name="oldpassword">
				</div>
			  </div>
			  <div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">New Password <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="password" id="newpassword" required="required" name="newpassword" data-validate-length-range="6" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  <div class="item form-group">
				<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="required">*</span></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input id="password2" class="form-control col-md-7 col-xs-12" type="password" required="required" data-validate-linked="newpassword">
				</div>
			  </div>
			  <div class="item form-group">
				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				  <button class="btn btn-primary" type="button">Cancel</button>
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