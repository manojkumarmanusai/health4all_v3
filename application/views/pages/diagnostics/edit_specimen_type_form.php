<style type="text/css">
	table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  font-family: sans-serif;
  font-size: 16px;
  text-align: left;
}

th {
  background-color: #e4e4e7;
  font-weight: bold;
  padding: 12px 15px;
}

td {
  padding: 12px 15px;
  border-bottom: 1px solid #dddddd;
}

/* Odd rows (default or explicit background) */
tbody tr:nth-child(odd) {
  background-color: #ffffff;
}

/* Even rows (alternate background) */
tbody tr:nth-child(even) {
  background-color: #f8f9fa;
}

/* Hover state on body rows */
tbody tr:hover {
  background-color: #f1f3f5;
}

</style>
<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
<center><h3>Edit Specimen Type</h3></center><br>
<?php echo form_open('diagnostics/edit/specimen_type', array('role' => 'form')); ?>

    <div class="form-group">
        <label for="specimen_type" class="col-md-4">Specimen Type<font color='red'>*</font></label>
        <div class="col-md-8">
            <input type="text" class="form-control" placeholder="Specimen Type" id="specimen_type" name="specimen_type" 
                value="<?php echo isset($specimen_types[0]->specimen_type) ? $specimen_types[0]->specimen_type : ''; ?>" 
            />
            <?php if(isset($specimen_types[0])) { ?>
                <input type="hidden" value="<?php echo isset($specimen_types[0]->specimen_type_id) ? $specimen_types[0]->specimen_type_id : $specimen_types[0]->speciment_type_id; ?>" name="specimen_type_id" />
            <?php } ?>
        </div>
    </div>
    <div class="col-md-3 col-md-offset-4">
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
    </div>
</form>
<?php } ?>
	
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('diagnostics/edit/specimen_type',array('role'=>'form','id'=>'specimen_type_form','class'=>'form-inline','name'=>'search_specimen_type'));?>
	<h3> Search Specimen Type</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Specimen Type" id="specimen_type" name="specimen_type"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Specimen Types </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered col-md-10">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Specimen Types</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $j = 1;
  foreach ($specimen_types as $tg) { 
    // Ensure you use the exact database field name (e.g. specimen_type_id)
    $id = isset($tg->specimen_type_id) ? $tg->specimen_type_id : $tg->speciment_type_id;
  ?>
    <tr onclick="$('#specimen_type_form_<?php echo $id; ?>').submit();" style="cursor: pointer;">
      <td><?php echo $j++; ?></td>
      <td>
        <?php echo $tg->specimen_type; ?>
        <?php echo form_open('diagnostics/edit/specimen_type', array('id' => 'specimen_type_form_' . $id, 'role' => 'form')); ?>
          <input type="hidden" value="<?php echo $id; ?>" name="specimen_type_id" />
          <input type="hidden" value="select" name="select" />
        </form>
      </td>
    </tr>
  <?php } ?>
</tbody>
</table>
		<?php } ?>
</div>
</div>