<?php 
class Mobile extends CI_Controller {

	public function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->model('Mobile_model');
		$this->load->model('Product_model');
		$this->load->model('Invoice_model');
		$this->load->library('encrypt');	
		
	}
	
	
	function validate_credentials()
	{
		$this->load->model('Mobile_model');	
		$email_id = $this->input->post('email_id');
		//$imei = $this->input->post('imei');
		$password = base64_encode($this->input->post('password'));
		//$email_id = "vinod@gmail.com";
		$imei = 0;
		//$password = base64_encode("9964546749");
		$todaysdate = date('Y-m-d');
		$exp = $this->Mobile_model->validate_expiry($imei,$todaysdate);
		if(!$exp){
			$login_failed_data[] = array('loginFailed' => 'Your application service got expired');
			print_r(json_encode($login_failed_data));
		}else{
		$query = $this->Mobile_model->validate($email_id,$password,$imei);
		if($query)
		{
			$data['login'] = $this->Mobile_model->get_user_detail($email_id,$password);
			$mobilogin = 1;
			$userid = $data['login']['id'];
			//$mobilogin = $this->input->post('mobi_login');
			//$userid = $this->input->post('userid');
			$data = array(
							'mobi_login' => $mobilogin
							);
							
			$this->Mobile_model->update_logout($data,$userid);
			$data['login'] = $this->Mobile_model->get_user_detail($email_id,$password);
			$totalstockcount = $this->Mobile_model->all_stock_count($data['login']['id']);	
			$lowstockcount = COUNT($this->Mobile_model->low_stock_details($data['login']['id']));	
			$instockcount = (int)$totalstockcount - (int)$lowstockcount;
			
			$patientcount = $this->Invoice_model->patient_count($data['login']['id']);
			$totalamount = $this->Invoice_model->total_amount($data['login']['id']);
			$datestring = date('Y-m-d');
			$totdayamount = $this->Invoice_model->todays_total_amount($data['login']['id'],$datestring);
		
			//print_r($login);
			$user_array[] = array('userId' => $data['login']['id'],
									'entId' => $data['login']['ent_id'],
									'name' => $data['login']['first_name'].' '.$data['login']['last_name'],
									'mobileNo' => $data['login']['mobile_no'],
									'emailId' => $data['login']['email_id'],
									'imageName' => $data['login']['img_name'],
									'designation' => $data['login']['designation'],
									'speciality' => $data['login']['speciality'],
									'abtSpeciality' => $data['login']['abtspeciality'],
									'totalstockcount' => $totalstockcount,
									'lowstockcount' => $lowstockcount,
									'instockcount' => $instockcount,
									'pendingappointments' => 3,
									'totalpatients'=> $patientcount,
									'totalamount'=> $totalamount,
									'totdayamount'=> $totdayamount,
									
									
			);
			
			$menu_array[] = array(
								  'mypurchase' => "Order",
								  'stockDetails' => "Stock",
								  'getproductcode' => "Add Medicine",
								  'getinvoicecode' => "Invoice",
								  'mobiLogout' => "Logout"
			);
			
		
			
		
			$mobile_login_data[] = array('userDetails' => $user_array,
									 'menuDetails' => $menu_array,
				);
			print_r(json_encode($mobile_login_data));
			}
		else
		{
			$login_failed_data[] = array('loginFailed' => 'Invalid Credentials');
			print_r(json_encode($login_failed_data));				
		}
		}
		
		
		
	}
	
	
	public function mypurchase()
	{
		//$userid = 2;
		$userid = $this->input->post('userId');
		$lowstock = $this->Mobile_model->low_stock_details($userid);				
		
		if(count($lowstock) >0){
		foreach($lowstock as $row)
		$low_stock[] = array('product_id' =>$row['id'],
								'product_code' => $row['product_code'],
								'product_name' =>  $row['product_name'],
								'product_qty' => $row['product_qty'],
								'createddatetime' => $row['createddatetime'],
								'status' => $row['status'],
								'user_id' => $row['user_id'],
								'qtylimit' => $row['qtylimit'],
								'packdate' => $row['packdate'],
								'expirydate' => $row['expirydate'],
								'stripsinbox' => $row['stripsinbox'],
								'pcsinstrip' => $row['pcsinstrip'],
								'mrp' => $row['mrp'],
								'salerate' => $row['salerate'],
								'purrate' => $row['purrate'],
								'abtproduct' => $row['abtproduct'],
								'batchno' => $row['batchno'],
								'tax_percent' => $row['tax_percent']
		
		);
		
		$low_stock_data[] = array('product_search' => 'Medicine Search', 
								  'lowstock' => $low_stock,
				);
				
		echo json_encode($low_stock_data);
		}else{
		$no_low_stock_data[] = array('noItems' => 'No Items Found.'
				);
				
		echo json_encode($no_low_stock_data);
		}
	}
	
	public function stockdetails()
	{
		//$userid = 2;
		$userid = $this->input->post('userId');
		$stock = $this->Mobile_model->stock_details('DESC',$userid);				
		
		if(count($stock) >0){
		foreach($stock as $row)
		$all_stock[] = array('product_id' =>$row['id'],
								'product_code' => $row['product_code'],
								'product_name' =>  $row['product_name'],
								'product_qty' => $row['product_qty'],
								'createddatetime' => $row['createddatetime'],
								'status' => $row['status'],
								'user_id' => $row['user_id'],
								'qtylimit' => $row['qtylimit'],
								'packdate' => $row['packdate'],
								'expirydate' => $row['expirydate'],
								'stripsinbox' => $row['stripsinbox'],
								'pcsinstrip' => $row['pcsinstrip'],
								'mrp' => $row['mrp'],
								'salerate' => $row['salerate'],
								'purrate' => $row['purrate'],
								'abtproduct' => $row['abtproduct'],
								'batchno' => $row['batchno'],
								'tax_percent' => $row['tax_percent']
		
		);
		
		$all_stock_data[] = array('product_search' => 'Medicine Search',
								  'stockdetails' => $all_stock
				);
				
		echo json_encode($all_stock_data);
		}else{
		$no_stock_data[] = array('noItems' => 'No Items Found.'
				);
				
		echo json_encode($no_stock_data);
		}
	}
	
	
	
	
	public function getproductcode()
	{
	$userId = $this->input->post('userId');
	//$userId = 2;
	$data['auto_code'] = $this->Product_model->get_productcode($userId);
	//print_r($data['auto_code']);
	$prodcode = $data['auto_code']['series_id'].''.$data['auto_code']['user_id'].'-'.$data['auto_code']['continues_count'];
					
					
	$product_data[] = array('addproduct' => 'New Medicine',
								 'productcode' => $prodcode,
								 'productcount' =>$data['auto_code']['continues_count']
	);
			print_r(json_encode($product_data));
	
	}
	
	public function addproduct()
	{
	    
		$productcount = (int)$this->input->post('productcount');
		$uom = $this->input->post('cbo_uom');
		$prodqty = $this->input->post('productqty');
		$userId = $this->input->post('userId');
		$entId = $this->input->post('entId');
		$prodcode = $this->input->post('productcode');
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
		
		$batchno = $prodcode.'-'.(String)$this->input->post('expdate').'-'.(int)$this->input->post('mrp').'-'.(int)$this->input->post('purrate').'-'.(int)$this->input->post('salerate');
		
		
		
		$data =array
			(
				'status'=>'Active',
				'user_id'=>$userId,
				'product_code'=>$prodcode,
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
				'tax_percent'=>$this->input->post('taxper')
				
			);	
			$this->Product_model->add_record($data);

			$datestring = date('Y-m-d');			
			$data =array
			(
				'last_updated'=>mdate($datestring),
				'continues_count' => (int)$productcount + 1 
				
			);
		
			$this->Mobile_model->incriment_productcode_no($data,$entId);
			
			$new_product_added[] = array('prodAdded' => 'New medicine added successfully');
				
			print_r(json_encode($new_product_added));
	}
	
	
	public function getinvoicecode()
	{
	$userId = $this->input->post('userId');
	//$userId = 2;
	$data['auto_code'] = $this->Mobile_model->get_invoicecode($userId);
	//print_r($data['auto_code']);
	$invoicecode = $data['auto_code']['series_id'].''.$data['auto_code']['user_id'].'-'.$data['auto_code']['continues_count'];
					
					
	$invoice_data[] = array('createinvoice' => 'Invoice',
								 'invoicecode' => $invoicecode,
								 'invoicecount' =>$data['auto_code']['continues_count']
	);
			print_r(json_encode($invoice_data));
	
	}
	
	
	
	public function createinvoice()
	{
		$userId = $this->input->post('userId');
		$entId = $this->input->post('entId');
		$invoicecount = (int)$this->input->post('invoicecount');
		
		/* $auto_code = $this->Product_model->get_productcode($userId);
	    $lineinvoice = $this->Invoice_model->view_record('DESC');
		$Mainsubtotal = $this->Invoice_model->get_total_amount($userId);
		$Maintaxpercent = $this->Invoice_model->get_total_tax_percent($userId);
		$MaintaxAmt = $this->Invoice_model->get_total_tax_amt($userId);
		$MainAmt = $this->Invoice_model->get_total_amt($userId);
		$prodcount = $this->Invoice_model->products_count($userId) ;
		
		
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
			
			$this->Product_model->update_stock($data,$batch); */
			
		
			$datestring = date('Y-m-d');			
			$data =array
			(
				'last_updated'=>mdate($datestring),
				'continues_count' => (int)$invoicecount + 1 
				
			);
			//print_r($data);
			$this->Mobile_model->incriment_invoice_no($data,$entId);
			
			$new_invoice_generated[] = array('invoicegenerated' => 'Invoice generated successfully');
				
			print_r(json_encode($new_invoice_generated));
			
	}
	
	
	public function mobiLogout()
	{
		$mobilogin = 0;
		//$userid = 2;
		$userid = $this->input->post('userId');
		$data = array(
						'mobi_login' => $mobilogin
						);
						
		$this->Mobile_model->update_logout($data,$userid);				
		
	}
	
	
	
	/*public function product_search()
	{
		$userid = $this->input->post('userId');
		$product = $this->input->post('productName');
		$feature = $this->input->post('featureName');
		//$feature = 'stockdetails';
		//$userid = '2';
		//$product = 'Celin';
		if($feature == 'stockdetails'){
		$proddetails = $this->Mobile_model->auto_featch_all_stock($product, $userid);
		}else if($feature == 'mypurchase'){
		$proddetails = $this->Mobile_model->auto_featch_low_stock($product, $userid);
		}
		if(count($proddetails) >0){
		foreach($proddetails as $row)
		$stockinbox = (int)$row->product_qty /((int)$row->stripsinbox * (int)$row->pcsinstrip);
		$stockinstrips = (int)$row->product_qty /(int)$row->pcsinstrip;
		
		$result_array[] = array('label' => $row->product_name,
								'product_id' => $row->id,
								'product_code' => $row->product_code,
								'batchno' => $row->batchno,
								'product_qty' => $row->product_qty,
								'price' => $row->salerate,
								'tax' => $row->tax_percent,
								'stripsinbox' =>$row->stripsinbox,
								'pcsinstrip' =>$row->pcsinstrip,
								'stockinbox' =>(int)$stockinbox,
								'stockinstrips' =>(int)$stockinstrips,
								'createddatetime' => $row->createddatetime,
								'status' => $row->status,
								'user_id' => $row->user_id,
								'qtylimit' => $row->qtylimit,
								'packdate' => $row->packdate,
								'expirydate' => $row->expirydate,
								'mrp' => $row->mrp,
								'salerate' => $row->salerate,
								'purrate' => $row->purrate,
								'abtproduct' => $row->abtproduct,
								'batchno' => $row->batchno,
		);
		
		echo json_encode($result_array);
		}
					
		
	}*/
}
