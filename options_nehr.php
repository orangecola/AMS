<?php 
	include('components/config.php');
	$options = ['status', 'vendor', 'procured_from', 'shortname', 'purpose', 'contracttype', 'releaseversion', 'class', 'brand', 'currency'];
	$result = $user->getOptions('nehr_Options', $options);

	$optionheaders = [
		'Status',
		'Vendors (Software)',
		'Procured From (Software)',
		'Shortname (Software)',
		'Purpose (Software)',
		'Contract type (Software)',
		'Release Version',
		'Class (Hardware)',
		'Brand (Hardware)',
		'Currency'
	];
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['add'])) {
				$user->addOption('nehr_Options', $_POST['add'], $_POST['value']);
			}
			else if (isset($_POST["delete"])) {
				$user->deleteOption('nehr_Options', $_POST["delete"]);
			}
        $result = $user->getOptions('nehr_Options', $options);
	}
	
	include('components/sidebar.php')
?>
<script>
	document.getElementById('options_nehr.php').setAttribute("class", "current-page");
</script>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>NEHR Asset Management Options </h3>
	  </div>
	</div>
	<div class="clearfix"></div>
	<?php foreach ($options as $header=>$option) {
		echo '
	  <div class="col-md-4 col-sm-6 col-xs-12">
		<div class="x_panel" style="height: auto;">
		  <div class="x_title">
			<h2>'.$optionheaders[$header].'</h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			  </li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content" style="display: none;">
			<table id="datatable" class="table table-striped table-bordered">
			  <thead>
				  <tr>
				  <th>Field</th>
				  <th>Option</th>
				</tr>
			  </thead>
			
			<tbody>
				'; 
				foreach($result[$option] as $row) {
				echo '<tr>';
				echo '<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">';
				echo '<td>'.$row['nehr_Options_Name'].'</td>';
				echo '<input type="hidden" name="delete" value="'.$row['nehr_Options_Id'].'">';
				echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button></td>';
				echo '</form>';
				echo '</tr>';
				};
			echo '
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
				<td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="value"></td>
				<input type="hidden" name="add" value="'.$option.'">
				<td><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-save"></i> Add</button></td>
			</form>
			</tr>
			</tbody>
			</table>
		  </div>
		</div>
	</div>';
	};
?>     
</div>
</div>
<!-- /page content -->

<?php
	include 'components/footer.php';
	include 'components/closing.php';
?>