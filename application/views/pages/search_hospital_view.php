<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >


<style>
  /* .table thead {position: relative;} */

    /* .table thead{
		
    } */
</style>


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
    height: 34px;
    padding: 6px 12px;
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
}
.rows_per_page:focus{
    border-color: #66afe9;
    outline: 0;	
}
</style>

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
	var selectizes = {};
	function initDistrictSelectize(){
        var districts = JSON.parse(JSON.stringify(<?php echo json_encode($districts); ?>));
		selectizes['district'] = $('#district_id').selectize({
			valueField: 'district_id',
			labelField: 'custom_data',
			searchField: ['district','district_alias','state'],
			options: districts,
			create: false,
			render: {
				option: function(item, escape) {
					return '<div>' +
						'<span class="title">' +
							'<span class="prescription_drug_selectize_span">'+escape(item.custom_data)+'</span>' +
						'</span>' +
					'</div>';
				}
			},
			load: function(query, callback) {
				if (!query.length) return callback();
			},

		});
	}	

	function initHospitalSelectize(){
        var hospitals = JSON.parse(JSON.stringify(<?php echo json_encode($hospitals); ?>));
		selectizes['hospital'] = $('#hospital').selectize({
			valueField: 'hospital',
			labelField: 'hospital',
			searchField: ['hospital'],
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
			},

		});
	}	

	function initHospitalShortNameSelectize(){
        var hospitals = JSON.parse(JSON.stringify(<?php echo json_encode($hospitals); ?>));
		selectizes['hospital_short_name'] = $('#hospital_short_name').selectize({
			valueField: 'hospital_short_name',
			labelField: 'hospital_short_name',
			searchField: ['hospital_short_name'],
			options: hospitals,
			create: false,
			render: {
				option: function(item, escape) {
					return '<div>' +
						'<span class="title">' +
							'<span class="prescription_drug_selectize_span">'+escape(item.hospital_short_name)+'</span>' +
						'</span>' +
					'</div>';
				}
			},
			load: function(query, callback) {
				if (!query.length) return callback();
			},

		});
	}	

	$(document).ready(function(){
		initDistrictSelectize();
        initHospitalSelectize();
		initHospitalShortNameSelectize();
		var filter_values = JSON.parse(JSON.stringify(<?php echo json_encode($filter_values); ?>)); 
		var dropdowns = ['district','hospital','hospital_short_name'];
		console.log(filter_values);
		Object.keys(filter_values).forEach((name) => {
			const value = filter_values[name];
			if(dropdowns.includes(name)){
				selectizes[name][0].selectize.setValue(value);
			} else {
				$('[name="'+name+'"]').val(value);
			}
		});
	});
</script>

<script type="text/javascript">

function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no");	
  	page_no_hidden.value=page_no; 
        $('#search_hospital').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
	
</script>



