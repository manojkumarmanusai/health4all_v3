<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script type="text/javascript">
$(function(){
		var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: [ 'default', 'zebra', 'print', 'stickyHeaders','filter'],

			widgetOptions: {

		  print_title      : 'table',          // this option > caption > table id > "table"
		  print_dataAttrib : 'data-name', // header attrib containing modified header name
		  print_rows       : 'f',         // (a)ll, (v)isible or (f)iltered
		  print_columns    : 's',         // (a)ll, (v)isible or (s)elected (columnSelector widget)
		  print_extraCSS   : '.table{border:1px solid #ccc;} tr,td{background:white}',          // add any extra css definitions for the popup window here
		  print_styleSheet : '', // add the url of your print stylesheet
		  // callback executed when processing completes - default setting is null
		  print_callback   : function(config, $table, printStyle){
			// do something to the $table (jQuery object of table wrapped in a div)
			// or add to the printStyle string, then...
			// print the table using the following code
			$.tablesorter.printTable.printOutput( config, $table.html(), printStyle );
			},
			// extra class name added to the sticky header row
			  stickyHeaders : '',
			  // number or jquery selector targeting the position:fixed element
			  stickyHeaders_offset : 0,
			  // added to table ID, if it exists
			  stickyHeaders_cloneId : '-sticky',
			  // trigger "resize" event on headers
			  stickyHeaders_addResizeEvent : true,
			  // if false and a caption exist, it won't be included in the sticky header
			  stickyHeaders_includeCaption : false,
			  // The zIndex of the stickyHeaders, allows the user to adjust this to their needs
			  stickyHeaders_zIndex : 2,
			  // jQuery selector or object to attach sticky header to
			  stickyHeaders_attachTo : null,
			  // scroll table top into view after filtering
			  stickyHeaders_filteredToTop: true,

			  // adding zebra striping, using content and default styles - the ui css removes the background from default
			  // even and odd class names included for this demo to allow switching themes
			  zebra   : ["ui-widget-content even", "ui-state-default odd"],
			  // use uitheme widget to apply defauly jquery ui (jui) class names
			  // see the uitheme demo for more details on how to change the class names
			  uitheme : 'jui'
			}
		  };
			$("#table-sort").tablesorter(options);
		  $('.print').click(function(){
			$('#table-sort').trigger('printTable');
		  });
});
</script>
<script>
$(function(){
	$(".update_all").click(function(){
		if($(this).is(":checked"))
			$(".update").prop('checked',true);
		else
			$(".update").prop('checked',false);
	});
	$(".reports_all").click(function(){
		if($(this).is(":checked"))
			$(".reports").prop('checked',true);
		else
			$(".reports").prop('checked',false);
	});
});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
	initHospitalSelectize();
});
</script>
<style type="text/css">
.page_dropdown{
    position: relative;
    float: left;
    padding: 6px 12px;
    width: auto;
    height: 34px;
    line-height: 1.428571429;
    text-decoration: none;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    margin-left: -1px;
    color: #428bca;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    display: inline;
}
.page_dropdown:hover{
    background-color: #eeeeee;
    color: #2a6496;
 }
.page_dropdown:focus{
    color: #2a6496;
    outline:0px;	
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.rows_per_page{
    display: inline-block;
    font-size: 14px;
    line-height: 1.428571429;
    color: #555555;
    vertical-align: middle;
    background-color: #ffffff;
    background-image: none;
    border: 1px solid #cccccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    text-align: -webkit-match-parent;
}
.rows_per_page:focus{
    border-color: #66afe9;
    outline: 0;	
}
/* Sets a fixed or max width for the Selectize control and its dropdown menu */
.selectize-control {
    width: 300px !important;       /* Adjust to your preferred width (e.g., 200px, 250px) */
    display: inline-block !important;
    vertical-align: middle;
}

/* Ensures the dropdown list matches the control width */
.selectize-dropdown {
    width: auto !important;
    min-width: 300px !important;
}
</style>
<script type="text/javascript">
var selectizes = {};

function doPost(page_no){
    var page_no_hidden = document.getElementById("page_no");
    page_no_hidden.value=page_no;
    $('#search_user').submit();
}

function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}

