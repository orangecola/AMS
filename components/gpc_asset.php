<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Environment<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="gpc_Environment">
		<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_Environment'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
  </div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Tier<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<select class="form-control required" name="gpc_Tier">
			<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_Tier'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Phase<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<select class="form-control required" name="gpc_Phase">
			<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_Phase'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Item (Backend Infrastructure)<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="gpc_Item">
		<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_Item'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="text" name="gpc_Remarks" class="form-control col-md-7 col-xs-12" placeholder="Maximum 2000 Characters">
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">AWS AMI<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="gpc_Ami">
		<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_Ami'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md 3 col-sm-3 col-xs-12">RI Invoked (MM-DD-YYYY)<span class="required">*</span>
	</label>
	<fieldset class="col-md-6 col-sm-6 col-xs-12">
	  <div class="control-group">
		<div class="controls">
		  <div class="xdisplay_inputx form-group">
			<input type="text" class="form-control" name="gpc_Startdate" id="single_cal4" aria-describedby="inputSuccess2Status4">
			<span id="inputSuccess2Status4" class="sr-only">(success)</span>
		  </div>
		</div>
	  </div>
	</fieldset>
</div>
<div class="item form-group">
	<label class="control-label col-md 3 col-sm-3 col-xs-12">Expiry Date (MM-DD-YYYY)<span class="required">*</span>
	</label>
	<fieldset class="col-md-6 col-sm-6 col-xs-12">
	  <div class="control-group">
		<div class="controls">
		  <div class="xdisplay_inputx form-group">
			<input type="text" class="form-control" name="gpc_Expirydate" id="single_cal3" aria-describedby="inputSuccess2Status4">
			<span id="inputSuccess2Status4" class="sr-only">(success)</span>
		  </div>
		</div>
	  </div>
	</fieldset>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">HA / LB required <span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <select class="form-control required" name="gpc_halb">
		<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_halb'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor">Quantity</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	  <input type="number" class="form-control col-md-7 col-xs-12 required" placeholder="Numbers only" name="gpc_quantity">
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">OS + Application (GB)<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="number" class="form-control required" name="gpc_Application" placeholder="Numbers only">
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Data (GB)<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="number "class="form-control required" name="gpc_Data" placeholder="Numbers only">
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">IOPS per Database Server<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="number" class="form-control required" name="gpc_IOPS" placeholder="Numbers only">
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Backup Volume (GB)<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<input class="form-control required" name="gpc_Backup" placeholder="Numbers only">
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">OS Spec Required<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<select class="form-control required" name="gpc_OS">
			<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_OS'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Number of Servers in Year 1 (Total Servers Required)<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="number" class="form-control required" name="gpc_Y1_Qt" placeholder="Numbers only">
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Number of Servers in Year 2 (Total Servers Required)<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<input type="number" class="form-control required" name="gpc_Y2_Qt" placeholder="Numbers only">
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Operating Requirements (Year 1)<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<select class="form-control required" name="gpc_Y1_Ops">
			<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_Ops'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">Operating Requirements (Year 2)<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<select class="form-control required" name="gpc_Y2_Ops">
			<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_Ops'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>
<div class="item form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12">GW / GC<span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<select class="form-control required" name="gpc_Gwgc">
			<option value="">Select Option</option>
		<?php 
			foreach($options['gpc_Gwgc'] as $row) {
				echo '<option value="'.$row['gpc_Options_Name'].'">'.$row['gpc_Options_Name'].'</option>';
			}
		?>
	  </select>
	</div>
</div>