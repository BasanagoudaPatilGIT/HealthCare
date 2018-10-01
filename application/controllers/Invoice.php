<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->model('Invoice_model');
		$this->load->model('Product_model');
		$this->load->library('encrypt');	
		
	}
	
	public function index()
	{
		$data['title'] = "HealthCare - Invoice Details";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Invoice/invoice');
		$this->load->view('Home/footer');
		
	}
	
	public function createinvoice()
	{
		$data['auto_code'] = $this->Invoice_model->get_invoicecode($_SESSION['ID']);
	    $data['lineinvoice'] = $this->Invoice_model->view_record('DESC');
		$id = $_SESSION['ID'];
		$data['Mainsubtotal'] = $this->Invoice_model->get_total_amount($id);
		$data['Maintaxpercent'] = $this->Invoice_model->get_total_tax_percent($id);
		$data['MaintaxAmt'] = $this->Invoice_model->get_total_tax_amt($id);
		$data['MainAmt'] = $this->Invoice_model->get_total_amt($id);
		$data['prodcount'] = $this->Invoice_model->products_count($id) ;
		
		
		$this->form_validation->set_rules('productname','Product Name','required');
		$this->form_validation->set_rules('qty','Quantity','required|numeric|is_natural_no_zero');
		
		
			
			
		if(($this->form_validation->run())==false)
		{
		$data['title'] = "HealthCare - New Invoice";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Invoice/invoice',$data);
		$this->load->view('Home/footer');
		}
		else
		{
		$uom = $this->input->post('cbo_uom');
		$batch = $this->input->post('batchno');
		$data =array
			(
				'product_id'=>$this->input->post('productid'),
				'product_code'=>$this->input->post('productcode'),
				'product_name'=>$this->input->post('productname'),
				'batchno'=>$batch,
				'stock'=>$this->input->post('stock'),
				'sale_rate'=>$this->input->post('salerate'),
				'tax_percent'=>$this->input->post('tax'),
				'product_uom'=>$uom,
				'product_qty'=>$this->input->post('qty'),
				'sub_total'=>$this->input->post('lineamount'),
				'tax_amount'=>$this->input->post('linetaxamt'),
				'total'=> round($this->input->post('linetaxamt') + $this->input->post('lineamount')),
				'user_id'=>$_SESSION['ID']
			);			
			
			$this->Invoice_model->add_record($data);
			if($uom === 'Boxs'){
			$upqty = (int)$this->input->post('qty') * (int)$this->input->post('stripsinbox') * (int)$this->input->post('pcsinstrip');
			$stock = (int)$this->input->post('stockinpcs') - (int)$upqty;
			//print_r($stock);
			$data = array(
				'product_qty'=>$stock,
			);
			
			}else if($uom === 'Strips'){
			$upqty = (int)$this->input->post('qty') * (int)$this->input->post('pcsinstrip');
			$stock = (int)$this->input->post('stockinpcs') - (int)$upqty;
			//print_r($stock);
			$data = array(
				'product_qty'=>$stock,
			);
			}else if($uom === 'Pcs'){
			$upqty = (int)$this->input->post('qty');
			$stock = (int)$this->input->post('stockinpcs') - (int)$upqty;
			//print_r($stock);
			$data = array(
				'product_qty'=>$stock,
			);
			}
			
			$this->Product_model->update_stock($data,$batch);
			
			
			
			redirect(base_url().'Invoice/createinvoice');  
			
		
		}
	}
	
	
		public function saveinvoice()
		{
		
		$data['auto_code'] = $this->Invoice_model->get_invoicecode($_SESSION['ID']);
		$invoicenum = (int)$data['auto_code']['continues_count'];
	    $data['lineinvoice'] = $this->Invoice_model->view_record('DESC');
		$id = $_SESSION['ID'];
		$data['Mainsubtotal'] = $this->Invoice_model->get_total_amount($id);
		$data['Maintaxpercent'] = $this->Invoice_model->get_total_tax_percent($id);
		$data['MaintaxAmt'] = $this->Invoice_model->get_total_tax_amt($id);
		$data['MainAmt'] = $this->Invoice_model->get_total_amt($id);
		$data['prodcount'] = $this->Invoice_model->products_count($id) ;
		
	    // Field Validation
		$this->form_validation->set_rules('patientname','Patient Name','required');
		$this->form_validation->set_rules('cbo_gender','Patient Gender','required');
		$this->form_validation->set_rules('patientphoneno','Patient PhoneNo','required|numeric');
		$this->form_validation->set_rules('prodcount', 'Prodcount', 'callback_prodcount_check');
		$this->form_validation->set_rules('fees','Fees','required|numeric|is_natural_no_zero');
		
		if(($this->form_validation->run())==false)
		{
		$data['title'] = "HealthCare - New Invoice";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Invoice/invoice',$data);
		$this->load->view('Home/footer');
		}
		else
		{
		$data =array
			(
				'user_id'=>$_SESSION['ID'],
				'patient_name'=>$this->input->post('patientname'),
				'patient_gender'=>$this->input->post('cbo_gender'),
				'patient_phoneno'=>$this->input->post('patientphoneno'),
				'patient_address'=>$this->input->post('address'),
				'invoice_amt'=>$this->input->post('totalamt'),
				'total_tax_amt'=>$this->input->post('totaltaxamt'),
				'fees'=>$this->input->post('fees'),
				'total_gross_amt'=>$this->input->post('totalgrossamt'),
				'invoice_no'=>$data['auto_code']['series_id'].''.$data['auto_code']['user_id'].'-'.$data['auto_code']['continues_count'],
				
			);			
			
			$this->Invoice_model->add_patient_record($data);
			
			
			$data['lineinvoice'] = $this->Invoice_model->view_record('DESC');
			$linecount = count($data['lineinvoice']);
			for($i=0; $i < $linecount ; $i++){
				$data['lineinvoice'] = $this->Invoice_model->view_record('DESC');
				$data =array
				(
					'product_id'=>$data['lineinvoice'][$i]['product_id'],
					'product_code'=>$data['lineinvoice'][$i]['product_code'],
					'product_name'=>$data['lineinvoice'][$i]['product_name'],
					'batchno'=>$data['lineinvoice'][$i]['batchno'],
					'stock'=>$data['lineinvoice'][$i]['stock'],
					'sale_rate'=>$data['lineinvoice'][$i]['sale_rate'],
					'tax_percent'=>$data['lineinvoice'][$i]['tax_percent'],
					'product_uom'=>$data['lineinvoice'][$i]['product_uom'],
					'product_qty'=>$data['lineinvoice'][$i]['product_qty'],
					'sub_total'=>$data['lineinvoice'][$i]['sub_total'],
					'tax_amount'=>$data['lineinvoice'][$i]['tax_amount'],
					'total'=> $data['lineinvoice'][$i]['total'],
					'user_id'=>$data['lineinvoice'][$i]['user_id']
				);			
				$this->Invoice_model->add_invoice_record($data);
			}
			
			$this->Invoice_model->delete_all_record($_SESSION['ID']);
			
			$datestring = date('Y-m-d');			
			$data =array
			(
				'last_updated'=>mdate($datestring),
				'continues_count'=> (int)$invoicenum + 1
				
			);
			//print_r($data);
			$this->Invoice_model->incriment_invoice_no($data,$_SESSION['ENT_ID']);
			
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    
                    <i class="icon fa fa-check"></i> Record Added Successfully.
                  </div>
				  ');
			
			redirect(base_url().'Invoice/invoicelist'); 
			
			
		}
	}
	
	
	
	
	
	public function auto_search()
	{
		//$id = $_SESSION['ID'];
		if(isset($_GET['term'])) 
		{
		 $proddetails = $this->Invoice_model->auto_featch($_GET['term'], $_SESSION['ID']);
		
		if(count($proddetails) >0){
		foreach($proddetails as $row)
		$stockinbox = (int)$row->product_qty /((int)$row->stripsinbox * (int)$row->pcsinstrip);
		$stockinstrips = (int)$row->product_qty /(int)$row->pcsinstrip;
		
		$result_array[] = array('label' => $row->product_name,
								'id' => $row->id,
								'prodcode' => $row->product_code,
								'batchno' => $row->batchno,
								'stock' => $row->product_qty,
								'price' => $row->salerate,
								'tax' => $row->tax_percent,
								'stripsinbox' =>$row->stripsinbox,
								'pcsinstrip' =>$row->pcsinstrip,
								'stockinbox' =>(int)$stockinbox,
								'stockinstrips' =>(int)$stockinstrips
		);
		
		echo json_encode($result_array);
		}
		
			
		}
		
	}
	
	
	
	
	public function delete_record($id=0)
	{
		$id = $this->uri->segment(3);
		
		if ($id==0)
		{
			$this->index();			
		}	
		
		$data['tempproddetails'] = $this->Product_model->get_temp_record_by_id($id);
		
		$uom = $data['tempproddetails']['product_uom'];
		$batch = $data['tempproddetails']['batchno'];
		$data['proddetails'] = $this->Product_model->get_record_by_batch($batch);
		
		$this->Invoice_model->delete_record($id);
		if($uom === 'Boxs'){
			$upqty = (int)$data['tempproddetails']['product_qty'] * (int)$data['proddetails']['stripsinbox'] * (int)$data['proddetails']['pcsinstrip'];
			$stock = (int)$data['proddetails']['product_qty'] + (int)$upqty;
			print_r($stock);
			$data = array(
				'product_qty'=>$stock,
			);
			
			}else if($uom === 'Strips'){
			$upqty = (int)$data['tempproddetails']['product_qty'] *  (int)$data['proddetails']['pcsinstrip'];
			$stock = (int)$data['proddetails']['product_qty'] + (int)$upqty;
			
			print_r($stock);
			$data = array(
				'product_qty'=>$stock,
			);
			}else if($uom === 'Pcs'){
			$upqty = (int)$data['tempproddetails']['product_qty'];
			$stock = (int)$data['proddetails']['product_qty'] + (int)$upqty;
			print_r($stock);
			$data = array(
				'product_qty'=>$stock,
			);
			}
			
			$this->Product_model->update_stock($data,$batch);
		
		
		
		
		
		redirect(base_url().'Invoice/createinvoice');  
	}
	
	public function prodcount_check($str)
        {
                if ($str == '0')
                {
                        $this->form_validation->set_message('prodcount_check', 'Add atleast one product to list');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
	
	
	public function invoicelist()
	{
		if(strtoupper($_SESSION['USER_TYPE']) == 'ADMIN'){	
		$data['invoice'] = $this->Invoice_model->view_invoice_details_admin('DESC');
		}else{
		$data['invoice'] = $this->Invoice_model->view_invoice_details('DESC');
		}
		$data['title'] = "Invoice Details";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Invoice/invoicelist');
		$this->load->view('Home/footer');
	}
	
	public function invoiceview()
	{
		$id = $this->uri->segment(3);
	
		if ($id==0)
		{
			$this->index();			
		}	
		
		$data['invoice_header'] = $this->Invoice_model->get_invoice_header_details_to_view($id);
		$data['invoice_body'] = $this->Invoice_model->get_invoice_product_details_to_view($id);
		
		$data['title'] = "Invoice view";
		$this->load->view('Home/header',$data);
		$this->load->view('Home/menu');
		$this->load->view('Invoice/invoiceview',$data);
		$this->load->view('Home/footer'); 
	}
	
	
	
	
	
	
	
	
	
	
	
	
}
