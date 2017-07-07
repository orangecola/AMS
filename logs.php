<?php 
	include_once('components/config.php');
	if(!($_SESSION['role'] == 'admin'))  {
		 header('Location: logout.php');
	}
	
	include('components/sidebar.php');
		
	$result = $user->getLog();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>View logs</h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
		  <h2>Logs</h2>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<table id="datatable" class="table table-striped table-bordered">
			  <thead>
				<tr>
				  <th>Time</th>
				  <th>User</th>
				  <th>Action</th>
				</tr>
			  </thead>


			  <tbody>
				<?php 
					foreach($result as $row) {
						echo '<tr>';
						echo "<td>{$row['time']}</td>";
						echo "<td>{$row['user']}</td>";
						echo "<td>{$row['log']}</td>";
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