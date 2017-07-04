<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Vendor<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="vendor">
		<option value="">Select Option</option>
		<?php 
			foreach($options['vendor'] as $row) {
				echo '<option value="'.$row['vendor_name'].'">'.$row['vendor_name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Procured From<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="procure">
		<option value="">Select Option</option>
		<?php 
			foreach($options['procured_from'] as $row) {
				echo '<option value="'.$row['procured_from_name'].'">'.$row['procured_from_name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Short name<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="shortname">
		<option value="">Select Option</option>
		<?php 
			foreach($options['shortname'] as $row) {
				echo '<option value="'.$row['shortname_name'].'">'.$row['shortname_name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Purpose<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="purpose">
		<option value="">Select Option</option>
		<?php 
			foreach($options['purpose'] as $row) {
				echo '<option value="'.$row['purpose_name'].'">'.$row['purpose_name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Contract Type <span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="contracttype">
		<option value="">Select Option</option>
		<?php 
			foreach($options['contracttype'] as $row) {
				echo '<option value="'.$row['contracttype_name'].'">'.$row['contracttype_name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
  <label class="control-label col-md 3 col-sm-3 col-xs-12">Start Date <span class="required">*</span>
  </label>
  <fieldset class="col-md-6 col-sm-6 col-xs-12">
	  <div class="control-group">
		<div class="controls">
		  <div class="xdisplay_inputx form-group">
		  
			<input type="text" class="form-control" name="startdate" id="single_cal4" aria-describedby="inputSuccess2Status4">
			
			<span id="inputSuccess2Status4" class="sr-only">(success)</span>
		  </div>
		</div>
	  </div>
	</fieldset>
	</div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">License Explanation
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="license" class="form-control col-md-7 col-xs-12">
	</div>
  </div>