<?php if ( ! defined('BASEPATH')) exit('No direct  script access allowed');

class Helpline extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('masters_model');
		$this->load->model('staff_model');
		$this->load->model('helpline_model');
		$this->load->model('hospital_model');
		if($this->session->userdata('logged_in')){
		$userdata=$this->session->userdata('logged_in');
		$this->config->load('callandsms');
		$user_id=$userdata['user_id'];
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");	
		$this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();
	}
	
	function detailed_report(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		$add_sms_access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Helpline Reports"){
					$access=1;
			}
			// Fetch user functions and check if the user has 
        	// access to documentation access rights
			if($function->user_function=="sms"){
                if ($function->add==1) $add_sms_access=1;
            }
		}
		
		
		if($access==1){
			$this->load->helper('form');
			$this->load->library('form_validation');
			$user=$this->session->userdata('logged_in');
			$this->data['user_id']=$user['user_id'];
			$this->data['title']="HelpLine Calls - Detailed Report";		
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");	
			$this->load->view('templates/header',$this->data);	 
		 	foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
					$this->data['lower_rowsperpage']= $default->lower_range;	 
					break;

		 		}
			}
			$this->data['controller_url'] = base_url().'helpline/get_call_recordings/?url=';
			$this->data['calls']=$this->helpline_model->get_detailed_report($this->data['rowsperpage']);
			$this->data['calls_count']=$this->helpline_model->get_detailed_report_count();
			$this->data['all_states']=$this->masters_model->get_data("states");
			$this->data['districts']=$this->staff_model->get_district();
			$this->data['caller_type']=$this->helpline_model->get_caller_type();
			$this->data['language']=$this->helpline_model->get_language();
			$this->data['department']=$this->hospital_model->get_department();
			$this->data['updatable_helpline']=$this->helpline_model->get_helpline("update");
			$this->data['call_category']=$this->helpline_model->get_call_category();
			$this->data['resolution_status']=$this->helpline_model->get_resolution_status();
			$this->data['helpline']=$this->helpline_model->get_helpline("report");
			$this->data['all_hospitals']=$this->staff_model->get_hospital();
			$this->data['user_hospitals']=$this->staff_model->user_hospital($user['user_id']);
			$this->data['emails_sent']=$this->helpline_model->get_emails();
			$this->data['sms_templates']=$this->helpline_model->get_sms_template();
			$this->data['add_sms_access']=$add_sms_access;
			

			//echo("<script>console.log('PHP: " . json_encode($this->data['calls_count']) . "');</script>");
			$user_receiver = $this->helpline_model->getHelplineReceiverByUserId($this->data['user_id']);
			$user_receiver_links = array();
			if($user_receiver){
				$user_receiver_links = $this->helpline_model->getHelplineReceiverLinksById($user_receiver->receiver_id);
			}
			$this->data['user_details']=json_encode(array(
				'receiver' => $user_receiver,
				'receiver_link' => $user_receiver_links
			));
			// var_dump($this->data);
			$this->load->view('pages/helpline/report_detailed',$this->data);
			$this->load->view('templates/footer');
		}
		else show_404();
	}
	
	function completed_calls_report(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		$add_sms_access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="completed_calls_report"){
				$access=1;
				break;
			}
		}
		
		
		if($access==1){
			$this->load->helper('form');
			$this->load->library('form_validation');
			$user=$this->session->userdata('logged_in');
			$this->data['user_id']=$user['user_id'];
			$this->data['title']="Completed Calls Report";		
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");	
			$this->load->view('templates/header',$this->data);	 
		 	foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
					$this->data['lower_rowsperpage']= $default->lower_range;	 
					break;

		 		}
			}
			$this->data['calls']=$this->helpline_model->get_completed_calls_report($this->data['rowsperpage']);
			$this->data['calls_count']=$this->helpline_model->get_completed_calls_report_count();
	   		$this->data['helpline']=$this->helpline_model->get_helpline("report");
			$this->load->view('pages/helpline/completed_calls_report',$this->data);
			$this->load->view('templates/footer');
		}
		else show_404();
	}
	
	function missed_calls_report(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		$add_sms_access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="missed_calls_report"){
				$access=1;
				break;
			}
		}
		
		
		if($access==1){
			$this->load->helper('form');
			$this->load->library('form_validation');
			$user=$this->session->userdata('logged_in');
			$this->data['user_id']=$user['user_id'];
			$this->data['title']="Missed Calls Report";		
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");				 
		 	foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
					$this->data['lower_rowsperpage']= $default->lower_range;
			                break;		

		 		}
			}
			$this->data['calls']=$this->helpline_model->get_missed_calls_report($this->data['rowsperpage']);
			$this->data['calls_count']=$this->helpline_model->get_missed_calls_report_count();
	   		$this->data['helpline']=$this->helpline_model->get_helpline("report");
	   		$this->load->view('templates/header',$this->data);
			$this->load->view('pages/helpline/missed_calls_report',$this->data);
			$this->load->view('templates/footer');
		}
		else show_404();
	}
	
	function sms_sent_report(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="sms"){
				$access=1;
				break;
			}
		}
		if($access==1){
			$this->load->helper('form');
			$this->load->library('form_validation');
			$user=$this->session->userdata('logged_in');
			$this->data['user_id']=$user['user_id'];
			$this->data['title']="HelpLine SMS";
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
					$this->data['lower_rowsperpage']= $default->lower_range;	 
					break;

		 		}
			}
			$this->data['sms_data']=$this->helpline_model->get_sms_sent_report($this->data['rowsperpage']);
			$this->data['sms_count']=$this->helpline_model->get_sms_sent_report_count();
			$this->data['sent_status']=$this->helpline_model->get_sms_sent_status();
			$this->data['sms_template']=$this->helpline_model->get_sms_template($use_status=0);
			//$this->data['sms_template']=$this->helpline_model->get_sms_template_all();
			$this->data['helpline']=$this->helpline_model->get_helpline("report");
			$this->data['all_hospitals']=$this->staff_model->get_hospital();
			$this->load->view('templates/header',$this->data);
			$this->load->view('pages/helpline/sms_sent_report',$this->data);
			$this->load->view('templates/footer');
		}
		else show_404();
	}

	function voicemail_detailed_report(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Helpline Reports"){
				$access=1;
				break;
			}
		}
		if($access==1){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$this->data['title']="HelpLine Voicemail Calls - Detailed Report";
		$this->load->view('templates/header',$this->data);
		$this->data['calls']=$this->helpline_model->get_voicemail_detailed_report();
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['resolution_status']=$this->helpline_model->get_resolution_status();
		$this->data['helpline']=$this->helpline_model->get_helpline("report");
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['emails_sent']=$this->helpline_model->get_emails();
		$this->load->view('pages/helpline/report_voicemail_detailed',$this->data);
		$this->load->view('templates/footer');
		}
		else show_404();
	}

	function report_groupwise(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Helpline Reports"){
				$access=1;
				break;
			}
		}
		if($access==1){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$this->data['title']="HelpLine Calls - Group Wise Report";
		$this->load->view('templates/header',$this->data);
		$this->data['calls']=$this->helpline_model->get_detailed_report();
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['resolution_status']=$this->helpline_model->get_resolution_status();
		$this->data['helpline']=$this->helpline_model->get_helpline("report");
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['groups']=$this->helpline_model->get_groups();
		$this->data['emails_sent']=$this->helpline_model->get_emails();
		$this->load->view('pages/helpline/report_group_wise',$this->data);
		$this->load->view('templates/footer');
		}
		else show_404();
	}

	function update_call_api() {
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Helpline Update"){
				$access=1;
				break;
			}
		}
		if($access==1){
			$data = [];
			if($this->helpline_model->update_call()) {
				$data['status'] = true;
				$data['msg']="Call Updated successfully";
				$data['calls']=$this->helpline_model->get_calls();
			}
			else{
				$data['status'] = false;
				$data['msg']="Call could not be updated. Please try again.";
			}
			echo json_encode($data);
		}
	}
	function update_call(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Helpline Update"){
				$access=1;
				break;
			}
		}
		if($access==1){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$this->data['title']="Update HelpLine Calls";
		$this->load->view('templates/header',$this->data);
		$this->form_validation->set_rules('call[]','Call','trim|xss_clean');
		$this->data['helpline']=$this->helpline_model->get_helpline("update");
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['language']=$this->helpline_model->get_language();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['resolution_status']=$this->helpline_model->get_resolution_status();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		if ($this->form_validation->run() === FALSE){
			$this->load->view('pages/helpline/update_calls',$this->data);
		}
		else{
			$this->data['calls']=$this->helpline_model->get_calls();
			if(($this->input->post('submit'))) {
				if(!!$this->input->post('call')){
					if($this->helpline_model->update_call()){
					$this->data['msg']="Calls Updated successfully";
					$this->data['calls']=$this->helpline_model->get_calls();
					}
					else{
						$this->data['msg']="Calls could not be updated. Please try again.";
					}
				}
				else {
						$this->data['msg']="Please select at least one call to update.";
				}
				$this->load->view('pages/helpline/update_calls',$this->data);
			}
			else if($this->input->post('send_email')){
				$result = $this->helpline_model->send_email();
				$this->data['calls']=$this->helpline_model->get_calls();
				if($result==1){
					$this->data['msg']="Email sent successfully.";
				}
				else if($result==2){
					$this->data['msg']="Email not sent, please check the email address(es) entered and try again.";
				}
				else{
					$this->data['msg']="Email not sent.";
				}
				$this->load->view('pages/helpline/update_calls',$this->data);
			}
			else{
			$this->load->view('pages/helpline/update_calls',$this->data);
			}
		}
		$this->load->view('templates/footer');
		}
		else show_404();
	}

	function update_voicemail_calls(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Helpline Update"){
				$access=1;
				break;
			}
		}
		if($access==1){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$this->data['title']="Update HelpLine Voicemail Calls";
		$this->load->view('templates/header',$this->data);
		$this->form_validation->set_rules('call[]','Call','trim|xss_clean');
		$this->data['calls']=$this->helpline_model->get_voicemail_calls();
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['resolution_status']=$this->helpline_model->get_resolution_status();
		$this->data['helpline']=$this->helpline_model->get_helpline("update");
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		if ($this->form_validation->run() === FALSE){
			$this->load->view('pages/helpline/update_voicemail_calls',$this->data);
		}
		else{
			if(($this->input->post('submit'))) {
				if(!!$this->input->post('call')){
					if($this->helpline_model->update_call()){
					$this->data['msg']="Calls Updated successfully";
					$this->data['calls']=$this->helpline_model->get_voicemail_calls();
					}
					else{
						$this->data['msg']="Calls could not be updated. Please try again.";
					}
				}
				else {
						$this->data['msg']="Please select at least one call to update.";
				}
				$this->load->view('pages/helpline/update_voicemail_calls',$this->data);
			}
			else if($this->input->post('send_email')){
				$result = $this->helpline_model->send_email();
				$this->data['calls']=$this->helpline_model->get_voicemail_calls();
				if($result==1){
					$this->data['msg']="Email sent successfully.";
				}
				else if($result==2){
					$this->data['msg']="Email not sent, please check the email address(es) entered and try again.";
				}
				else{
					$this->data['msg']="Email not sent.";
				}
				$this->load->view('pages/helpline/update_voicemail_calls',$this->data);
			}
			else{
			$this->load->view('pages/helpline/update_voicemail_calls',$this->data);
			}
		}
		$this->load->view('templates/footer');
		}
		else show_404();
	}

	function insert_call(){
		if(!!$this->input->get('CallSid')) {
			$this->helpline_model->insert_call();
		}
		else show_404();
	}

	function search_call_groups(){
		if($groups = $this->helpline_model->get_call_groups()){
			$list=array(
				'groups'=>$groups
			);

				echo json_encode($list);
		}
		else return false;
	}

	function helpline_receivers(){
		if($this->session->userdata('logged_in')){
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="helpline_receiver"){
					$access=1;
					if($function->add=="1"){
						$this->data['helpline_receiver_add']=1;
					}
					else{
						$this->data['helpline_receiver_add']=0;
					}
					
					if($function->edit=="1"){
						$this->data['helpline_receiver_edit']=1;					
					}
					else{
						$this->data['helpline_receiver_edit']=0;
						
					}
					break;
				}
			}
			if($access==1){
				$this->load->helper('form');
				$this->data['title']="User Helpline Receivers";
				$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults"); 
			 	foreach($this->data['defaultsConfigs'] as $default){		 
			 	if($default->default_id=='pagination'){
			 			$this->data['rowsperpage'] = $default->value;
			 			$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;
						break;
			 		}
				}
				$this->data['helpline']=$this->helpline_model->get_helpline("report");
				$this->data['all_states']=$this->masters_model->get_data("states");
				$this->data['districts']=$this->staff_model->get_district();
				$this->data['proficiency']=$this->helpline_model->get_proficiency();
				$this->data['languages']=$this->helpline_model->get_language($receiver_id);;
				$this->data['userdata']=$this->session->userdata('logged_in');
				$this->data['user_functions']=$this->staff_model->get_user_function();
				$this->data['report_count'] = $this->helpline_model->getHelplineReceiversCount();
				$this->data['receivers'] = $this->helpline_model->getHelplineReceivers(array('default_rowsperpage' => $this->data['rowsperpage']));
				$this->load->view('templates/header',$this->data);			
				$this->load->view('pages/helpline_receiver_list',$this->data);
				$this->load->view('templates/footer');
			}
			else{
				show_404();
			}
		}
		else{
			show_404();
		}
	}

	function helpline_receivers_form($receiver_id=''){
		if($this->session->userdata('logged_in')){  						
			$this->data['userdata']=$this->session->userdata('logged_in');  
		} else{
            		show_404(); 													
            	} 

		/*$access = -1;
		foreach($this->data['functions'] as $function){
            if($function->user_function=="Helpline - Receivers"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}*/
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="helpline_receiver"){				
				if($function->edit=="1" || $function->add=="1"){
						$access=1;					
				}
				break;
			}
		}
		if($access==1){
			$this->load->helper('form');										
			$this->load->library('form_validation'); 							
			$this->data['title']="Add Helpline Receiver";										
			$this->load->view('templates/header', $this->data);					
			$config=array(
		   array( 'field'   => 'full_name', 'label'   => 'Full Name', 'rules'   => 'required|trim|xss_clean' ),
		   array( 'field'   => 'short_name', 'label'   => 'Short Name', 'rules'   => 'required|trim|xss_clean' ),
		   array( 'field'   => 'email', 'label'   => 'Email', 'rules'   => 'required|trim|xss_clean' ),
		   array( 'field'   => 'category', 'label'   => 'Category', 'rules'   => 'required|trim|xss_clean' ),
		   array( 'field'   => 'app_id', 'label'   => 'App ID', 'rules'   => 'trim|xss_clean' )
			);
			if(!$receiver_id){
				$config[] = array( 'field'   => 'phone', 'label'   => 'Phone', 'rules'   => 'required|trim|xss_clean' );
			}
			$this->form_validation->set_rules($config);

			$this->data['users']=$this->masters_model->get_users();
			$this->data['helplines']=$this->helpline_model->get_helplines();
			$this->data['districts']=$this->staff_model->get_district();
			$this->data['proficiency']=$this->helpline_model->get_proficiency();
			$this->data['receiver_languages']=$this->helpline_model->get_helpline_receiver_languages($receiver_id);
			$this->data['languages']=$this->helpline_model->get_language($receiver_id);
			$this->data['count_languages']= count($this->data['receiver_languages']);	
			$existing_receivers = false;
			if($this->input->post('phone')){
				$this->data['receivers_exists_msg'] = "The receiver with this phone already exists";
				$this->data['receivers'] = $existing_receivers = $this->helpline_model->getHelplineReceivers(array('phone' => $this->input->post('phone')));
				if($existing_receivers){
					$this->load->view('pages/helpline_receiver_list', $this->data);
				}
		}

		if(!$existing_receivers){
				if($this->form_validation->run()===FALSE) {	

				} else {
					if($this->helpline_model->save_helpline_receiver($receiver_id)){
					$this->data['receiver_languages']=$this->helpline_model->get_helpline_receiver_languages($receiver_id);
						$this->data['msg']="Helpline Receiver Saved Succesfully";					
					}
				}
		}

		$this->data['submitLink'] = "helpline/helpline_receivers_form";
		$this->data['usersList'] = array();
		if($receiver_id){
			$helpline_receiver = $this->helpline_model->getHelplineReceiverById($receiver_id)[0];
			$this->data['edit_data'] = json_encode(['helpline_receiver' => $helpline_receiver, 'helpline_receiver_link' => $this->helpline_model->getHelplineReceiverLinksById($receiver_id), 'userList' => $this->staff_model->search_staff_user("", $helpline_receiver->user_id)]);
			$this->data['submitLink'] = "helpline/helpline_receivers_form/" . $receiver_id;
		}

			$this->load->view('pages/helpline_receiver_form',$this->data);							
			$this->load->view('templates/footer');								
    	}
    	else{
            	show_404(); 													
            } 
        }	

	function search_staff_user(){
		if($results = $this->staff_model->search_staff_user($this->input->post('query'))){			
			echo json_encode($results);
		}
		else return false;
	}	

	function search_helpline_receiver(){
		if($results = $this->helpline_model->search_helpline_receiver($this->input->post('query'))){			
			echo json_encode($results);
		}
		else return false;
	}	

	function get_helpline_receiver_by_doctor(){
		$results = array();
		if($this->input->post('links') == "1"){
			$results = $this->helpline_model->get_helpline_receiver_links_by_doctor($this->input->post('doctor'), $this->input->post('helpline'));
		} else {
			$results = $this->helpline_model->get_helpline_receiver_by_doctor($this->input->post('doctor'), $this->input->post('helpline'));
		}
		if(!$results || empty($results)) $results = array();
		echo json_encode($results);
	}
	
	
    function get_call_recordings(){
		
		$recodring_user_name = $this->config->item('recodring_user_name');
		$recodring_password = $this->config->item('recodring_password');

		// Initialize cURL session
		$ch = curl_init($this->input->get('url'));

		// Set cURL options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects, if any
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Skip SSL verification if needed
		
		// Set HTTP Basic Authentication
		curl_setopt($ch, CURLOPT_USERPWD, "$recodring_user_name:$recodring_password");

		// Execute cURL request
		$response = curl_exec($ch);

		// Check for cURL errors
		if(curl_errno($ch)) {
			header('HTTP/1.1 500 Internal Server Error');
			echo 'cURL error: ' . curl_error($ch);
			curl_close($ch);
			exit;
		}

		// Get HTTP response code
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($httpCode != 200) {
			header('HTTP/1.1 404 Not Found');
			echo 'HTTP error: ' . $httpCode;
			curl_close($ch);
			exit;
		}

		// Get the content length
		$contentLength = strlen($response);

		// Check for HTTP Range request
		if (isset($_SERVER['HTTP_RANGE'])) {
			$range = $_SERVER['HTTP_RANGE'];
			list($unit, $range) = explode('=', $range, 2);
			if ($unit === 'bytes') {
				list($start, $end) = explode('-', $range);
				$start = intval($start);
				$end = $end ? intval($end) : $contentLength - 1;

				header('HTTP/1.1 206 Partial Content');
				header('Content-Range: bytes ' . $start . '-' . $end . '/' . $contentLength);
				header('Content-Length: ' . ($end - $start + 1));
				header('Content-Type: audio/mpeg');
				header('Accept-Ranges: bytes');

				echo substr($response, $start, $end - $start + 1);
				curl_close($ch);
				exit;
			}
		}

		// Default response
		header('Content-Type: audio/mpeg');
		header('Content-Length: ' . $contentLength);

		echo $response;

		// Close cURL session
		curl_close($ch);
	}
	function initiate_call(){

		$api_key = $this->config->item('exotel_call_api_key');
		$api_token = $this->config->item('exotel_call_api_token');
		$account_sid = $this->config->item('exotel_account_sid');
		$account_subdomain = $this->config->item('exotel_account_subdomain');
		$call_type = $this->config->item('exotel_call_type');
		//$api_key = '';
		//$api_token = '';
		//$account_sid = '';
		//$account_subdomain = 'api.exotel.com';
		//$call_type = 'trans';
		//echo("<script>console.log('Call: " . $api_key . "');</script>");
		//echo("<script>console.log('Call: " . $api_token . "');</script>");
		//echo("<script>console.log('Call: " . $account_sid . "');</script>");
		//echo("<script>console.log('Call: " . $account_subdomain . "');</script>");
		//echo("<script>console.log('Call: " . $call_type . "');</script>");
		$from = $this->input->post('from');
		$app_url = 'http://my.exotel.in/exoml/start/' . $this->input->post('app_id');
		$calledId = $this->input->post('called_id');


		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://".$api_key.":".$api_token."@".$account_subdomain."/v1/Accounts/".$account_sid."/Calls/connect");

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( array( 'From' => $from, 'Url' => $app_url, 'CallerId' => $calledId, 'CallType' => $call_type,'Record' => 'true') ) );

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    $error_msg = curl_error($ch);
		}

		curl_close ($ch);

		if (isset($error_msg)) {
			echo $error_msg;
		} else {
			echo true;
		}
	}

	function initiate_sms(){
		$to = $this->input->post('to');
		$dltHeader = $this->input->post('dlt_header');
		$calledId = $this->input->post('called_id');
		$templateText = $this->input->post('template');
		$templateId = $this->input->post('template_name');
		$smstype = $this->input->post('sms_type');
		$dlttid = $this->input->post('dlt_tid');
		$dltEntityId  = $this->input->post('dlt_entity_id');

		$post_data = array(
			// 'From' doesn't matter; For transactional, this will be replaced with your SenderId;
			// For promotional, this will be ignored by the SMS gateway
			'From'   => $calledId,
			'To'    => $to,
			'Body'  => $templateText,
			'DltEntityId' => $dltEntityId,
			'DltTemplateId'=>$dlttid
		);
		
		$api_key = $this->config->item('exotel_sms_api_key');
		$api_token = $this->config->item('exotel_sms_api_token');
		$account_sid = $this->config->item('exotel_account_sid');
		$account_subdomain = $this->config->item('exotel_account_subdomain');
		//echo("<script>console.log('SMS: " . $api_key . "');</script>");
		//echo("<script>console.log('SMS: " . $api_token . "');</script>");
		//echo("<script>console.log('SMS: " . $account_sid . "');</script>");
		//echo("<script>console.log('SMS: " . $account_subdomain . "');</script>");

		
		//$api_key="";
		//$api_token =  "";
		//$account_sid = "";
		//$account_subdomain = 'api.exotel.com';
		
		$url = "https://".$api_key.":".$api_token."@".$account_subdomain."/v1/Accounts/".$account_sid."/Sms/send";	  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		 
		$http_result = curl_exec($ch);
		$error = curl_error($ch);
		$http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
		
		curl_close($ch);
		//enable this for php version less than 5.6.40

		//$xml=<<<XML
		//$http_result
		//XML;
		
		$xmlresult=simplexml_load_string($http_result);

		$this->helpline_model->set_sms_helpline($calledId, $to, $templateText, $templateId, $smstype, $dlttid, $http_code, strval($xmlresult->SMSMessage->Status), strval($xmlresult->SMSMessage->Sid), $xmlresult->SMSMessage->DetailedStatusCode, strval($xmlresult->SMSMessage->DetailedStatus));

		if ($http_code==200){
			echo true;
		} else {
			echo $xmlresult->RestException->Message;
		}
	}

	function session_plan(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="helpline_session_plan"){
				$access=1;
				break;
			}
		}


		if($access==1){
			$user=$this->session->userdata('logged_in');
			$this->data['user_id']=$user['user_id'];
			$this->data['title']="Helpline Session Plan";
			$this->data['helpline']=$this->helpline_model->get_helpline("any",1);
			$this->data['weekdays']=$this->helpline_model->get_weekdays();
			$this->data['helpline_session_role']=$this->helpline_model->get_helpline_session_role();
			//$this->data['helpline_sessions']='SSSOG'; //$this->helpline_model->get_helpline_session();
			$this->data['helpline_sessions']=$this->helpline_model->get_helpline_session();
			$this->load->view('templates/header',$this->data);
			$this->data['receivers'] = $this->helpline_model->getHelplineReceivers();
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			// $this->data['updated']=false;
			foreach($this->data['defaultsConfigs'] as $default){
				if($default->default_id=='pagination'){
					$this->data['rowsperpage'] = $default->value;
					$this->data['upper_rowsperpage']= $default->upper_range;
					$this->data['lower_rowsperpage']= $default->lower_range;
					break;
				}
			}
			if ($this->input->post('receiver_id')) {
				// Modal addition
				if($this->helpline_model->insert_session_plan()) {
				// insertion succeded.
				}
				else {
				// insertion failed.
				header('HTTP/1.1 500 Internal Server');
 			       header('Content-Type: application/json; charset=UTF-8');
				echo json_encode(array('message' => 'error')) ;
				}
			}
			else {
			}

			if ($this->input->post('rows_per_page')) {
				// The submit for the current search has been entered.
				$this->data['report_count'] = $this->helpline_model->get_helpline_session_report_count();
				$this->data['report'] = $this->helpline_model->get_helpline_session_report($this->data['rowsperpage']);
			}
			else {
			// $this->data['report'] = $this->helpline_model->get_helpline_session_report();

			}
			if ($this->form_validation->run() === FALSE) 
			{
				$this->load->view('pages/helpline/session_plan',$this->data);
			}
			else {
				$this->load->view('pages/helpline/session_plan',$this->data);
			}
			$this->load->view('templates/footer');
		}
		else {
			show_404();
		}

	}
	function update_user_helpline_sessionplan(){
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="helpline_session_plan"){
				$access=1;
				break;
			}
		}
		if ($access==1) {

			$user=$this->session->userdata('logged_in');
			$this->data['user_id']=$user['user_id'];
			$this->data['title']="HelpLine Receivers -Sessions";
			$this->data['weekdays']=$this->helpline_model->get_weekdays();
			$this->data['helpline_session_role']=$this->helpline_model->get_helpline_session_role();
			$this->data['session_name']=$this->input->post('session_name');
			$helpline_session_id = $this->input->post('helpline_session_id');
			$helpline_session_plan_id = $this->input->post('helpline_session_plan_id');
			$this->data['report'] = $this->helpline_model->get_helpline_receiver_report($helpline_session_id);
			$this->load->view('templates/header',$this->data);
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){
				if($default->default_id=='pagination'){
					$this->data['rowsperpage'] = $default->value;
					$this->data['upper_rowsperpage']= $default->upper_range;
					$this->data['lower_rowsperpage']= $default->lower_range;
					break;
				}
			}
			$this->data['report'] = $this->helpline_model->get_helpline_receiver_report($helpline_session_id,$this->data['rowsperpage'] );
			$this->data['report_count'] = $this->helpline_model->get_helpline_receiver_report_count($helpline_session_id);
			if ($this->input->post('helpline_update_session_plan_id')) {
				if($this->input->post('helpline_session_plan_operation') && $this->input->post('helpline_session_plan_operation') == "Edit") {
					$this->helpline_model->update_helpline_session_plan_id($this->input->post('helpline_update_session_plan_id'));
				}
				else {
					//delete request
					if ($this->helpline_model->delete_helpline_session_plan_id($this->input->post('helpline_update_session_plan_id'))) {
				}
				else {
					//deletion failed
					header('HTTP/1.1 500 Internal Server');
 			       	header('Content-Type: application/json; charset=UTF-8');
				echo json_encode(array('message' => 'error')) ;
					}
				}
			}
			else {
			}
			
			if ($this->input->post('view_receiver_id')) {
				// get sessions for a receiver
			   $receivers= $this->helpline_model->get_helpline_sessions_for_receiver();
			$this->data['full_name']=$this->input->post('name_receiver_id');
			$this->data['report_sessions']=$receivers;
			$data=array(
				'report_sessions'=>$receivers
			);
				//$data['report_sesssions']=$this->data['report_sessions'];
				 //echo json_encode($data);
			}

			if ($this->form_validation->run() === FALSE) 
			{
				$this->load->view('pages/helpline/update_session_plan',$this->data);
			}
			else {
				$this->load->view('pages/helpline/update_session_plan',$this->data);
			}
			$this->load->view('templates/footer');
		}
		else {
			show_404();

		}
	}

	function receiver_call_activity_report(){

			if($this->session->userdata('logged_in')){  	
				echo("<script>console.log('PHP:');</script>");					
				$this->data['userdata']=$this->session->userdata('logged_in');  
			} else{
						show_404(); 													
					} 
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="Helpline Reports"){
						$access=1;
						// echo("<script>console.log('PHP: access=1');</script>");
						break;
				}
			}
			
			if($access==1){
				// echo("<script>console.log('PHP:');</script>");
				$this->load->helper('form');
				$this->load->library('form_validation');
				$user=$this->session->userdata('logged_in');
				$this->data['user_id']=$user['user_id'];
				$this->data['title']="HelpLine Receiver Calls - Detailed Report";		
				$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");	
				$this->load->view('templates/header',$this->data);	 
				 foreach($this->data['defaultsConfigs'] as $default){		 
				 if($default->default_id=='pagination'){
						 $this->data['rowsperpage'] = $default->value;
						 $this->data['upper_rowsperpage']= $default->upper_range;
						 $this->data['lower_rowsperpage']= $default->lower_range;	 
						 break;
	
					 }
				}
				$this->data['calls']=$this->helpline_model->get_receiver_activity_report($this->data['rowsperpage']);
				$this->data['calls_count']=$this->helpline_model->get_receiver_call_activity_report_count();
				$this->data['helpline']=$this->helpline_model->get_helplines();

	
					
				$this->load->view('pages/helpline/report_call_activity',$this->data);
				$this->load->view('templates/footer');
			}
			else {
				show_404();
			} 
		}	
}
