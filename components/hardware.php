  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Price<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="number" class="form-control col-md-7 col-xs-12" required="required" placeholder="Numbers only" name="price">
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Currency<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="currency">
		<option value="">Select Option</option>
		<?php 
			foreach($options['currency'] as $row) {
				echo '<option value="'.$row['nehr_Options_Name'].'">'.$row['nehr_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">IHiS Asset ID</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="IHiS_Asset_ID" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">CR359 / CR506</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="CR359" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>
    <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">CR560</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="CR560" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>
    <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">POST-CR560</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="POST-CR560" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Class<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="class" >
		<option value="">Select Option</option>
		<?php 
			foreach($options['class'] as $row) {
				echo '<option value="'.$row['nehr_Options_Name'].'">'.$row['nehr_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Brand<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="brand" >
		<option value="">Select Option</option>
		<?php 
			foreach($options['brand'] as $row) {
				echo '<option value="'.$row['nehr_Options_Name'].'">'.$row['nehr_Options_Name'].'</option>';
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
	<label class="control-label col-md-3 col-sm-3 col-xs-12" >Component<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" class="form-control col-md-7 col-xs-12 required"  name="component" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Label<span class="required">*</span></label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="label" class="form-control col-md-7 col-xs-12 required" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Serial<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="serial" class="form-control col-md-7 col-xs-12 requried" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Location<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="location" class="form-control col-md-7 col-xs-12 required" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">RMA</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="replacing" id="replacing" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Excel Sheet</label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="excelsheet" class="form-control col-md-7 col-xs-12" >
	</div>
  </div>