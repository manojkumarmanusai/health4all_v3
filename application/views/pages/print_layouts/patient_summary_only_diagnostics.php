<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="all">
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>  
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
		
		
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<?php $patient=$patients[0];?>
		<style>
			@media all{
			table{
				font-family: "Trebuchet MS","Sans Serif", Serif;

			}
			tbody{
				border:1px solid #ccc;
			}
			td{
				padding:3px;
			}
			th{
				text-align:center;
			}
			table {
				border-collapse:collapse;
				border-spacing:0;
			}
			#table-prescription{
				width:100%;
				position:relative;
			}
			#table-prescription td, th{
				border:1px solid black;
				padding:3px;
			}
		}
		
		</style>
		<script type="text/javascript">
			$(function(){
				var settings = {
				barHeight: 20,
				fontSize: 20
				};
				$("#patient_barcode").barcode(
					"<?php echo $patient->patient_id;?>",
					"code128",
					settings
				);
			});
		</script>
		<table style="width:98%;padding:5px;">
				<tbody>
					<tr>
						<td colspan="3"> 
						<div style="float:left;text-align:left;left:auto;width:75%;">
							<?php if ($hospital['telehealth'] == "0") {?>
							<font size="4"><?php echo $hospital['hospital'];?></font><br />
								<?php if(!empty($hospital['description'])){ echo $hospital['description']."<br />"; }?>
								<!--<?php echo $hospital['place']; ?>, 
								<?php echo $hospital['district']; ?>-->
							<br />
							<?php } else {?>
							<?php if(!!$patient->doctor_name) {?> 
							<font size="4">Teleconsultation with <?php echo $patient->doctor_name; ?></font><br />
							<?php } else {?>
							<font size="4">Teleconsultation with Doctor</font><br />
							<?php } ?>
							
									<?php echo "Facilitated by  ".$hospital['hospital']."<br />";?>
								<?php if(!!$hospital['description']) echo $hospital['description']."<br />";?>
							<?php } ?>
						</div>			
						<div style="float:right;margin-right:10;margin-top:5px;">			
							<img src="<?php echo base_url()."assets/logos/".$hospital['logo'];?>" width="65px" height="65px" />
						</div>
						</td>
					</tr>
				<tr>
				<td colspan="3">
				<div style="float:middle;text-align:center;margin-top:-4%!important;">
				<span ><b>
					<?php if($patient->summary_header == 0) { ?> 
						<?php if($patient->visit_type == "OP") echo "CONSULTATION"; else echo "DISCHARGE";?> SUMMARY 
						<?php if(!empty($patient->visit_name)) { echo ' - '.$patient->visit_name; } ?></b></span>
					
					<?php  } else { ?>
					
					<?php  echo $patient->visit_name;?></b></span>
					 
					<?php  }?>
				</div>
				
				</td></tr>
				<tr>
				<td colspan="3"><?php $hospital=$this->session->userdata('hospital');?>
				<div style="float:left;text-align:left;left:auto;">
				<b><?php 
					if($patient->visit_type == "OP") 
						if($patient->summary_header == 1) {
							echo "Date:";
						} else {	
							echo "Consultation Date:"; 
						}
					else {
						echo "Admit Date:"; 
						
					     }
						?>  </b> <?php 
						if($patient->appointment_time === NULL){
						echo date("d-M-Y",strtotime($patient->admit_date)); echo " ".date("g:i A",strtotime($patient->admit_time));
						}else{
						echo date("d-M-Y", strtotime("$patient->appointment_time"))." ".date("h:i A", strtotime("$patient->appointment_time"));
						
						}
					
						?>
						<br/>
						<?php
					if($patient->visit_type != "OP"){ ?>
						<b> <?php if(!!$patient->outcome) echo $patient->outcome; else echo "Discharge"?> 
							Date:</b>
							<?php 
							if($patient->outcome_date != 0) echo date("d-M-Y",strtotime($patient->outcome_date)); 
							if($patient->outcome_time != 0) echo " ".date("g:i A",strtotime($patient->outcome_time)); 
					}
					
					?>
					
				</div>							
				<div style="float:right;">
				
				<span  id="patient_barcode"></span>
				<div id="barcode"></div>
				</div>
				<div style="float:right;">
				<b> Person ID: </b>
				</div>
				</td>
				</tr>
				</tbody>
				<tbody height="10%">
				<tr width="95%">
						<td style="padding-top:20px"><b>Name: </b><?php echo $patient->name; ?></td>
						<td style="padding-top:20px"><b>Age/Sex: </b><?php 
							if($patient->age_years!=0){ echo $patient->age_years." Yrs "; } 
							if($patient->age_months!=0){ echo $patient->age_months." Mths "; }
							if($patient->age_days!=0){ echo $patient->age_days." Days "; }
							if($patient->age_years==0 && $patient->age_months == 0 && $patient->age_days==0) echo "0 Days";
							echo "/".$patient->gender; ?></td>

						<td></td>
							
						
				</tr>
				<tr width="95%">
						<td><b>Father/Spouse: </b> <?php echo $patient->parent_spouse; ?></td>
						<td><b>Address:</b> <?php echo $patient->address." ".$patient->place; ?></td>
						<td></td>
				</tr>
				<tr width="95%">
						<td><b><?php echo $patient->visit_type;?> number : </b><?php echo $patient->hosp_file_no; ?></td>
						<td><b>Department : </b><?php echo $patient->department; ?> </td>
						<td><b>Phone : </b><?php echo $patient->phone; ?></td>
				</tr>
				</tbody>
				
				<?php 
				if(isset($tests) && count($tests)>0){ ?>				
				<tr  class="print-element" style="width:100%">
					<td colspan="3"><b><u>Diagnositcs</u></b><br></td>
				</tr>
				<?php
					$count=0;
					$text_result_tests=array();
					foreach($tests as $test){	
						if($test->text_result==1 && $test->numeric_result == 0 && $test->binary_result == 0) {
							$text_result_tests[] = $test;
							array_splice($tests,$count,1);
							$count--;
						}
						$count++;
					}
					if(count($text_result_tests)>0) { 
				?>
				<?php 
							$o=array();
							foreach($text_result_tests as $order){
								$o[]=$order->order_id;
							}
							$o=array_unique($o);
							$i=1;
							foreach($o as $ord){	?>
								<?php
								foreach($text_result_tests as $order) { 
									if($order->order_id == $ord) { ?>
									<tr class="print-element" width="95%" >
										<td colspan="3">
											<span style="float:right"><?php echo $order->order_date_time;?></span>
											<b>Test: </b> <?php echo $order->test_name;?><br />
											<b>Report: </b><?php if($order->test_status==2 && $order->text_result == 1) echo $order->test_result_text; else echo "NA";?>
										</td>
									</tr>
								<?php
								}
								} ?>
							<?php } ?>
				<?php } 
				if(count($tests)>0){?>
				
				<tr class="print-element" width="95%" >
					<td colspan="3">
					<br>
						<table id="table-prescription">
						<tbody>
							<tr>
							<td style="width:3em;font-weight: bold;">#</td>
							<td style="width:10em;font-weight: bold;">Order Date</td>
							<td style="width:10em;font-weight: bold;">Specimen</td>
							<td style="width:12em;font-weight: bold;">Test</td>
							<td style="width:18em;font-weight: bold;">Value</td>
							<td style="width:10em;font-weight: bold;">Normal Range</td>
							</tr>
							<?php 
							$o=array();
							foreach($tests as $order){
								$o[]=$order->order_id;
							}
							$o=array_unique($o);
							$i=1;
							foreach($o as $ord){	?>
								<?php
								foreach($tests as $order) { 
									if($order->order_id == $ord) {
										if($order->test_status != 2) {
											continue;
										} ?>
								<tr>
										<td><?php echo $i++;?></td>
										<td> 
											<?php echo date("j-M-Y", strtotime("$order->order_date_time"));?>
											</form>
										</td>
										<td><?php echo $order->specimen_type;?></td>
										<td>
										<?php
															if($order->test_status==1){
																$label="label-warning"; $status="Completed"; }
															else if($order->test_status == 2){ $label = "label-success"; $status = "Approved"; }
															else if($order->test_status == 0){ $label = "label-default"; $status = "Ordered"; }
															echo '<label class="label '.$label.'" title="'.$status.'">'.$order->test_name."</label><br />";									
											?>
										</td>
										<td>

										<?php
											$results = [];

										
												if ($order->numeric_result == 1) {
													$results[] = trim($order->test_result . ' ' . $order->lab_unit);
												}
												if ($order->binary_result == 1) {
													$results[] = $order->test_result_binary;
												}
												if ($order->text_result == 1) {
													$results[] = $order->test_result_text;
												}
											

											$validResults = array_filter($results);

											echo !empty($validResults) ? implode(', ', $validResults) : 'NA';
											?>
										</td>
										<td>
											<?php 
											$result = "";

											if ($order->range_type == 1) $result .= "< " . $order->max ." ". $order->lab_unit;
											else if ($order->range_type == 2) $result .= "> " . $order->min ." ". $order->lab_unit;
											else if ($order->range_type == 3) $result .= $order->min . " - " . $order->max ." ". $order->lab_unit;
											else if($order->range_type == 4) $result .= $order->range_text;
                                
                                			echo $result;
											
											?>
										</td>
								</tr>
								<?php
								}
								} ?>
							<?php } ?>
						</tbody>
						</table>	
					</td>
				</tr>
				<?php }
				} ?>
				
				

				
				
				
				<?php if(!!$patient->doctor_name){ ?>
			<td colspan="3" style="text-align:right">
			<br />
			<br />
				<b>
				<?php if(!!$patient->ima_registration_number){ ?>
					<?php echo $patient->doctor_name." (Regd No: ". $patient->ima_registration_number .")<br />".$patient->designation; 
				
				} else { ?>
					<?php echo $patient->doctor_name."<br />".$patient->designation; 
				 } ?>
				</b>
			</td>
			<?php } else { ?>
			<td colspan="3" style="text-align:center">
			<br />
			<br />
			<b>
			Doctor:	
			</b>
			</td>
<?php } ?>
				</tr>				
		</table>
<p>Note: This is a Healthcare IT System generated document and does not need a signature. <br>Report generated on <?php echo date("j-M-Y h:i A"); ?>.</p>