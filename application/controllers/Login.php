<?php 
class Login extends CI_Controller {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		
		
	}
	
	function index()
	{
		$this->load->view('Login/login');
		
		$this->session->set_userdata('BUTTON_NAME', '');
		$this->session->set_userdata('MODULE_NAME', 'login');
		$this->session->set_userdata('PAGE_NAME', 'login');
		
	}
	
	function validate_credentials()
	{
		$username = $this->input->post('username');
		$password = base64_encode($this->input->post('password'));
		$this->load->model('Login_info_model');	
		$query = $this->Login_info_model->validate($username,$password);
		//echo $this->input->post('username');
		//print_r( $query );
		
		//Form Validation
		
			
		if($query)
		{
		$todaysdate = date('Y-m-d');
		$exp = $this->Login_info_model->validate_expiry($username,$todaysdate);
		if(!$exp){
			$this->session->set_flashdata('msg',' Your application service got expired');
			redirect(base_url().'Login/index');	
		}else{
			$loginData['login_data'] = $this->Login_info_model->get_user_detail($username,$password);
			$data=array(				
				'IS_LOGGED_IN'=>'TRUE',
				'ID'=> $loginData['login_data']['id'],
				'USER_ID'=> $loginData['login_data']['first_name'],
				'IMAGE_NAME'=>$loginData['login_data']['img_name'],
				'USER_FULL_NAME'=> $loginData['login_data']['first_name'].' '.$loginData['login_data']['last_name'],
				//'USER_FIRST_NAME'=> $loginData['login_data']['first_name'],
				//'USER_GENDER'=> $loginData['login_data']['gender_id'],
				'USER_TYPE'=>$loginData['login_data']['designation'],
				'PHONE_NO'=>$loginData['login_data']['mobile_no'],
				'EMAIL_ID'=>$loginData['login_data']['email_id'],
				'ADDRESS'=>$loginData['login_data']['address'],
				'ENT_ID'=>$loginData['login_data']['ent_id'],
			);
			//print_r($data);
			$this->session->set_userdata($data);
			$data['basic_id'] = $this->Login_info_model->get_id($data['USER_ID']);
			$basicdata['basic_row'] = $this->Login_info_model->get_record($data['basic_id']['id']);
			
			$data=array(				
				'BASIC_REG_ID'=>$basicdata['basic_row']['id'],
				'BASIC_USER_ID'=>$basicdata['basic_row']['user_id'],	
				'BROWSER_NAME'=>$basicdata['basic_row']['browser_name'],
				'LAST_ACCESS'=>$basicdata['basic_row']['last_access']
			);
			$this->session->set_userdata($data);
			
			$datestring = date('Y-m-d H:i:s');
            $time = time();
			
            $browser_name = $this->agent->browser().';'.$this->agent->version().';'.$this->agent->mobile().';'.$this->agent->platform();
			$data =array
			(
				'user_id'=>$_SESSION['USER_FULL_NAME'],
				'browser_name' => $browser_name,	
				'last_access' => mdate($datestring, $time) 
			);				
			$this->Login_info_model->add_record($data);
						
			if($_SESSION['LAST_ACCESS'] != '')
			{
			$this->Login_info_model->delete_record($_SESSION['BASIC_REG_ID'],$_SESSION['BASIC_USER_ID']);
			}
			
			$pclogin = 1;
			$userid = $_SESSION['ID'];
			$data = array(
							'pc_login' => $pclogin
							);
							
			$this->Login_info_model->update_logout($data,$userid);	
			redirect(base_url().'Dashboard/index');
		}
		
	}else
		{
			
			$this->session->set_flashdata('msg',' Invalid Login Details.');
			redirect(base_url().'Login/index');				
		}
	}
	public function logout()
	{
		$this->load->model('Login_info_model');	
		$pclogin = 0;
		$userid = $_SESSION['ID'];
		$data = array(
						'pc_login' => $pclogin
						);
						
		$this->Login_info_model->update_logout($data,$userid);	
		session_destroy();
		redirect(base_url().'Login/index');
	}
	
	
	function registration()
	{
		$this->load->model('Combo_model');	
		$data['cbo_user_type'] = $this->Combo_model->cbo_designation();
		$this->load->view('Login/register',$data);
	}
	
	
	
	function forgot_password()
	{
		$this->load->view('Login/forgot-password');
		
		
	}
	function forget_password_success()
	{
		$this->load->view('Login/forgetpasswordsuccess');
		
		
	}	
}