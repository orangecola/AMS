<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Asset ID <span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" pattern="[a-zA-Z0-9]+" placeholder="Alphanumeric" class="form-control col-md-7 col-xs-12 required"  name="assetid">
	</div>
  </div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Description<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <textarea class="form-control col-md-7 col-xs-12 required" placeholder="Maximum 2000 Characters" maxlength="2000" name="description"></textarea>
	</div>
  </div>					  
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Quantity<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="number" class="form-control col-md-7 col-xs-12 required" placeholder="Numbers only" name="quantity">
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Price<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="number" class="form-control col-md-7 col-xs-12 required" placeholder="Numbers only" name="price">
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Currency<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="currency">
		<?php 
			foreach($options['currency'] as $row) {
				echo '<option value="'.$row['nehr_Options_Name'].'">'.$row['nehr_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Change Request / Tech Refresh Number<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" pattern="[a-zA-Z0-9]+" placeholder="Alphanumeric" name="crtrno" class="form-control col-md-7 col-xs-12 required">
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Purchase Order ID<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" pattern="[a-zA-Z0-9]+" placeholder="Alphanumeric" name="pono" class="form-control col-md-7 col-xs-12 required">
	</div>
  </div>
  <div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Release version<span class="required">*</span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="release">
		<option value="">Select Option</option>
		<?php 
			foreach($options['releaseversion'] as $row) {
				echo '<option value="'.$row['nehr_Options_Name'].'">'.$row['nehr_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
  <div class="item form-group">
  <label class="control-label col-md 3 col-sm-3 col-xs-12">Expiry Date (MM/DD/YYYY)<span class="required">*</span>
  </label>
  <fieldset class="col-md-6 col-sm-6 col-xs-12">
	  <div class="control-group">
		<div class="controls">
		  <div class="xdisplay_inputx form-group">
		  
			<input type="text" class="form-control required" id="single_cal3" name="expirydate" aria-describedby="inputSuccess2Status4">
			
			<span id="inputSuccess2Status4" class="sr-only">(success)</span>
		  </div>
		</div>
	  </div>
	</fieldset>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span></label>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="status">
		<option value="">Select Option</option>
		<?php 
			foreach($options['status'] as $row) {
				echo '<option value="'.$row['nehr_Options_Name'].'">'.$row['nehr_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Remarks</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <textarea class="form-control col-md-7 col-xs-12" placeholder="Maximum 2000 Characters" maxlength="2000" name="remarks"></textarea>
	</div>
  </div>