<?php

class Payment extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->model('payment_model');
		$this->load->model('patient/patient_model');
		$this->load->model('settings/settings_model');
		$this->load->model('menu_model');
		
		$this->load->helper('form');
		$this->load->helper('currency');
		$this->load->helper('url');
		
		$this->load->library('form_validation');
		
		$this->lang->load('main');
    }
	public function is_session_started(){
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}
    public function index() {
		
		if ( $this->is_session_started() === FALSE ){
			session_start();
		}
		//Check if user has logged in 
		if (!isset($_SESSION["user_name"]) || $_SESSION["user_name"] == '') {
			redirect('login/index');
        } else {
			$data['payments'] = $this->payment_model->list_payments();
			$data['currency_postfix'] = $this->settings_model->get_currency_postfix();
			$this->load->view('templates/header');
			$this->load->view('templates/menu');
			$this->load->view('browse',$data);
			$this->load->view('templates/footer');
        }
    }
	
	public function insert($bill_id,$called_from = 'bill') {
        session_start();
		//Check if user has logged in 
		if (!isset($_SESSION["user_name"]) || $_SESSION["user_name"] == '') {
            redirect('login/index');
        } else {
			$this->form_validation->set_rules('patient_id', 'Patient', 'required');
            $this->form_validation->set_rules('bill_id', 'Bill Id', 'required');
			
			if ($this->form_validation->run() === FALSE) {
				$data['patients'] = $this->patient_model->get_patient();
				$data['bills'] = $this->patient_model->get_pending_bills();
				$data['currency_postfix'] = $this->settings_model->get_currency_postfix();
				$data['due_amount'] = $this->patient_model->get_due_amount($bill_id);
				$data['visit_id'] = $this->patient_model->get_visit_id($bill_id);
				$patient_id =  $this->patient_model->get_patient_id_from_bill_id($bill_id);
				$data['patient_id'] =$patient_id;
				$data['bill_id'] = $bill_id;
				$data['patient'] = $this->patient_model->get_patient_detail($patient_id); 
				$data['called_from'] = $called_from;
				$data['def_dateformate'] = $this->settings_model->get_date_formate();
				$this->load->view('templates/header');
				$this->load->view('templates/menu');
				$this->load->view('form',$data);
				$this->load->view('templates/footer');
			}else{
				$this->payment_model->insert_payment();
				
				$called_from = $this->input->post('called_from');
				$visit_id = $this->input->post('visit_id');
				$patient_id = $this->input->post('patient_id');
				if($called_from == 'bill'){
					redirect('patient/bill/'.$visit_id.'/'.$patient_id);
				}else{
					$this->index();
				}
			}
        }
    }
	
	public function edit($payment_id){
		session_start();
		//Check if user has logged in 
		if (!isset($_SESSION["user_name"]) || $_SESSION["user_name"] == '') {
            redirect('login/index');
        } else {
			$this->form_validation->set_rules('patient_id', 'Patient', 'required');
            $this->form_validation->set_rules('bill_id', 'Bill Id', 'required');
			$this->form_validation->set_rules('payment_amount', 'Payment Amount', 'required');
			$this->form_validation->set_rules('payment_date', 'Payment Date', 'required');
			$this->form_validation->set_rules('pay_mode', 'Payment Mode', 'required');
			
			if ($this->form_validation->run() === FALSE) {
				$data['patients'] = $this->patient_model->get_patient();
				$payment = $this->payment_model->get_payment($payment_id);
				$data['payment'] = $payment;
				$data['payment_id'] = $payment->payment_id;
				$bill_id = $payment->bill_id;
				$data['bill_id'] = $bill_id;
				$patient_id = $this->patient_model->get_patient_id_from_bill_id($bill_id);
				$data['patient_id'] = $patient_id;
				$data['patient'] = $this->patient_model->get_patient_detail($patient_id); 
				$data['def_dateformate'] = $this->settings_model->get_date_formate();
				$this->load->view('templates/header');
				$this->load->view('templates/menu');
				$this->load->view('form',$data);
				$this->load->view('templates/footer');
			}else{
				$this->payment_model->edit_payment($payment_id);
				$this->index();
			}
			
		}
	}
}
?>
