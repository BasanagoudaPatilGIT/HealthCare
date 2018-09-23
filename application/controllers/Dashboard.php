<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		
		if (!isset( $_SESSION['IS_LOGGED_IN'] )) { 
			redirect(base_url()); 
		}
		$this->load->model('User_model');
		$this->load->model('Project_Details_model');
		$this->load->model('TestCase_model');
		$this->load->model('TestReport_model');
		
		
		
	}
	public function index()
	{
		$data['title'] = "HealthCare - Dashboard";
	 	$data['users'] = $this->User_model->user_count();
		
		/*echo"<pre>";
		print_r($data['pending_task']);
		echo"</pre>";*/
		
		
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Dashboard/dashboard',$data);
		$this->load->view('Home/footer');
	}
} 