function initHospitalSelectize(){
    var hospitals = JSON.parse(JSON.stringify(<?php echo json_encode($hospitals); ?>));
    
    // 1. Initialize Selectize and assign jQuery object
    var $select = $('#hospital').selectize({
        valueField: 'hospital_id',
        labelField: 'hospital',
        searchField: ['hospital','hospital_short_name'],
        options: hospitals,
        create: false,
        render: {
            option: function(item, escape) {
                return '<div>' +
                    '<span class="title">' +
                        '<span class="prescription_drug_selectize_span">'+escape(item.hospital)+'</span>' +
                    '</span>' +
                '</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
        }
    });

    // 2. Extract the actual Selectize control instance
    selectizes['hospital'] = $select[0].selectize;

    // 3. Call setValue on the valid Selectize instance
    <?php 
    $selected_hospital = $this->input->post('hospital_id');
    if (!empty($selected_hospital)): 
    ?>
        selectizes['hospital'].setValue('<?php echo addslashes($selected_hospital); ?>');
    <?php endif; ?>
}
</script>
<?php $page_no = 1;	?>
    <div class="row col-md-offset-2">
    <h3>User Helpline Link</h3>
    <?php 
    echo form_open('user_panel/helpline_access',array('role'=>'form','class'=>'form-custom',
        'id'=>'search_user')); 
     ?>
      <input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
	  Hospital:  <select id="hospital" name="hospital_id" style=" display: inline-grid;" placeholder="Enter Hospital Name" size/>   
								<option value="">   --Enter Hospital Name--   </option>
							</select>
     User Name: <input type="text" class="form-control" placeholder="User Name"  style="width:120px"  value="<?php echo $this->input->post('staff_user_name');?>" name="staff_user_name" />
     Phone: <input type="text" class="form-control" placeholder="Phone"  style="width:120px"  value="<?php echo $this->input->post('phone');?>" name="phone" />
	 Active Status: <select name="status" id="status" class="form-control">
    			<option value="">Select</option>   
                        <option value="Yes" <?php echo ($this->input->post('status') == 'Yes') ? 'selected' : ''; ?> >Yes</option> 
                        <option value="No" <?php echo ($this->input->post('status') == 'No') ? 'selected' : ''; ?> >No</option>          
                        </select>
	<br/>					
	 Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
      <input type="submit" value="Search" name="submitBtn" class="btn btn-primary btn-sm" /> 
     </form>
</div>
<?php if(isset($mode)&& $mode=="select" || $this->input->post('update')){?>
<center> <h3> Update Helpline Access</h3></center><br>
<?php echo validation_errors(); echo form_open('user_panel/helpline_access',array('role'=>'form','id'=>'user')); ?>

<div class="row col-md-offset-2">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php
	}
	?>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Update Helpline Access</h4>
		</div>
		<div class="panel-body">
				<p class="lead">User details</p>	
					<div class="form-group col-md-12">
						<div class="col-md-4">
							<label for="name" class="control-label"><b>Username:</b></label>
							<?php if(isset($user)){
									echo $user[0]->username;
								}
							?>
							<input type="hidden" class="sr-only" name="user_id" value="<?php echo $user[0]->user_id; ?>" />
						</div>
						<div class="col-md-4">
							<label for="name" class="control-label"><b>Name:</b></label>
							<?php if(isset($user)){
									echo $user[0]->first_name." ".$user[0]->last_name;
								}
							?>
						</div>
						<div class="col-md-4">
							<label for="email" class="control-label"><b>Email:</b></label>
							<?php if(isset($user)){
									echo $user[0]->email;
								}
							?>
						</div>
						<div class="col-md-4">
							<label for="phone" class="control-label"><b>Phone</b></label>
							<?php if(isset($user)){
									echo $user[0]->phone;
								}
							?>
						</div>
						<div class="col-md-4">
							<label for="specialisation" class="control-label"><b>Specialisation:</b></label>
							<?php if(isset($user)){
									echo $user[0]->specialisation;
								}
							?>
						</div>
					</div>	
					</div>
					<div class="col-md-12">
						<table class="table table-bordered table-striped">
							<thead>
								<th>Helpline</th>
								<th>Note</th>
								<th>Reports</th>
								<th>Update</th>
							</thead>
							<tbody>
							<tr>
								<td>All</td>
								<td></td>
								<td><input type="checkbox" class="reports_all" value="reports_all" /></td>
								<td><input type="checkbox" class="update_all" value="update_all" /></td>
							</tr>
							<?php foreach($helpline_numbers as $number){
									$update="";
									$reports="";
								foreach($user_helpline as $u){
									if($u->helpline_id == $number->helpline_id){
										if($u->update_access==1) $update="checked"; 
										if($u->reports_access==1) $reports="checked";
									}
								}
							?>
								<tr>
									<td>
									<div data-toggle="popover" data-placement="bottom" data-content="<?php echo $f->description;?>">
										<?php echo $number->helpline;?>									  
									</div>
									<input type="checkbox" value="<?php echo $number->helpline_id;?>" name="user_helpline_access[]" class="sr-only" checked /></td>
									<td>										
										<?php echo $number->note;?>									  
									</td>
									<td><input type="checkbox" class="reports" name="<?php echo $number->helpline_id;?>[]" value="reports" <?php echo $reports;?>  /></td>
									<td><input type="checkbox" class="update" name="<?php echo $number->helpline_id;?>[]" value="update" <?php echo $update;?> /></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
		</div>
		
	</div>	
   	<div class="col-md-3 col-md-offset-4">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</form>
</div>
	<?php } 
	else{ ?>
	<div class="col-md-10 col-md-offset-2">
		<h3><?php if(isset($msg)) echo $msg;?></h3>	
		<?php  if(isset($user) && count($user)>0) { 
		
	if ($this->input->post('rows_per_page')){
		$total_records_per_page = $this->input->post('rows_per_page');
	}else{
		$total_records_per_page = $rowsperpage;
	}
	if ($this->input->post('page_no')) { 
		$page_no = $this->input->post('page_no');
	}
	else{
		$page_no = 1;
	}
	$total_records = $report_count[0]->count ;
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages == 0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>

<ul class="pagination" style="margin:0;">
<?php if($page_no > 1){
echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href=# onclick=doPost($previous_page)";

} ?>>Previous</a>
</li>
<?php
  if ($total_no_of_pages <= 10){  	 
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
        }
}
else if ($total_no_of_pages > 10){
	if($page_no <= 4) {			
 		for ($counter = 1; $counter < 8; $counter++){		 
		if ($counter == $page_no) {
	   		echo "<li class='active'><a>$counter</a></li>";	
		}else{
           		echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
}

echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $page_no - $adjacents;
     $counter <= $page_no + $adjacents;
     $counter++
     ) {		
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
          }                  
       }
echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
else {
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $total_no_of_pages - 6;
     $counter <= $total_no_of_pages;
     $counter++
     ) {
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
	}                   
     }
}
}  
?>
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href=# onclick=doPost($next_page)";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
} ?>
<?php if($total_no_of_pages > 0){
echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  echo "<option value=$counter ";
                  if ($page_no == $counter){
                   echo "selected";
                  }         
                  echo ">$counter</option>";
	}
