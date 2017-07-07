<?php 
	include('components/config.php');
    $result = $user->getOptions();
	$options = $user->options;
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
		'Location (Hardware)',
		'Servers to Monitor',
		'Currency'
	];
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		foreach($options as $option) {
			if (isset($_POST[$option])) {
				$user->addOption($option, $_POST[$option]);
			}
			else if (isset($_POST["{$option}delete"])) {
				$user->deleteOption($option, $_POST["{$option}delete"]);
			}
		}
        $result = $user->getOptions();
	}
	
	include('components/sidebar.php')
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="page-title">
	  <div class="title_left">
		<h3>Asset Management Options </h3>
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
				echo '<td>'.$row[$option.'_name'].'</td>';
				echo '<input type="hidden" name="'.$option.'delete" value="'.$row[$option.'_id'].'">';
				echo '<td><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</button></td>';
				echo '</form>';
				echo '</tr>';
				};
			echo '
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post">
				<td><input type="text" placeholder="Field to add" required="required" class="form-control"  name="'.$option.'"></td>
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
<!-- /page content -->

<?php
	include 'components/footer.php';
	include 'components/closing.php';
?>