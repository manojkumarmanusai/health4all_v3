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
	<center><h3>Edit Test Name </h3></center><br>
	<?php echo form_open('diagnostics/edit/test_name',array('role'=>'form')); ?>
		<div class="form-group">
		<label for="test_name" class="col-md-4">Test Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Test Name" id="test_name" name="test_name" 
		<?php if(isset($test_names)){
			echo "value='".$test_names[0]->test_name."' ";
			}
		?>
		/>
		<?php if(isset($test_names)) { ?>
		<input type="hidden" value="<?php echo $test_names[0]->test_master_id;?>" name="test_master_id" />
		
		<?php } ?>
		</div>
	</div>
   	<div class="col-md-3 col-md-offset-4">
	</br>
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</form>
	<?php } ?>
	
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('diagnostics/edit/test_name',array('role'=>'form','id'=>'test_name_form','class'=>'form-inline','name'=>'test_name'));?>
	<h3> Search Test Name</h3>
	<table>
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Test Name" id="test_name" name="test_name"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Test Names </h3>
	<?php echo form_open('diagnostics/edit/test_name', array('id' => 'master_test_form', 'style' => 'display:none;')); ?>
        <input type="hidden" name="test_master_id" id="master_test_id" value="" />
        <input type="hidden" name="select" value="select" />
    </form>
	<div class="col-md-12 ">
	</div>	
	<table>
	<thead>
	<th>S.No</th><th> Test Name</th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($test_names as $tg){ ?>

	<tr onclick="submitRow('<?php echo $tg->test_master_id; ?>')">
            <td><?php echo $j++; ?></td>
            <td><?php echo $tg->test_name; ?></td>
        </tr>
	
	<?php } ?>
	</tbody>
	</table>
		<?php } ?>
</div>
</div>

<script>
function submitRow(id) {
    $('#master_test_id').val(id);
    $('#master_test_form').submit();
}
</script>