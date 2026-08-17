<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/css/metallic.css">
<script type="text/javascript"
src="<?php echo base_url(); ?>assets/js/zebra_datepicker.js"></script>
<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript"
src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript"
src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.widgets.min.js"></script>

<style>
.modal-body, .modal-header {
    background: #111;
}

/* 1. Center Web Report Table ONLY (exclude landing page #table-sort) */
body .panel-body table.table-bordered:not(#table-sort),
body .panel-body table.table-bordered:not(#table-sort) th,
body .panel-body table.table-bordered:not(#table-sort) td,
body .panel-body table.table-bordered:not(#table-sort) tbody tr td,
body .panel-body table.table-bordered:not(#table-sort) tbody tr th,
body .panel-body table.table-bordered:not(#table-sort) tr td:first-child,
body .panel-body table.table-bordered:not(#table-sort) tr td:last-child,
body .panel-body table.table-bordered:not(#table-sort) tr th:first-child,
body .panel-body table.table-bordered:not(#table-sort) tr th:last-child {
    text-align: center !important;
    vertical-align: middle !important;
    padding: 8px 12px !important;
}

body .panel-body table.table-bordered:not(#table-sort) th {
    background-color: #fcfcfc;
}

/* 2. Sensitivity lists inside Web View table */
.panel-body .table-bordered ol,
.panel-body .table-bordered ul {
    margin: 0 auto !important;
    padding-left: 0 !important;
    list-style-position: inside !important;
    text-align: center !important;
}

/* 3. Landing page search table (#table-sort) alignment */
body #table-sort th,
body #table-sort td {
    text-align: left !important;
    vertical-align: middle !important;
}

body #table-sort tr th:first-child,
body #table-sort tr td:first-child,
body #table-sort tr th:last-child,
body #table-sort tr td:last-child {
    text-align: center !important;
}

/* 4. Signature Row Web View */
.panel-body > .col-md-12:last-of-type {
    margin-top: 30px !important;
    padding-left: 15px !important;
    padding-right: 15px !important;
}

.panel-body > .col-md-12:last-of-type > .col-md-6:nth-child(1),
.panel-body > .col-md-12:last-of-type > .col-md-6:nth-child(5) {
    text-align: left !important;
    padding-left: 0 !important;
}

.panel-body > .col-md-12:last-of-type > .col-md-6:nth-child(2),
.panel-body > .col-md-12:last-of-type > .col-md-6:nth-child(6) {
    text-align: right !important;
    padding-right: 0 !important;
}
</style>

<script>
    $(function () {
        $(".date").Zebra_DatePicker();
    });

    $(function () {
        var options = {
            widthFixed: true,
            showProcessing: true,
            headerTemplate: '{content} {icon}',
            widgets: ['default', 'zebra', 'stickyHeaders'],
            widgetOptions: {
                stickyHeaders: '',
                stickyHeaders_offset: 0,
                stickyHeaders_cloneId: '-sticky',
                stickyHeaders_addResizeEvent: true,
                stickyHeaders_includeCaption: false,
                stickyHeaders_zIndex: 2,
                stickyHeaders_attachTo: null,
                stickyHeaders_filteredToTop: true,
                zebra: ["ui-widget-content even", "ui-state-default odd"],
                uitheme: 'jui'
            }
        };
        $("#table-sort").tablesorter(options);
    });

    function printDiv(i) {
        var content = document.getElementById(i);
        var pri = document.getElementById("ifmcontentstoprint").contentWindow;
        pri.document.open();
        pri.document.write(content.innerHTML);
        pri.document.close();
        pri.focus();
        pri.print();
    }
</script>
<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute; display: none"></iframe>

<div class="col-md-10 col-md-offset-2">
    <?php echo validation_errors(); $nabl_flag = 0; $nabl_missing_flag = 0; ?>
    <?php if (isset($msg)) { ?>
        <div class="alert alert-info"><?php echo $msg; ?></div>
    <?php } ?>
    <br>

    <?php   
    if (isset($order)) {                     
        $patient_id = $order[0]->patient_id;
        $order_id = $order[0]->order_id;
        $logo = $order[0]->logo;
        $accredition_logo = $order[0]->accredition_logo;
        $test_area = $order[0]->test_area;
        $hospital = $order[0]->hospital;
        $place = $order[0]->place;
        $district = $order[0]->district;
        $state = $order[0]->state;
        $specimen_type = $order[0]->specimen_type;
        $specimen_source = $order[0]->specimen_source;
        $sample_code = $order[0]->sample_code;
        $test_method = $order[0]->test_method;
        $first_name = $order[0]->first_name;
        $last_name = $order[0]->last_name;
        $gender = $order[0]->gender;
        $visit_type = $order[0]->visit_type;
        $hosp_file_no = $order[0]->hosp_file_no;
        $department = $order[0]->department;
        $unit_name = $order[0]->unit_name;
        $area_name = $order[0]->area_name;
        $order_date_time = $order[0]->order_date_time;
        $reported_date_time = $order[0]->reported_date_time;
        $done_by = $order[0]->done_first . " " . $order[0]->done_last;
        $done_by_designation = $order[0]->done_by_designation;
        $approved_by = $order[0]->approved_first . " " . $order[0]->approved_last;
        $approved_by_designation = $order[0]->approved_by_designation;
        
        $age = "";
        if ($order[0]->age_years != 0) $age .= $order[0]->age_years . "Y ";
        if ($order[0]->age_months != 0) $age .= $order[0]->age_months . "M ";
        if ($order[0]->age_days != 0) $age .= $order[0]->age_days . "D ";
        if ($age == "") $age = "Not set";

        $assay_set = 0;
        foreach ($order as $o) {
            if ($o->assay != '') {
                $assay_set = 1;
                break;
            }
        }

        $group_interpretation_flag = 0;
        $test_interpretation_flag = 0;
        foreach($order as $test){
            if($test->test_group_interpretation != ''){
                $group_interpretation_flag = 1;
                break;
            }
        }
        foreach($order as $test){
            if($test->test_master_interpretation != ''){
                $test_interpretation_flag = 1;
                break;
            }
        }

        $binary_flag = 0;
        $numeric_flag = 0;
        $text_flag = 0;
        $test_range_flag = 0;
        $text_result_flag = 0;
        foreach ($order as $test) {
            if ($test->binary_result == 1) $binary_flag = 1;
            if ($test->numeric_result == 1) $numeric_flag = 1;
            if ($test->text_range == 1) $text_flag = 1;
            if ($test->nabl == 1) $nabl_flag = 1;
            if ($test->nabl == 0 && $test->test_master_id != 0) $nabl_missing_flag = 1;
            if ($test->text_result == 1) $text_result_flag = 1;
        }
        if ($numeric_flag == 1 || $text_flag == 1) {
            $test_range_flag = 1;
        }
    ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Order #<?php echo $order[0]->order_id; ?>
                    <small><b>Order placed at : </b><?php echo date("g:ia, d-M-Y", strtotime($order[0]->order_date_time)); ?></small>
                </h4>
            </div>
            <div class="panel-body">
                <div class="row col-md-12">
                    <div class="col-md-6"><b>Order Date : </b><?php echo date("d-M-Y, g:iA", strtotime($order[0]->order_date_time)); ?></div>
                    <div class="col-md-6"><b>Reported Date : </b><?php echo date("d-M-Y, g:ia", strtotime($order[0]->reported_date_time)); ?></div>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6"><b>Patient : </b><?php echo $order[0]->patient_id." | ".$order[0]->first_name . " " . $order[0]->last_name . " | " . $age . " | " . $order[0]->gender; ?></div>
                    <div class="col-md-6"><b><?php echo $order[0]->visit_type; ?> #<?php echo $order[0]->hosp_file_no; ?></b></div>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6"><b>Department : </b><?php echo $order[0]->department; ?></div>
                    <div class="col-md-6"><b>Unit/Area : </b><?php echo $order[0]->unit_name . " / " . $order[0]->area_name; ?></div>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6"><b>Sample : </b><?php echo $specimen_type . (!!$specimen_source ? " - " . $specimen_source : ""); ?></div>
                    <div class="col-md-6"><b>Sample Code : </b><?php echo $sample_code; ?></div>
                </div>
                <br/><br/><br/>
                
                <?php 
                $antibiotic_result_flag = 0;
                $sensitivity_tests_done = array();
                foreach($order as $test){
                    if ($test->binary_result == 1 && preg_match("^Culture*^", $test->test_method)) {
                        $individual_tests = explode("^", trim($test->micro_organism_test));
                        foreach($individual_tests as $individual_test){
                            $test_result = explode(",", ltrim($individual_test, ","));
                            $sensitivity_tests_done[] = array(
                                'test_name' => $test->test_name,
                                'test_id' => $test->test_id,
                                'micro_organism_test_id' => isset($test_result[0]) ? $test_result[0] : "",
                                'micro_organism' => isset($test_result[1]) ? $test_result[1] : "",
                                'antibiotic' => isset($test_result[2]) ? $test_result[2] : "",
                                'antibiotic_result' => isset($test_result[3]) ? $test_result[3] : "",
                                'test_result_text' => $test->test_result_text,
                                'binary_positive' => $test->binary_positive,
                                'binary_negative' => $test->binary_negative,
                                'test_result_binary' => $test->test_result_binary
                            );
                            if(isset($test_result[3]) && ($test_result[3] == 1 || $test_result[3] == 0)) {
                                $antibiotic_result_flag = 1;
                            }
                        }
                    }
                }

                $groups = array();
                $group_tests = array();
                $i = 0;
                foreach ($order as $test) {
                    if ($test->group_id != 0) {
                        if (!in_array($test->group_id, $groups)) {
                            $groups[] = $test->group_id;
                        }
                        $group_tests[] = array(
                            'group_id' => $test->group_id,
                            'test_master_id' => $test->test_master_id,
                            'test_id' => $test->test_id,
                            'test_name' => $test->test_name,
                            'test_status' => $test->test_status,
                            'binary_result' => $test->binary_result,
                            'numeric_result' => $test->numeric_result,
                            'text_result' => $test->text_result,
                            'test_result_binary' => $test->test_result_binary,
                            'test_result' => $test->test_result,
                            'test_result_text' => $test->test_result_text,
                            'binary_positive' => $test->binary_positive,
                            'binary_negative' => $test->binary_negative,
                            'range_text' => $test->range_text,
                            'lab_unit' => $test->lab_unit,
                            'min' => $test->min,
                            'max' => $test->max,
                            'range_type' => $test->range_type,
                            'text_range' => $test->text_range,
                            'assay' => $test->assay,
                            'nabl' => $test->nabl,
                            'test_group_interpretation' => $test->test_group_interpretation,
                            'test_master_interpretation' => $test->test_master_interpretation
                        );
                        array_splice($order, $i, 1);
                        $i--;
                    }
                    $i++;
                }
                ?>
                
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Test</th>
                        <?php if ($assay_set == 1) { ?><th>Method</th><?php } ?>
                        <?php if ($numeric_flag == 1 || $binary_flag == 1 || $text_flag == 1 || $text_result_flag) { ?><th>Test Report</th><?php } ?>
                        <?php if ($test_range_flag == 1) { ?><th>Normal Range</th><?php } ?>
                    </tr>
                    
                    <?php
                    $sno = 1;
                    $unique_groups = array();
                    foreach ($group_tests as $test) {                           
                        if ($test['group_id'] != 0 && $test['test_master_id'] == '0') {
                            if (!in_array($test['group_id'], $unique_groups)) {
                                $unique_groups[] = $test['group_id'];
                            } else {
                                continue;
                            }
                        } else {
                            continue;
                        }

                        if ($test['test_master_id'] == '0') { ?>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td><?php echo $test['test_name']; ?></td>
                                <?php if ($assay_set == 1) echo '<td>' . $test['assay'] . '</td>'; ?>
                                <td>
                                    <?php 
                                    $result = "";
                                    if ($test['test_status'] == 1) {
                                        $result = "Tests not yet done.";
                                    } else if ($test['test_status'] == 2) {
                                        $result_parts = array();
                                        if ($test['numeric_result'] == 1 && !empty($test['test_result'])) {
                                            $result_parts[] = trim($test['test_result'] . " " . $test['lab_unit']);
                                        }
                                        if ($test['binary_result'] == 1) {
                                            if ($test['test_result_binary'] == 1 && !empty($test['binary_positive'])) $result_parts[] = trim($test['binary_positive']);
                                            else if ($test['test_result_binary'] == 0 && !empty($test['binary_negative'])) $result_parts[] = trim($test['binary_negative']);
                                        }
                                        if (isset($test['test_result_text']) && $test['test_result_text'] !== '' && $test['test_result_text'] !== '0') {
                                            $result_parts[] = trim($test['test_result_text']);
                                        }
                                        $result = implode(', ', $result_parts);
                                    }
                                    echo $result;
                                    ?>
                                </td>
                                <?php if($test_range_flag == 1) { ?><td></td><?php } ?>
                            </tr>
                        <?php
                        }
                        $sub_no = 1;
                        foreach ($group_tests as $test_inner) {
                            if ($test_inner['test_master_id'] != 0 && $test['group_id'] != 0 && $test['group_id'] == $test_inner['group_id']) { ?>
                            <tr>
                                <td><?php echo $sno . "." . $sub_no; ?></td>
                                <td>
                                    <?php echo $test_inner['test_name'];
                                    if ($nabl_flag == 1 && $test_inner['nabl'] == 0) echo "<b style='color:red'>*</b>";
                                    ?>
                                </td>
                                <?php if ($assay_set == 1) { ?><td><?php echo $test_inner['assay']; ?></td><?php } ?>
                                <td>
                                    <?php 
                                    $result = "";
                                    if ($test_inner['test_status'] == 1) {
                                        $result = "Tests not yet done.";
                                    } else if ($test_inner['test_status'] == 2) {
                                        $result_parts = array();
                                        if ($test_inner['numeric_result'] == 1 && !empty($test_inner['test_result'])) {
                                            $result_parts[] = trim($test_inner['test_result'] . " " . $test_inner['lab_unit']);
                                        }
                                        if ($test_inner['binary_result'] == 1) {
                                            if ($test_inner['test_result_binary'] == 1 && !empty($test_inner['binary_positive'])) $result_parts[] = trim($test_inner['binary_positive']);
                                            else if ($test_inner['test_result_binary'] == 0 && !empty($test_inner['binary_negative'])) $result_parts[] = trim($test_inner['binary_negative']);
                                        }
                                        if (isset($test_inner['test_result_text']) && $test_inner['test_result_text'] !== '' && $test_inner['test_result_text'] !== '0') {
                                            $result_parts[] = trim($test_inner['test_result_text']);
                                        }
                                        $result = implode(', ', $result_parts);
                                    }
                                    echo $result;
                                    ?>
                                </td>
                                <?php if($test_range_flag == 1) { ?>
                                <td>   
                                    <?php 
                                    $result = "";
                                    if(($test_inner['test_result'] != NULL || isset($test_inner['test_result_text'])) && $test_inner['test_status'] == 2){
                                        if ($test_inner['range_type'] == 1) $result .= "< " . $test_inner['max'] ." ". $test_inner['lab_unit'];
                                        else if ($test_inner['range_type'] == 2) $result .= "> " . $test_inner['min'] ." ". $test_inner['lab_unit'];
                                        else if ($test_inner['range_type'] == 3) $result .= $test_inner['min'] . " - " . $test_inner['max'] ." ". $test_inner['lab_unit'];
                                        else if($test_inner['range_type'] == 4) $result .= $test_inner['range_text'];
                                    }
                                    echo $result;
                                    ?>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php 
                            $sub_no++;
                            }
                        }
                        $sno++;             
                    } ?>

                    <?php
                    foreach ($order as $test) {                                
                        if($test->group_id == 0 && !preg_match("^Culture*^", $test->test_method)){ ?>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td>
                                    <?php echo $test->test_name;
                                    if ($nabl_flag == 1 && $test->nabl == 0) echo "<b style='color:red'>*</b>";
                                    ?>
                                    <?php if($test->test_area == "Radiology" && $test->study_id != "") { ?>
                                        &nbsp;&nbsp;<a data-toggle="modal" data-target="#myModal" href="#"><span class="glyphicon glyphicon-eye-open"></span> View Image</a>
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document" style="width:90%">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:0.8" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <object type="text/html" data="http://localhost/dwv/viewers/simplistic/index.php?input=http%3A%2F%2Flocalhost%2F<?php echo $test->filepath;?>" width="100%" height="800px" style="overflow:auto;border:3px ridge #ccc"></object>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </td>
                                <?php if ($assay_set == 1) { ?><td><?php echo $test->assay; ?></td><?php } ?>
                                <td>
                                    <?php 
                                    $result = "";
                                    if ($test->test_status == 1) {
                                        $result = "Tests not yet done.";
                                    } else if ($test->test_status == 2) {
                                        $result_parts = array();
                                        if ($test->numeric_result == 1 && !empty($test->test_result)) {
                                            $result_parts[] = trim($test->test_result . " " . $test->lab_unit);
                                        }
                                        if ($test->binary_result == 1) {
                                            if ($test->test_result_binary == 1 && !empty($test->binary_positive)) $result_parts[] = trim($test->binary_positive);
                                            else if ($test->test_result_binary == 0 && !empty($test->binary_negative)) $result_parts[] = trim($test->binary_negative);
                                        }
                                        if (isset($test->test_result_text) && $test->test_result_text !== '' && $test->test_result_text !== '0') {
                                            $result_parts[] = trim($test->test_result_text);
                                        }
                                        $result = implode(', ', $result_parts);
                                    }
                                    echo $result;
                                    ?>
                                </td>
                                <?php if($test_range_flag == 1) { ?>
                                <td>   
                                    <?php 
                                    $result = "";
                                    if(($test->test_result != NULL || isset($test->test_result_text)) && $test->test_status == 2){
                                        if ($test->range_type == 1) $result .= "< " . $test->max ." ". $test->lab_unit;
                                        else if ($test->range_type == 2) $result .= "> " . $test->min ." ". $test->lab_unit;
                                        else if ($test->range_type == 3) $result .= $test->min . " - " . $test->max ." ". $test->lab_unit;
                                        else if($test->range_type == 4) $result .= $test->range_text;
                                    }
                                    echo $result;
                                    ?>
                                </td>
                                <?php } ?>
                            </tr>
                    <?php $sno++; } } ?>

                    <?php 
                    foreach($order as $test){
                        if ($test->binary_result == 1 && preg_match("^Culture*^", $test->test_method)) { ?>
                            <tr>
                                <td><?php echo $sno; ?></td>
                                <td>
                                    <?php echo $test->test_name;
                                    if ($nabl_flag == 1 && $test->nabl == 0) echo "<b style='color:red'>*</b>";
                                    ?>
                                </td>
                                <?php if ($assay_set == 1) { ?><td><?php echo $test->assay; ?></td><?php } ?>
                                <td>
                                    <?php 
                                    $result = "";
                                    $positive_for = "";
                                    $flag_1 = 0;
                                    $microbes_1 = array();
                                    foreach($sensitivity_tests_done as $sensitivity_test){
                                        if($sensitivity_test['test_id'] == $test->test_id && $sensitivity_test['test_result_binary'] == 1 && !empty($sensitivity_test['micro_organism'])){
                                            if (!in_array($sensitivity_test['micro_organism'], $microbes_1)) {
                                                $microbes_1[] = $sensitivity_test['micro_organism'];
                                                if($flag_1 == 0) $positive_for .= " for ";
                                                if($flag_1 == 1) $positive_for .= ", ";
                                                $positive_for .= $sensitivity_test['micro_organism'];
                                                $positive_for .= (!is_null($sensitivity_test['test_result_text']) && !empty($sensitivity_test['test_result_text'])) ? ", ".$sensitivity_test['test_result_text'] : "";
                                                $flag_1 = 1;
                                            }
                                            $result = $sensitivity_test['binary_positive']." ";
                                        } else if($sensitivity_test['test_id'] == $test->test_id && $sensitivity_test['test_result_binary'] == 1 && $flag_1 != 1){
                                            $result = $sensitivity_test['binary_positive'].((!is_null($sensitivity_test['test_result_text']) && !empty($sensitivity_test['test_result_text'])) ? ", ".$sensitivity_test['test_result_text'] : "");
                                        } else if($sensitivity_test['test_id'] == $test->test_id && $sensitivity_test['test_result_binary'] == 0){
                                            $result = $sensitivity_test['binary_negative'].((!is_null($sensitivity_test['test_result_text']) && !empty($sensitivity_test['test_result_text'])) ? ", ".$sensitivity_test['test_result_text'] : "");
                                        }
                                    }
                                    echo ($flag_1 == 1) ? $result . $positive_for : $result;
                                    ?>
                                </td>
                                <?php if($test_range_flag == 1) { ?><td></td><?php } ?>
                            </tr>
                    <?php } } ?>
                </table>

                <?php if(!!$sensitivity_tests_done && $antibiotic_result_flag == 1) { ?>
                <div class="panel panel-default">
                    <?php 
                    $microbes = array();
                    foreach($sensitivity_tests_done as $sensitivity_test_outer){ 
                        if($sensitivity_test_outer['micro_organism'] != ''){
                            if (!in_array($sensitivity_test_outer['micro_organism_test_id'], $microbes)) {
                                $microbes[] = $sensitivity_test_outer['micro_organism_test_id'];
                    ?>
                    <div class="panel-heading">Sensitivity report for <?php echo $sensitivity_test_outer['micro_organism'].".";?></div>
                    <table class="table table-bordered">
                        <tr>
                            <th>Sensitive</th>
                            <th>Resistant</th>
                        </tr>
                        <?php
                        $sensitive = "";
                        $resistant = "";
                        foreach($sensitivity_tests_done as $sensitivity_test_inner){
                            if($sensitivity_test_outer['micro_organism'] == $sensitivity_test_inner['micro_organism']){
                                if($sensitivity_test_inner['antibiotic_result'] == 1){
                                    $sensitive .= "<li>".$sensitivity_test_inner['antibiotic']."</li>";
                                } else {
                                    $resistant .= "<li>".$sensitivity_test_inner['antibiotic']."</li>";
                                }
                            }
                        } ?>
                        <tr>
                            <td><ol><?php echo $sensitive; ?></ol></td>
                            <td><ol><?php echo $resistant; ?></ol></td>
                        </tr>
                    </table>
                    <?php } } } ?>
                </div>
                <?php } ?>

                <?php if($test_interpretation_flag == 1 || $group_interpretation_flag == 1) { ?> 
                <div class="col-md-12"><p><b>Interpretation:</b></p></div>
                <?php } ?>

                <?php if($group_interpretation_flag == 1){ ?>
                <div class="col-md-12">
                    <?php
                    $unique_groups = array();
                    foreach ($group_tests as $test) {                           
                        if ($test['group_id'] != 0 && $test['test_master_id'] == '0') {
                            if (!in_array($test['group_id'], $unique_groups)) {
                                $unique_groups[] = $test['group_id'];
                            } else {
                                continue;
                            }
                        } else {
                            continue;
                        } ?>            
                        <?php if(!!$test['test_group_interpretation']) { ?><div class="col-md-12"><p><b><?php echo $test['test_name']; ?>:</b> <?php echo $test['test_group_interpretation']; ?></p></div><?php } ?>
                        <?php foreach($group_tests as $test_inner) { ?>
                            <?php if ($test_inner['test_master_id'] != 0 && $test['group_id'] != 0 && $test['group_id'] == $test_inner['group_id'] && $test_inner['test_master_interpretation'] != '') { ?>
                                <?php if(!!$test_inner['test_master_interpretation']) { ?>
                                    <div class="col-md-12"><p><b><?php echo $test_inner['test_name']; ?>:</b> <?php echo $test_inner['test_master_interpretation']; ?></p></div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php } ?>

                <?php if($test_interpretation_flag == 1){ ?>
                    <?php foreach ($order as $test) { 
                        if($test->group_id == 0 && !!$test->test_master_interpretation){ ?>
                            <div class="col-md-12"><p><b><?php echo $test->test_name; ?>:</b> <?php echo $test->test_master_interpretation; ?></p></div>
                    <?php } } ?>
                <?php } ?>

                <div class="row"><div class="col-md-12"><div class="col-md-12">
                    <?php if($nabl_flag == 1 && $nabl_missing_flag == 1) { ?><b style="color: red">*</b>This test is not NABL accredited.<?php } ?>
                </div></div></div>
                <br />  
                <div class="col-md-12">
                    <div class="col-md-6">Done By</div>
                    <div class="col-md-6">Approved By</div>
                    <br /><br />
                    <div class="col-md-6"><?php echo $done_by; ?><br /><?php echo $done_by_designation; ?></div>
                    <div class="col-md-6"><?php echo $approved_by; ?><br /><?php echo $approved_by_designation; ?></div>
                </div>
            </div>

            <div class="panel-footer">
                <input type="text" class="sr-only" value="<?php echo $this->input->post('test_area'); ?>" name="test_area" readonly />
                <input type="text" class="sr-only" value="<?php echo $this->input->post('patient_type_search'); ?>" name="patient_type_search" readonly />
                <input type="text" class="sr-only" value="<?php echo $this->input->post('hosp_file_no_search'); ?>" name="hosp_file_no_search" readonly />
                <input type="text" class="sr-only" value="<?php echo $this->input->post('test_method_search'); ?>" name="test_method_search" readonly />
                <input type="text" class="sr-only" value="<?php echo $this->input->post('from_date'); ?>" name="from_date" readonly />
                <input type="text" class="sr-only" value="<?php echo $this->input->post('to_date'); ?>" name="to_date" readonly />
                <input type="text" value="<?php echo $order_id; ?>" name="order_id" class="sr-only hidden" />
                <input type="button" value="Print" class="btn btn-primary btn-md col-md-offset-5" name="print_results" onclick="printDiv('print_div')" />
            </div>
        </div>

        <div id="print_div" hidden class="sr-only">
            <style>
                @page {
                    margin: 10mm;
                    size: auto;
                }
                html, body {
                    width: 100% !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: 13px;
                    color: #000;
                    background: #fff;
                }
                table {
                    width: 95% !important;
                    margin: 12px auto !important;
                    border-collapse: collapse !important;
                }
                table:not(.inner) {
                    table-layout: auto !important;
                }
                table:not(.inner) td {
                    text-align: left !important;
                    padding: 4px 8px !important;
                    vertical-align: top !important;
                }
                table:not(.inner) th {
                    text-align: center !important;
                    padding: 4px 8px !important;
                }
                .inner {
                    border: 1px solid #333 !important;
                    table-layout: auto !important;
                }
                .inner th, .inner td {
                    border: 1px solid #333 !important;
                    padding: 8px 12px !important;
                    text-align: center !important;
                    vertical-align: middle !important;
                    white-space: normal !important;
                }
                .inner th {
                    background-color: #f2f2f2 !important;
                    font-weight: bold !important;
                }
                .inner ol, .inner ul {
                    margin: 0 auto !important;
                    padding-left: 0 !important;
                    list-style-position: inside !important;
                    text-align: center !important;
                }
                p {
                    width: 95% !important;
                    margin: 6px auto !important;
                    text-align: left !important;
                }
                table:not(.inner):last-of-type {
                    margin-top: 40px !important;
                    width: 95% !important;
                }
                table:not(.inner):last-of-type td[align="left"],
                table:not(.inner):last-of-type tr td:first-child {
                    text-align: left !important;
                    padding-left: 0 !important;
                }
                table:not(.inner):last-of-type td[align="right"],
                table:not(.inner):last-of-type tr td:last-child {
                    text-align: right !important;
                    padding-right: 0 !important;
                }
            </style>
            
            <img style="position: absolute; top: 3%; left: 3%;" src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>" alt="" width="60px" />
            <?php if($nabl_flag == 1) { ?>
                <img style="position: absolute; top: 3%; right: 5%;" src="<?php echo base_url(); ?>assets/images/<?php echo $accredition_logo; ?>" alt="" width="60px" />
            <?php } ?>
            <table border="0" style="margin: 0 auto; width: 95%;">
                <thead>
                    <tr><th style="text-align: center" colspan="10">Department of <?php echo $test_area; ?></th></tr>
                    <tr><th style="text-align: center" colspan="10"><?php echo $hospital; ?>, <?php echo $place; ?>, <?php echo $district; ?>, <?php echo $state; ?><br /></th></tr>
                    <tr><th style="text-align: center" colspan="10"><u><?php echo $test_method; ?> Report</u><br /></th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Ordered Date:</b> <?php echo date("g:ia, d-M-Y", strtotime($order_date_time)); ?></td>
                        <td colspan="2"><b>Reported Date:</b> <?php echo date("g:ia, d-M-Y", strtotime($reported_date_time)); ?></td>
                    </tr>
                    <tr>
                        <td><b>Patient:</b> <?php echo $patient_id." | ".$first_name . " " . $last_name . " | " . $age . " | " . $gender; ?></td> 
                        <td colspan="2"><b><?php echo $visit_type; ?> #</b><?php echo $hosp_file_no; ?></td>
                    </tr>
                    <tr>
                        <td><b>Department:</b> <?php echo $department; ?></td>
                        <td><b>Unit/Area:</b> <?php echo $unit_name . " / " . $area_name; ?></td>
                    </tr>
                    <tr>
                        <td><b>Sample:</b> <?php echo $specimen_type . (!!$specimen_source ? " - " . $specimen_source : ""); ?></td>
                        <td><b>Sample Code:</b> <?php echo $sample_code; ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="inner" style="border: 1px solid #ccc; border-collapse: collapse;">
                <tr>
                    <th>#</th>
                    <th>Test</th>
                    <?php if ($assay_set == 1) { ?><th>Method</th><?php } ?>
                    <?php if ($numeric_flag == 1 || $binary_flag == 1 || $text_flag == 1 || $text_result_flag) { ?><th>Test Report</th><?php } ?>
                    <?php if ($test_range_flag == 1) { ?><th>Normal Range</th><?php } ?>
                </tr>
                
                <?php
                $sno = 1;
                $unique_groups = array();
                foreach ($group_tests as $test) {                           
                    if ($test['group_id'] != 0 && $test['test_master_id'] == '0') {
                        if (!in_array($test['group_id'], $unique_groups)) {
                            $unique_groups[] = $test['group_id'];
                        } else {
                            continue;
                        }
                    } else {
                        continue;
                    }

                    if ($test['test_master_id'] == '0') { ?>
                        <tr>
                            <td><?php echo $sno; ?></td>
                            <td><?php echo $test['test_name']; ?></td>
                            <?php if ($assay_set == 1) echo '<td>' . $test['assay'] . '</td>'; ?>
                            <td>
                                <?php 
                                $result = "";
                                if ($test['test_status'] == 1) {
                                    $result = "Tests not yet done.";
                                } else if ($test['test_status'] == 2) {
                                    $result_parts = array();
                                    if ($test['numeric_result'] == 1 && !empty($test['test_result'])) {
                                        $result_parts[] = trim($test['test_result'] . " " . $test['lab_unit']);
                                    }
                                    if ($test['binary_result'] == 1) {
                                        if ($test['test_result_binary'] == 1 && !empty($test['binary_positive'])) $result_parts[] = trim($test['binary_positive']);
                                        else if ($test['test_result_binary'] == 0 && !empty($test['binary_negative'])) $result_parts[] = trim($test['binary_negative']);
                                    }
                                    if (isset($test['test_result_text']) && $test['test_result_text'] !== '' && $test['test_result_text'] !== '0') {
                                        $result_parts[] = trim($test['test_result_text']);
                                    }
                                    $result = implode(', ', $result_parts);
                                }
                                echo $result;
                                ?>
                            </td>
                            <?php if($test_range_flag == 1) { ?><td></td><?php } ?>
                        </tr>
                    <?php
                    }
                    $sub_no = 1;
                    foreach ($group_tests as $test_inner) {
                        if ($test_inner['test_master_id'] != 0 && $test['group_id'] != 0 && $test['group_id'] == $test_inner['group_id']) { ?>
                        <tr>
                            <td><?php echo $sno . "." . $sub_no; ?></td>
                            <td>
                                <?php echo $test_inner['test_name'];
                                if ($nabl_flag == 1 && $test_inner['nabl'] == 0) echo "<b style='color:red'>*</b>";
                                ?>
                            </td>
                            <?php if ($assay_set == 1) { ?><td><?php echo $test_inner['assay']; ?></td><?php } ?>
                            <td>
                                <?php 
                                $result = "";
                                if ($test_inner['test_status'] == 1) {
                                    $result = "Tests not yet done.";
                                } else if ($test_inner['test_status'] == 2) {
                                    $result_parts = array();
                                    if ($test_inner['numeric_result'] == 1 && !empty($test_inner['test_result'])) {
                                        $result_parts[] = trim($test_inner['test_result'] . " " . $test_inner['lab_unit']);
                                    }
                                    if ($test_inner['binary_result'] == 1) {
                                        if ($test_inner['test_result_binary'] == 1 && !empty($test_inner['binary_positive'])) $result_parts[] = trim($test_inner['binary_positive']);
                                        else if ($test_inner['test_result_binary'] == 0 && !empty($test_inner['binary_negative'])) $result_parts[] = trim($test_inner['binary_negative']);
                                    }
                                    if (isset($test_inner['test_result_text']) && $test_inner['test_result_text'] !== '' && $test_inner['test_result_text'] !== '0') {
                                        $result_parts[] = trim($test_inner['test_result_text']);
                                    }
                                    $result = implode(', ', $result_parts);
                                }
                                echo $result;
                                ?>
                            </td>
                            <?php if($test_range_flag == 1) { ?>
                            <td>   
                                <?php 
                                $result = "";
                                if(($test_inner['test_result'] != NULL || isset($test_inner['test_result_text'])) && $test_inner['test_status'] == 2){
                                    if ($test_inner['range_type'] == 1) $result .= "< " . $test_inner['max'] ." ". $test_inner['lab_unit'];
                                    else if ($test_inner['range_type'] == 2) $result .= "> " . $test_inner['min'] ." ". $test_inner['lab_unit'];
                                    else if ($test_inner['range_type'] == 3) $result .= $test_inner['min'] . " - " . $test_inner['max'] ." ". $test_inner['lab_unit'];
                                    else if($test_inner['range_type'] == 4) $result .= $test_inner['range_text'];
                                }
                                echo $result;
                                ?>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php 
                        $sub_no++;
                        }
                    }
                    $sno++;             
                } ?>

                <?php
                foreach ($order as $test) {                                
                    if($test->group_id == 0 && !preg_match("^Culture*^", $test->test_method)){ ?>
                        <tr>
                            <td><?php echo $sno; ?></td>
                            <td>
                                <?php echo $test->test_name;
                                if ($nabl_flag == 1 && $test->nabl == 0) echo "<b style='color:red'>*</b>";
                                ?>
                            </td>
                            <?php if ($assay_set == 1) { ?><td><?php echo $test->assay; ?></td><?php } ?>
                            <td>
                                <?php 
                                $result = "";
                                if ($test->test_status == 1) {
                                    $result = "Tests not yet done.";
                                } else if ($test->test_status == 2) {
                                    $result_parts = array();
                                    if ($test->numeric_result == 1 && !empty($test->test_result)) {
                                        $result_parts[] = trim($test->test_result . " " . $test->lab_unit);
                                    }
                                    if ($test->binary_result == 1) {
                                        if ($test->test_result_binary == 1 && !empty($test->binary_positive)) $result_parts[] = trim($test->binary_positive);
                                        else if ($test->test_result_binary == 0 && !empty($test->binary_negative)) $result_parts[] = trim($test->binary_negative);
                                    }
                                    if (isset($test->test_result_text) && $test->test_result_text !== '' && $test->test_result_text !== '0') {
                                        $result_parts[] = trim($test->test_result_text);
                                    }
                                    $result = implode(', ', $result_parts);
                                }
                                echo $result;
                                ?>
                            </td>
                            <?php if($test_range_flag == 1) { ?>
                            <td>   
                                <?php 
                                $result = "";
                                if(($test->test_result != NULL || isset($test->test_result_text)) && $test->test_status == 2){
                                    if ($test->range_type == 1) $result .= "< " . $test->max ." ". $test->lab_unit;
                                    else if ($test->range_type == 2) $result .= "> " . $test->min ." ". $test->lab_unit;
                                    else if ($test->range_type == 3) $result .= $test->min . " - " . $test->max ." ". $test->lab_unit;
                                    else if($test->range_type == 4) $result .= $test->range_text;
                                }
                                echo $result;
                                ?>
                            </td>
                            <?php } ?>
                        </tr>
                <?php $sno++; } } ?>

                <?php 
                foreach($order as $test){
                    if ($test->binary_result == 1 && preg_match("^Culture*^", $test->test_method)) { ?>
                        <tr>
                            <td><?php echo $sno; ?></td>
                            <td>
                                <?php echo $test->test_name;
                                if ($nabl_flag == 1 && $test->nabl == 0) echo "<b style='color:red'>*</b>";
                                ?>
                            </td>
                            <?php if ($assay_set == 1) { ?><td><?php echo $test->assay; ?></td><?php } ?>
                            <td>
                                <?php 
                                $result = "";
                                $positive_for = "";
                                $flag_1 = 0;
                                $microbes_1 = array();
                                foreach($sensitivity_tests_done as $sensitivity_test){
                                    if($sensitivity_test['test_id'] == $test->test_id && $sensitivity_test['test_result_binary'] == 1 && !empty($sensitivity_test['micro_organism'])){
                                        if (!in_array($sensitivity_test['micro_organism'], $microbes_1)) {
                                            $microbes_1[] = $sensitivity_test['micro_organism'];
                                            if($flag_1 == 0) $positive_for .= " for ";
                                            if($flag_1 == 1) $positive_for .= ", ";
                                            $positive_for .= $sensitivity_test['micro_organism'];
                                            $positive_for .= (!is_null($sensitivity_test['test_result_text']) && !empty($sensitivity_test['test_result_text'])) ? ", ".$sensitivity_test['test_result_text'] : "";
                                            $flag_1 = 1;
                                        }
                                        $result = $sensitivity_test['binary_positive']." ";
                                    } else if($sensitivity_test['test_id'] == $test->test_id && $sensitivity_test['test_result_binary'] == 1 && $flag_1 != 1){
                                        $result = $sensitivity_test['binary_positive'].((!is_null($sensitivity_test['test_result_text']) && !empty($sensitivity_test['test_result_text'])) ? ", ".$sensitivity_test['test_result_text'] : "");
                                    } else if($sensitivity_test['test_id'] == $test->test_id && $sensitivity_test['test_result_binary'] == 0){
                                        $result = $sensitivity_test['binary_negative'].((!is_null($sensitivity_test['test_result_text']) && !empty($sensitivity_test['test_result_text'])) ? ", ".$sensitivity_test['test_result_text'] : "");
                                    }
                                }
                                echo ($flag_1 == 1) ? $result . $positive_for : $result;
                                ?>
                            </td>
                            <?php if($test_range_flag == 1) { ?><td></td><?php } ?>
                        </tr>
                <?php } } ?>
            </table>

            <br />
            <?php if(!!$sensitivity_tests_done && $antibiotic_result_flag == 1) { ?>
            <table class="inner" style="border: 1px solid #ccc; border-collapse: collapse; margin: 15px auto; width: 95%;">
                <?php 
                $microbes = array();
                foreach($sensitivity_tests_done as $sensitivity_test_outer){
                    if($sensitivity_test_outer['micro_organism'] != ''){
                        if (!in_array($sensitivity_test_outer['micro_organism_test_id'], $microbes)) {
                            $microbes[] = $sensitivity_test_outer['micro_organism_test_id'];
                ?>
                <tr>
                    <th colspan="2">Sensitivity report for <?php echo $sensitivity_test_outer['micro_organism'].".";?></th>
                </tr>
                <tr>
                    <th>Sensitive</th>
                    <th>Resistant</th>
                </tr>
                <?php
                $sensitive = "";
                $resistant = "";
                foreach($sensitivity_tests_done as $sensitivity_test_inner){
                    if($sensitivity_test_outer['micro_organism'] == $sensitivity_test_inner['micro_organism']){
                        if($sensitivity_test_inner['antibiotic_result'] == 1){
                            $sensitive .= "<li>".$sensitivity_test_inner['antibiotic']."</li>";
                        } else {
                            $resistant .= "<li>".$sensitivity_test_inner['antibiotic']."</li>";
                        }
                    }
                } ?>
                <tr>
                    <td><ol><?php echo $sensitive; ?></ol></td>
                    <td><ol><?php echo $resistant; ?></ol></td>
                </tr>
                <?php } } } ?>
            </table>
            <?php } ?>

            <?php if($test_interpretation_flag == 1 || $group_interpretation_flag == 1) { ?> 
                <p><b>Interpretation:</b></p> 
            <?php } ?>

            <?php if($group_interpretation_flag == 1){ ?>
                <?php
                $unique_groups = array();
                foreach ($group_tests as $test) {                           
                    if ($test['group_id'] != 0 && $test['test_master_id'] == '0') {
                        if (!in_array($test['group_id'], $unique_groups)) {
                            $unique_groups[] = $test['group_id'];
                        } else {
                            continue;
                        }
                    } else {
                        continue;
                    } ?>                     
                    <?php if(!!$test['test_group_interpretation']) { ?><p><b><?php echo $test['test_name']; ?>:</b> <?php echo $test['test_group_interpretation']; ?></p><?php } ?>
                    <?php foreach($group_tests as $test_inner) { ?>
                        <?php if ($test_inner['test_master_id'] != 0 && $test['group_id'] != 0 && $test['group_id'] == $test_inner['group_id'] && $test_inner['test_master_interpretation'] != '') { ?>
                            <?php if(!!$test_inner['test_master_interpretation']) { ?>
                                <p><b><?php echo $test_inner['test_name']; ?>:</b> <?php echo $test_inner['test_master_interpretation']; ?></p>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

            <?php if($test_interpretation_flag == 1){ ?>
                <?php foreach ($order as $test) { 
                    if($test->group_id == 0 && !!$test->test_master_interpretation){ ?>
                        <p><b><?php echo $test->test_name; ?>:</b> <?php echo $test->test_master_interpretation; ?></p>
                <?php } } ?>
            <?php } ?>

            <p><?php if($nabl_flag == 1 && $nabl_missing_flag == 1) { ?><b style="color: red">*</b>This test is not NABL accredited.<?php } ?></p>
            
            <table style="width: 95%; margin: 20px auto 0 auto;">
                <tr>
                    <td colspan="3" align="left">Done By</td>
                    <td colspan="3" align="right">Approved By</td>
                </tr>
                <tr>
                    <td colspan="3" align="left"><?php echo $done_by; ?><br /><?php echo $done_by_designation; ?></td>
                    <td colspan="3" align="right"><?php echo $approved_by; ?><br /><?php echo $approved_by_designation; ?></td>
                </tr>
            </table>
        </div>
    <?php } else { ?>
        <?php
        echo form_open('diagnostics/view_results', array('role' => 'form', 'class' => 'form-custom'));
        if (isset($orders)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">Search</div>
                <div class="panel-body">
                    <input type="text" class="sr-only" value="<?php echo $this->input->post('test_area'); ?>" name="test_area" />
                    <label>Order Dates</label>
                    <input type="text" class="date form-control" placeholder="From Date" value="<?php echo ($this->input->post('from_date')) ? $this->input->post('from_date') : date("d-M-Y"); ?>" name="from_date" />
                    <input type="text" class="date form-control" placeholder="To Date" value="<?php echo ($this->input->post('to_date')) ? $this->input->post('to_date') : date("d-M-Y"); ?>" name="to_date" />
                    <br /><br />
                    <label>Test Method</label>
                    <select name="test_method_search" class="form-control">
                        <option value="" selected>Select</option>
                        <?php foreach ($test_methods as $test_method) { ?>
                            <option value="<?php echo $test_method->test_method_id; ?>" <?php if ($this->input->post('test_method_search') == $test_method->test_method_id) echo " selected "; ?>><?php echo $test_method->test_method; ?></option>
                        <?php } ?>
                    </select>
                    <label>Patient Type : </label>
                    <select name="patient_type_search" class="form-control">
                        <option value="" selected>Select</option>
                        <option value="OP" <?php if ($this->input->post('patient_type_search') == "OP") echo " selected "; ?>>OP</option>
                        <option value="IP" <?php if ($this->input->post('patient_type_search') == "IP") echo " selected "; ?>>IP</option>
                    </select>
                    <label>Patient #</label>
                    <input type="text" class="form-control" name="hosp_file_no_search" value="<?php echo $this->input->post('hosp_file_no_search'); ?>" />
                </div>
                <div class="panel-footer">
                    <input type="submit" value="Search" name="submit" class="btn btn-primary btn-md" />
                </div>
            </div>
            </form>

            <?php if (count($orders) > 0) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Test Orders</h4></div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped" id="table-sort">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>Sample Code</th>
                                    <th>Specimen</th>
                                    <th>IP/OP #</th>
                                    <th>Patient, Health4all ID</th>
                                    <th>Department</th>
                                    <th>Tests</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $o = array();
                            foreach ($orders as $order) { $o[] = $order->order_id; }
                            $o = array_unique($o);
                            $i = 1;
                            foreach ($o as $ord) { ?>
                                <tr>
                                <?php
                                foreach ($orders as $order) {
                                    $age = "";
                                    if(!!$order->age_years) $age .= $order->age_years."Y ";
                                    if(!!$order->age_months) $age .= $order->age_months."M ";
                                    if(!!$order->age_days) $age .= $order->age_days."D ";
                                    if($order->age_days == 0 && $order->age_months == 0 && $order->age_years == 0) $age .= "0D";

                                    if ($order->order_id == $ord) { ?>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <?php echo form_open('diagnostics/view_results', array('role' => 'form', 'class' => 'form-custom')); ?>
                                            <?php echo $order->order_id; ?>
                                            <input type="hidden" class="sr-only" name="order_id" value="<?php echo $order->order_id; ?>" />
                                        </td>
                                        <td><?php echo $order->sample_code; ?></td>
                                        <td><?php echo $order->specimen_type . ($order->specimen_source != "" ? " - " . $order->specimen_source : ""); ?></td>
                                        <td><?php echo $order->visit_type . " #" . $order->hosp_file_no; ?></td>
                                        <td><?php echo $order->first_name." ".$order->last_name." / ".$age." / ".$order->gender."<br/>".$order->h4allid; ?></td>
                                        <td><?php echo $order->department; ?></td>
                                        <td>
                                            <?php
                                            foreach ($orders as $order_sub) {
                                                if ($order_sub->order_id == $ord) {
                                                    $label = "label-warning";
                                                    if ($order_sub->test_status == 3) $label = "label-danger";
                                                    else if ($order_sub->test_status == 2) $label = "label-success";
                                                    echo "<div class='label $label'>" . $order_sub->test_name . (($nabl_flag == 1 && $order_sub->nabl == 0) ? "<b style='color:red'>*</b>" : '') . "</div><br />";
                                                }
                                            } ?>
                                        </td>
                                        <td>
                                            <input type="text" class="sr-only" value="<?php echo $this->input->post('test_area'); ?>" name="test_area" readonly />
                                            <input type="text" class="sr-only" value="<?php echo $this->input->post('patient_type_search'); ?>" name="patient_type_search" readonly />
                                            <input type="text" class="sr-only" value="<?php echo $this->input->post('hosp_file_no_search'); ?>" name="hosp_file_no_search" readonly />
                                            <input type="text" class="sr-only" value="<?php echo $this->input->post('test_method_search'); ?>" name="test_method_search" readonly />
                                            <input type="text" class="sr-only" value="<?php echo $this->input->post('from_date'); ?>" name="from_date" readonly />
                                            <input type="text" class="sr-only" value="<?php echo $this->input->post('to_date'); ?>" name="to_date" readonly />
                                            <button class="btn btn-sm btn-primary" type="submit" value="submit">Select</button>
                                            </form>
                                        </td>
                                    <?php break; } } ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else {
                echo "No orders to update";
            }
        } else if (count($test_areas) > 1) { ?>
            <?php echo form_open('diagnostics/view_results', array('role' => 'form', 'class' => 'form-custom')); ?>
            <div class="form-group">
                <label for="test_area">Test Area<font color='red'>*</font></label>
                <select name="test_area" class="form-control" id="test_area">
                    <option value="" selected disabled>Select Test Area</option>
                    <?php foreach ($test_areas as $test_area) { ?>
                        <option value="<?php echo $test_area->test_area_id; ?>" <?php if ($this->input->post('test_area') == $test_area->test_area_id) echo " selected "; ?>><?php echo $test_area->test_area; ?></option>
                    <?php } ?>
                </select>
                <input type="submit" class="btn btn-primary btn-md" name="submit_test_area" value="Select" />
            </div>
            </form>
        <?php }
    } ?>
</div>