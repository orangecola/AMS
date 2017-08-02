<?php 
	include_once('components/config.php');
	if(!($_SESSION['role'] == 'admin'))
		  {
			 header('Location: logout.php');
		  }
	include('components/sidebar.php');

	$result = $user->getUsers();
?>
<script>
document.getElementById('userlist.php').setAttribute("class", "current-page");
</script>
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
		  <h2>View Users</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable" class="table table-striped table-bordered">
			  <thead>
				<tr>
				  <th>Username</th>
				  <th>Role</th>
				  <th>Status</th>
				  <th>Actions</th>
				</tr>
			  </thead>
			  <tbody>
				<?php 
					foreach($result as $row) {
						echo '<tr>';
						echo "<td>".htmlentities($row['username'])	."</td>";
						echo "<td>".htmlentities($row['role'])		."</td>";
						echo "<td>".htmlentities($row['status'])	."</td>";
						echo "<td><a href=\"edituser.php?id=".htmlentities($row['user_ID'])."\" class=\"btn btn-info btn-xs\"><i class='fa fa-edit'></i>Edit</a></td>";
						echo '</tr>';
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
	include 'components/footer.php';
	include 'components/datatables.php';
	include 'components/closing.php';
?>