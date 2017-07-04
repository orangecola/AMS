<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Class</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="class" >
		<option value="">Select Option</option>
		<?php 
			foreach($options['class'] as $row) {
				echo '<option value="'.$row['class_name'].'">'.$row['class_name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Brand</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="brand" >
		<option value="">Select Option</option>
		<?php 
			foreach($options['brand'] as $row) {
				echo '<option value="'.$row['brand_name'].'">'.$row['brand_name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Audit Date</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" class="form-control col-md-7 col-xs-12"  name="auditdate" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" >Component</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" class="form-control col-md-7 col-xs-12"  name="component" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Label</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="label" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Serial</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="serial" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Location</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="location" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">RMA</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="replacing" id="replacing" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>