echo "</select></li>";
} ?>
</ul>

<div style='padding: 0px 2px;'>
<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

	<h3 class="col-md-12">List of Users</h3>
	<div class="col-md-12 ">
	</div>	
		<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">S.no</th>
		<th style="text-align:center">Name</th>
		<th style="text-align:center">Primary Hospital</th> 
		<th style="text-align:center">Primary Department</th>
		<th style="text-align:center">Designation</th>
		<th style="text-align:center">User Name</th>
		<th style="text-align:center">Phone</th>
		<th style="text-align:center">Active</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($user as $a){ ?>
	<tr onclick="$('#select_user_edit_form_<?php echo $a->user_id;?>').submit();" >
		<td>	
			<?php echo form_open('user_panel/helpline_access',array('id'=>'select_user_edit_form_'.$a->user_id,'role'=>'form')); ?>
			<?php echo $i++; ?>
		</td>
		<td><?php echo $a->first_name." ".$a->last_name;  ?></td>
		<td><?php echo $a->staff_primary_hospital;?></td> 
		<td><?php echo $a->staff_primary_department;?></td>
		<td><?php echo $a->designation;?> </td>
		<td><?php echo $a->username; ?>
		<input type="hidden" value="<?php echo $a->user_id; ?>" name="user_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td>
			<?php echo $a->phone;?>
			</form>
		</td>
		<td><?php if($a->active==1) echo "Yes"; else echo "No";?></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	<?php } 
	 } ?>
	 <div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>

<ul class="pagination" style="margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 20px;
    margin-left: 0px;">
<?php if($page_no > 1){
echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href=# onclick=doPost($previous_page)";

} ?>>Previous</a>
</li>
<?php
  if ($total_no_of_pages <= 10){  	 
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
        }
}
else if ($total_no_of_pages > 10){
	if($page_no <= 4) {			
 		for ($counter = 1; $counter < 8; $counter++){		 
		if ($counter == $page_no) {
	   		echo "<li class='active'><a>$counter</a></li>";	
		}else{
           		echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
}

echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $page_no - $adjacents;
     $counter <= $page_no + $adjacents;
     $counter++
     ) {		
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
          }                  
       }
echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
else {
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $total_no_of_pages - 6;
     $counter <= $total_no_of_pages;
     $counter++
     ) {
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
	}                   
     }
}
}  
?>
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href=# onclick=doPost($next_page)";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
} ?>
<?php if($total_no_of_pages > 0){
echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  echo "<option value=$counter ";
                  if ($page_no == $counter){
                   echo "selected";
                  }         
                  echo ">$counter</option>";
	}
echo "</select></li>";
} ?>
</ul>
	</div></div>
