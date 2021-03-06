<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->model('Product_model');
		$this->load->library('encrypt');	
		
	}
	
	public function index()
	{
		$data['title'] = "Product Details";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Products/productlist');
		$this->load->view('Home/footer');
	}
	
	public function addproduct()
	{
	    
		$data['auto_code'] = $this->Product_model->get_productcode($_SESSION['ID']);
		$prodcount = (int)$data['auto_code']['continues_count'];
		// Field Validation
		$prodtype = $this->input->post('producttype');
		$this->form_validation->set_rules('productname','Product Name','required');
		$this->form_validation->set_rules('productname','Product Name','required');
		$this->form_validation->set_rules('productqty','Product Qty','required|numeric');
		$this->form_validation->set_rules('mrp','MRP','required|Decimal');
		$this->form_validation->set_rules('purrate','Purchase Rate','required|decimal');
		$this->form_validation->set_rules('salerate','Sale Rate','required|decimal');
		$this->form_validation->set_rules('packdate','Pack Date','required');
		$this->form_validation->set_rules('expdate','Expiry Date','required');
		$this->form_validation->set_rules('qtylmt','Quantity Limit','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('taxper','Tax Percent','required|decimal');
		
		if($prodtype === "Tablet"){
		$this->form_validation->set_rules('strips','Strips in Boxs.','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('pcs','Pcs in Stript.','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('cbo_uom','Product UOM','required');
		}else if($prodtype === "Liquid"){
		$this->form_validation->set_rules('botinbox','Bottles in Boxs.','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('mlinbot','Ml in Bottle.','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('cbo_uom_bot','Product UOM','required');
		}
		
		
		if(($this->form_validation->run())==false)
		{
		$data['title'] = "HealthCare - Add New Product";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Products/addproduct',$data);
		$this->load->view('Home/footer');
		}
		else
		{
		if($prodtype === "Tablet"){
		$uom = $this->input->post('cbo_uom');
		$prodqty = $this->input->post('productqty');
		//print_r($uom);
		if($uom === 'Boxes'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('strips') * $this->input->post('pcs');
		}elseif($uom === 'Strips'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('pcs');
		}elseif($uom === 'Pcs'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty');
		}
		
		$batchno = $this->input->post('productcode').'-'.(String)$this->input->post('expdate').'-'.(int)$this->input->post('mrp').'-'.(int)$this->input->post('purrate').'-'.(int)$this->input->post('salerate');
		
		
		$datestring = date('Y-m-d');
		$data =array
			(
				'status'=>'Active',
				'user_id'=>$_SESSION['ID'],
				'product_code'=>$this->input->post('productcode'),
				'product_name'=>$this->input->post('productname'),
				'product_qty'=>$prodqty,
				'abtproduct'=>$this->input->post('abtproduct'),
				'batchno'=>$batchno,
				'mrp'=>$this->input->post('mrp'),
				'purrate'=>$this->input->post('purrate'),
				'salerate'=>$this->input->post('salerate'),
				'packdate'=>$this->input->post('packdate'),
				'expirydate'=>$this->input->post('expdate'),
				'stripsinbox'=>$this->input->post('strips'),
				'pcsinstrip'=>$this->input->post('pcs'),
				'qtylimit'=>$this->input->post('qtylmt'),
				'tax_percent'=>$this->input->post('taxper'),
				'product_type'=>$prodtype,
				'bottlesinbox'=>1,
				'mlinbottle'=>1
				
			);	
			$this->Product_model->add_record($data);
			
			$data =array
			(
				'last_updated'=>mdate($datestring),
				'continues_count'=> (int)$prodcount + 1
			);
		
			
			$this->Product_model->incriment_productcode_no($data,$_SESSION['ENT_ID']);
			
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    
                    <i class="icon fa fa-check"></i> Record Added Successfully.
                  </div>
				  ');
			
			redirect(base_url().'Product/productlist'); 
		}else if($prodtype === "Liquid"){
		$uom = $this->input->post('cbo_uom_bot');
		
		if($uom === 'Boxes'){
			$prodqty = $this->input->post('productqty') * $this->input->post('botinbox') * $this->input->post('mlinbot');
		}elseif($uom === 'Bottles'){
			$prodqty = $this->input->post('productqty') * $this->input->post('mlinbot');
		}elseif($uom === 'Ml'){
			$prodqty = $this->input->post('productqty');
		}
		$qtylmt =  $this->input->post('qtylmt') * $this->input->post('mlinbot');
		$batchno = $this->input->post('productcode').'-'.(String)$this->input->post('expdate').'-'.(int)$this->input->post('mrp').'-'.(int)$this->input->post('purrate').'-'.(int)$this->input->post('salerate');
		
		
		$datestring = date('Y-m-d');
		$data =array
			(
				'status'=>'Active',
				'user_id'=>$_SESSION['ID'],
				'product_code'=>$this->input->post('productcode'),
				'product_name'=>$this->input->post('productname'),
				'product_qty'=>$prodqty,
				'abtproduct'=>$this->input->post('abtproduct'),
				'batchno'=>$batchno,
				'mrp'=>$this->input->post('mrp') / $this->input->post('mlinbot'),
				'purrate'=>$this->input->post('purrate') / $this->input->post('mlinbot'),
				'salerate'=>$this->input->post('salerate') / $this->input->post('mlinbot'),
				'packdate'=>$this->input->post('packdate'),
				'expirydate'=>$this->input->post('expdate'),
				'bottlesinbox'=>$this->input->post('botinbox'),
				'mlinbottle'=>$this->input->post('mlinbot'),
				'qtylimit'=>$qtylmt,
				'tax_percent'=>$this->input->post('taxper'),
				'product_type'=>$prodtype,
				'stripsinbox'=>1,
				'pcsinstrip'=>1,
				
			);	
			$this->Product_model->add_record($data);

			
			$data =array
			(
				'last_updated'=>mdate($datestring),
				'continues_count'=> (int)$prodcount + 1
			);
		
			
			$this->Product_model->incriment_productcode_no($data,$_SESSION['ENT_ID']);
			
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    
                    <i class="icon fa fa-check"></i> Record Added Successfully.
                  </div>
				  ');
			
			redirect(base_url().'Product/productlist'); 
		
		}
		}
			
		
	}
	
	public function updateproduct()
	{
		$id = $this->uri->segment(3);
	
		if (empty($id))
		{
			show_404();
		}
		
		$data['product_row'] = $this->Product_model->get_record_by_id($id);
		$data['auto_code'] = $this->Product_model->get_productcode($_SESSION['ID']);
		// Field Validation
		$this->form_validation->set_rules('productcode','Product Code','required');
		$this->form_validation->set_rules('productname','Product Name','required');
		$this->form_validation->set_rules('productqty','Product Qty','required|numeric');
		$this->form_validation->set_rules('mrp','MRP','required|decimal');
		$this->form_validation->set_rules('purrate','Purchase Rate','required|decimal');
		$this->form_validation->set_rules('salerate','Sale Rate','required|decimal');
		$this->form_validation->set_rules('packdate','Pack Date','required');
		$this->form_validation->set_rules('expdate','Expiry Date','required');
		$this->form_validation->set_rules('qtylmt','Quantity Limit','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('taxper','Tax Percent','required|decimal');
		
		$prodtype = $data['product_row']['product_type'];
		if($prodtype === "Tablet"){
		$this->form_validation->set_rules('strips','Strips in Boxs.','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('pcs','Pcs in Stript.','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('cbo_uom','Product UOM','required');
		}else if($prodtype === "Liquid"){
		$this->form_validation->set_rules('botinbox','Bottles in Boxs.','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('mlinbot','Ml in Bottle.','required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('cbo_uom_bot','Product UOM','required');
		}
		
		if(($this->form_validation->run())==false)
		{
		$data['title'] = "HealthCare - Update Product";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Products/updateproduct',$data);
		$this->load->view('Home/footer');
		}
		else
		{
		
		if($prodtype === "Tablet"){
		$batchno = $this->input->post('productcode').'-'.(String)$this->input->post('expdate').'-'.(int)$this->input->post('mrp').'-'.(int)$this->input->post('purrate').'-'.(int)$this->input->post('salerate');
		
		if($batchno === $data['product_row']['batchno'] && $this->input->post('packdate') === $data['product_row']['packdate'] && $this->input->post('expdate') === $data['product_row']['expirydate']){
		$uom = $this->input->post('cbo_uom');
		$prodqty = $this->input->post('productqty');
		//print_r($uom);
		if($uom === 'Boxes'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('strips') * $this->input->post('pcs') + $this->input->post('curqty');
		}elseif($uom === 'Strips'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('pcs') + $this->input->post('curqty');
		}elseif($uom === 'Pcs'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') + $this->input->post('curqty');
		}
		$data =array
			(
				'status'=>'Active',
				'user_id'=>$_SESSION['ID'],
				'product_code'=>$this->input->post('productcode'),
				'product_name'=>$this->input->post('productname'), 
				'product_qty'=>$prodqty,
				'abtproduct'=>$this->input->post('abtproduct'),
				'batchno'=>$batchno,
				'mrp'=>$this->input->post('mrp'),
				'purrate'=>$this->input->post('purrate'),
				'salerate'=>$this->input->post('salerate'),
				'packdate'=>$this->input->post('packdate'),
				'expirydate'=>$this->input->post('expdate'),
				'stripsinbox'=>$this->input->post('strips'),
				'pcsinstrip'=>$this->input->post('pcs'),
				'qtylimit'=>$this->input->post('qtylmt'),
				'tax_percent'=>$this->input->post('taxper'),
				'bottlesinbox'=>1,
				'mlinbottle'=>1,
				
			);			
		//print_r($data);
			$this->Product_model->edit_record($data,$id);
		}else{
		$uom = $this->input->post('cbo_uom');
		$prodqty = $this->input->post('productqty');
		print_r($uom);
		if($uom === 'Boxes'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('strips') * $this->input->post('pcs');
		}elseif($uom === 'Strips'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('pcs');
		}elseif($uom === 'Pcs'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty');
		}
		$data =array
			(
				'status'=>'Active',
				'user_id'=>$_SESSION['ID'],
				'product_code'=>$this->input->post('productcode'),
				'product_name'=>$this->input->post('productname'), 
				'product_qty'=>$prodqty,
				'abtproduct'=>$this->input->post('abtproduct'),
				'batchno'=>$batchno,
				'mrp'=>$this->input->post('mrp'),
				'purrate'=>$this->input->post('purrate'),
				'salerate'=>$this->input->post('salerate'),
				'packdate'=>$this->input->post('packdate'),
				'expirydate'=>$this->input->post('expdate'),
				'stripsinbox'=>$this->input->post('strips'),
				'pcsinstrip'=>$this->input->post('pcs'),
				'qtylimit'=>$this->input->post('qtylmt'),
				'bottlesinbox'=>1,
				'mlinbottle'=>1,
				
			);			
		//print_r($data);
			$this->Product_model->add_record($data);
		}
		
			
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    
                    <i class="icon fa fa-check"></i> Record Added/Updated Successfully.
                  </div>
				  ');
			
			redirect(base_url().'Product/productlist'); 

		}else if($prodtype === "Liquid"){
		
		$batchno = $this->input->post('productcode').'-'.(String)$this->input->post('expdate').'-'.(int)$this->input->post('mrp').'-'.(int)$this->input->post('purrate').'-'.(int)$this->input->post('salerate');
		
		if($batchno === $data['product_row']['batchno'] && $this->input->post('packdate') === $data['product_row']['packdate'] && $this->input->post('expdate') === $data['product_row']['expirydate']){
		$uom = $this->input->post('cbo_uom_bot');
		$prodqty = $this->input->post('productqty');
		if($uom === 'Boxes'){
			$prodqty = $this->input->post('productqty') * $this->input->post('botinbox') * $this->input->post('mlinbot') +($this->input->post('curqty') * $this->input->post('mlinbot')) ;
		}elseif($uom === 'Bottles'){
			$prodqty = $this->input->post('productqty') * $this->input->post('mlinbot')+($this->input->post('curqty') * $this->input->post('mlinbot')) ;
		}
		$data =array
			(
				'status'=>'Active',
				'user_id'=>$_SESSION['ID'],
				'product_code'=>$this->input->post('productcode'),
				'product_name'=>$this->input->post('productname'), 
				'product_qty'=>$prodqty,
				'abtproduct'=>$this->input->post('abtproduct'),
				'batchno'=>$batchno,
				'mrp'=>$this->input->post('mrp') / $this->input->post('mlinbot'),
				'purrate'=>$this->input->post('purrate') / $this->input->post('mlinbot'),
				'salerate'=>$this->input->post('salerate') / $this->input->post('mlinbot'),
				'packdate'=>$this->input->post('packdate'),
				'expirydate'=>$this->input->post('expdate'),
				'stripsinbox'=>$this->input->post('strips'),
				'pcsinstrip'=>$this->input->post('pcs'),
				'qtylimit'=>$this->input->post('qtylmt'),
				'tax_percent'=>$this->input->post('taxper'),
				'stripsinbox'=>1,
				'pcsinstrip'=>1,
				
			);			
		//print_r($data);
			$this->Product_model->edit_record($data,$id);
		}else{
		$uom = $this->input->post('cbo_uom_bot');
		$prodqty = $this->input->post('productqty');
		if($uom === 'Boxes'){
			$prodqty = $this->input->post('productqty') * $this->input->post('botinbox') * $this->input->post('mlinbot') +($this->input->post('curqty') * $this->input->post('mlinbot')) ;
		}elseif($uom === 'Bottles'){
			$prodqty = $this->input->post('productqty') * $this->input->post('mlinbot')+($this->input->post('curqty') * $this->input->post('mlinbot')) ;
		}
		$qtylmt =  $this->input->post('qtylmt') * $this->input->post('mlinbot');
		$data =array
			(
				'status'=>'Active',
				'user_id'=>$_SESSION['ID'],
				'product_code'=>$this->input->post('productcode'),
				'product_name'=>$this->input->post('productname'), 
				'product_qty'=>$prodqty,
				'abtproduct'=>$this->input->post('abtproduct'),
				'batchno'=>$batchno,
				'mrp'=>$this->input->post('mrp') / $this->input->post('mlinbot'),
				'purrate'=>$this->input->post('purrate') / $this->input->post('mlinbot'),
				'salerate'=>$this->input->post('salerate') / $this->input->post('mlinbot'),
				'packdate'=>$this->input->post('packdate'),
				'expirydate'=>$this->input->post('expdate'),
				'stripsinbox'=>$this->input->post('strips'),
				'pcsinstrip'=>$this->input->post('pcs'),
				'qtylimit'=>$this->input->post('qtylmt'),
				'stripsinbox'=>1,
				'pcsinstrip'=>1,
				
			);			
		//print_r($data);
			$this->Product_model->add_record($data);
		}
		
			
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    
                    <i class="icon fa fa-check"></i> Record Added/Updated Successfully.
                  </div>
				  ');
			
			redirect(base_url().'Product/productlist');
			
			
			
		}
		
		
		}
	}
	
	public function productlist()
	{
		//$usertype = 'Admin';	
		$data['product'] = $this->Product_model->view_record('DESC');
		$data['product_admin'] = $this->Product_model->view_record_admin('DESC');
		$data['title'] = "Product Details";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Products/productlist');
		$this->load->view('Home/footer');
	}
	
	
	/* function check_equal_less($second_field,$first_field) 
	{ if ($second_field >= $first_field) { 
	$this->form_validation->set_message('check_equal_less', 'The Purchase field should be less than or equals to MRP field  '); 
	return false; 
	}
	 else { return true; } 
	} */
	
	
	
}