<?php $page_no = 1; ?>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Search Hospital</h4>	
		</div>
		<div class="panel-body">
        <?php echo form_open('hospital/search_hospital',array('class'=>'form-group','role'=>'form','id'=>'search_hospital')); ?>
		<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
		<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
                            <label class="Inputhospital">Hospital Name</label>
                            <select id="hospital" name="hospital" style=" display: inline-grid;" placeholder="Enter Hospital Name" size/>   
								<option value="">   --Enter Hospital Name--   </option>
								<input type='hidden' name='inputhospital' id='inputhospital' class='form-control'/>
							</select>
						</div>
                        </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
						<label class="Inputhospital_short_name">Hospital Short Name</label>
                            <select id="hospital_short_name" name="hospital_short_name" style=" display: inline-grid;" placeholder="Enter Hospital short Name" size/>   
								<option value="">   --Enter Hospital Short Name--   </option>
								<input type='hidden' name='hospital_id_short' id='inputhospital_short_name' class='form-control'/>
							</select>
						</div>
                        </div>
				

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">		
						<div class="form-group">
							<label class="Inputdistrict">  District    </label>
							<select id="district_id"  name="district" style=" display: inline-grid;" placeholder="Enter district" <?php if($field->mandatory) echo "required"; ?>>
								<option value="">   --Enter district--   </option>
								<input type='hidden' name='district_id' id='district_id_val' class='form-control'/>
							</select>
						</div>
					</div>
				</div>
                <br>

                <div class="row">
				    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype1">Type1</label>
								<select class="form-control" name="type1">
									<option value="" selected="selected">select</option>
									<option value="Private">Private</option>
									<option value="Public">Public</option>
									<option value="Non-profif">Non-Profit</option>
								</select>
							</div>	
					</div>
				    
	
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="Inputtype2" >Type2</label>
							<select class="form-control" name="type2">
								<option value="" selected="selected">select</option>
								<option value="State Govt.">State Government</option>
								<option value="Central Govt.">Central Government</option>
							</select>
						</div>	
					</div>

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="Inputtype3" >Type3</label>
							<select class="form-control" name="type3">
								<option value="" selected="selected">select</option> 
								<option value="Teaching">Teaching</option>
								<option value="Non-Teaching">Non-Teaching</option>
							</select>
						</div>	
					</div>
                </div>
                <br>
                
                <div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype4">Type4</label>
								<select class="form-control" name="type4">
									<option value="" selected="selected">select</option>
									<option value="District">District</option>
									<option value="Area">Area</option>
									<option value="CHC">CHC</option>
									<option value="PHC">PHC</option>
									<option value="Sub">Sub Centre</option>
								</select>
							</div>	
						</div>
				    

				    
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype5">Type5</label>
								<select class="form-control" name="type5">
									<option value="" selected="selected">select</option>
									<option value="Urban">Urban</option>
									<option value="Rural">Rural</option>
								</select>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype6">Type6</label>
								<select class="form-control" name="type6">
									<option value="" selected="selected">select</option>
									<option value="DME">DME</option>
									<option value="VVP">VVP</option>
									<option value="DH">DH</option>
								</select>
							</div>	
						</div>
				</div>
        </div>
		Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" style="width:50px; margin-bottom:5px;" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 

		<div class="panel-footer">
			<div class="text-center">

			<input class="btn btn-sm btn-primary" name="search_hospital" type="submit" value="Search" />
			</div>

			<!-- <input class="btn btn-sm btn-primary"  name="search_hospital_val" type="submit" value="Submit" /> -->

			</form>
		</div>
	</div>
	
	<?php 
	// if(count($results)!=0){
	// 	echo "No Hospitals Found";
	// }

	if(isset($results) && count($results)>0){ ?>
<h5>Data as on <?php echo date("j-M-Y h:i A"); ?></h5>
<?php 
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
	$total_records = $results_count[0]->count;
	//$total_records = 63;

	//$total_records = count($results);
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages == 0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>

<ul class="pagination" style="margin:0">
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

</div>

<table class="table table-bordered table-striped " id="table-sort">

<thead>

	  <th>SNo</th>
		<th >Hospital Name</th>
		<th>Hospital Short Name</th>
		<th>District</th>
		<th>Type1</th>
		<th>Type2</th>
		<th>Type3</th>
		<th>type4</th>
		<th>Type5</th>
		<th>Type6</th>
		<th>Action</th>

</thead>
	<tbody>
	<?php
	//print_r($results);
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 
		foreach($results as $hospital){
	 ?>
  <tr>
  <td><?php echo $sno;?></td>
   <td><?php echo $hospital->hospital; ?></td>
   <td><?php echo $hospital->hospital_short_name; ?></td>
   <td><?php echo $hospital->district; ?></td>
   <td><?php echo $hospital->type1; ?></td>
   <td><?php echo $hospital->type2; ?></td>
   <td><?php echo $hospital->type3; ?></td>
   <td><?php echo $hospital->type4; ?></td>
   <td><?php echo $hospital->type5; ?></td>
   <td><?php echo $hospital->type6; ?></td>
   <td><a class="btn btn-outline-success" href="<?php echo base_url() ?>hospital/add_hospital?hospital_id=<?php echo $hospital->hospital_id; ?>" style="color:#428bca;"> Edit</a></td>
                    
  </tr>
  <?php $sno++;}?>
  </tbody>
</table>

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
	<?php } else { ?>
	
	No hospitals Found.
<?php }  ?>
</div>

	
	  
	




   