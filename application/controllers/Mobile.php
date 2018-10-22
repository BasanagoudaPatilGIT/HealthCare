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
		
		$query = $this->Mobile_model->validate($email_id,$password,$imei);
		if($query)
		{
		$todaysdate = date('Y-m-d');
		$exp = $this->Mobile_model->validate_expiry($imei,$todaysdate);
		if(!$exp){
			$login_failed_data[] = array('loginFailed' => 'Your application service got expired');
			print_r(json_encode($login_failed_data));
		}else{
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
			$invoicecount = $this->Invoice_model->patient_count($data['login']['id']);
			$totalamount = $this->Invoice_model->total_amount($data['login']['id']);
			$datestring = date('Y-m-d');
			$todayamount = $this->Invoice_model->todays_total_amount($data['login']['id'],$datestring);
		
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
									'totalStockCount' => $totalstockcount,
									'lowStockCount' => $lowstockcount,
									'inStockCount' => $instockcount,
									'pendingAppointments' => 3,
									'totalPatients'=> $patientcount,
									'totalinvoices'=> $invoicecount,
									'totalAmount'=> $totalamount['amount'],
									'todayAmount'=> $todayamount['amount'],
									
									
			);
			
			$menu_array[] = array(
								  'mypurchase' => "Order",
								  'stockDetails' => "Stock",
								  'getproductcode' => "New Med",
								  'invoiceList' => "Invoice",
								  'getinvoicecode' => "Invoice",
								  'mobiLogout' => "Logout"
			);
			
		
			
		
			$mobile_login_data[] = array('userDetails' => $user_array,
									 'menuDetails' => $menu_array,
				);
			print_r(json_encode($mobile_login_data));
			}
		
		}else
		{
			$login_failed_data[] = array('message' => 'Invalid Credentials');
			print_r(json_encode($login_failed_data));				
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
								'producttype' => $row['product_type'],
								'createddatetime' => $row['createddatetime'],
								'status' => $row['status'],
								'user_id' => $row['user_id'],
								'qtylimit' => $row['qtylimit'],
								'packdate' => $row['packdate'],
								'expirydate' => $row['expirydate'],
								'stripsinbox' => $row['stripsinbox'],
								'pcsinstrip' => $row['pcsinstrip'],
								'bottlesinbox' => $row['bottlesinbox'],
								'mlinbottle' => $row['mlinbottle'],
								'mrp' => $row['mrp'],
								'salerate' => $row['salerate'],
								'purrate' => $row['purrate'],
								'abtproduct' => $row['abtproduct'],
								'batchno' => $row['batchno'],
								'tax_percent' => $row['tax_percent']
		
		);
		
		$low_stock_data[] = array('nextMethod' => 'updateproduct', 
								  'lowstock' => $low_stock,
				);
				
				
		print_r(json_encode($low_stock_data));
		}else{
		$no_low_stock_data[] = array('message' => 'No Items Found.'
				);
				
		print_r(json_encode($no_low_stock_data));
		}
	}
	
	public function stockdetails()
	{
		$userid = 2;
		//$userid = $this->input->post('userId');
		$stock = $this->Mobile_model->stock_details('DESC',$userid);				
		
		if(count($stock) >0){
		foreach($stock as $row)
		$all_stock[] = array('product_id' =>$row['id'],
								'product_code' => $row['product_code'],
								'producttype' => $row['product_type'],
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
								'bottlesinbox' => $row['bottlesinbox'],
								'mlinbottle' => $row['mlinbottle'],
								'mrp' => $row['mrp'],
								'salerate' => $row['salerate'],
								'purrate' => $row['purrate'],
								'abtproduct' => $row['abtproduct'],
								'batchno' => $row['batchno'],
								'tax_percent' => $row['tax_percent']
		
		);
		
		$all_stock_data[] = array('nextMethod' => 'updateproduct',
								  'stockdetails' => $all_stock
				);
				
		print_r(json_encode($all_stock_data));
		}else{
		$no_stock_data[] = array('message' => 'No Items Found.'
				);
				
		print_r(json_encode($no_stock_data));
		}
	}
	
	public function getproductcode()
	{
	$userId = $this->input->post('userId');
	//$userId = 2;
	$data['auto_code'] = $this->Product_model->get_productcode($userId);
	//print_r($data['auto_code']);
	$prodcode = $data['auto_code']['series_id'].''.$data['auto_code']['user_id'].'-'.$data['auto_code']['continues_count'];
					
					
	$product_data[] = array('nextMethod' => 'addproduct',
								 'productcode' => $prodcode,
								 'productcount' =>$data['auto_code']['continues_count']
	);
			print_r(json_encode($product_data));
	
	}
	
	public function addproduct()
	{
	    $prodtype = $this->input->post('producttype');
		$productcount = (int)$this->input->post('productcount');
		$uom = $this->input->post('cbo_uom');
		$prodqty = $this->input->post('productqty');
		$userId = $this->input->post('userId');
		$entId = $this->input->post('entId');
		$prodcode = $this->input->post('productcode');
		//print_r($uom);
		if($uom === 'Boxes'){
			if($prodtype === "Tablet"){
				$prodqty = $this->input->post('productqty') * $this->input->post('strips') * $this->input->post('pcs');
			}else if($prodtype === "Liquid"){
				$prodqty = $this->input->post('productqty') * $this->input->post('botinbox') * $this->input->post('mlinbot');
			}
			
		}elseif($uom === 'Strips'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('pcs');
		}elseif($uom === 'Pcs'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty');
		}elseif($uom === 'Bottles'){
			$prodqty = $this->input->post('productqty') * $this->input->post('mlinbot');
		}elseif($uom === 'Ml'){
			$prodqty = $this->input->post('productqty');
		}
		
		$batchno = $prodcode.'-'.(String)$this->input->post('expdate').'-'.(int)$this->input->post('mrp').'-'.(int)$this->input->post('purrate').'-'.(int)$this->input->post('salerate');
		
		if($prodtype === "Tablet"){
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
				'bottlesinbox'=>1,
				'mlinbottle'=>1,
				'pcsinstrip'=>$this->input->post('pcs'),
				'qtylimit'=>$this->input->post('qtylmt'),
				'tax_percent'=>$this->input->post('taxper')
				
			);	
			$this->Product_model->add_record($data);
		}else if($prodtype === "Liquid"){
			$data =array
			(
				'status'=>'Active',
				'user_id'=>$userId,
				'product_code'=>$prodcode,
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
				'stripsinbox'=>1,
				'pcsinstrip'=>1,
				'qtylimit'=>$qtylmt,
				'tax_percent'=>$this->input->post('taxper'),
				'product_type'=>$prodtype
				
			);	
			$this->Product_model->add_record($data);
		}
			
			$datestring = date('Y-m-d');			
			$data =array
			(
				'last_updated'=>mdate($datestring),
				'continues_count' => (int)$productcount + 1 
				
			);
		
			$this->Mobile_model->incriment_productcode_no($data,$entId);
			
			$new_product_added[] = array('message' => 'New medicine added successfully');
				
			print_r(json_encode($new_product_added));
	}
	
	
	public function updateproduct()
	{
		$id = $this->input->post('product_id');
		$prodtype = $this->input->post('producttype');
		$userId = $this->input->post('userId');
		$entId = $this->input->post('entId');
		$prodcode = $this->input->post('productcode');
		$batchno = $this->input->post('productcode').'-'.(String)$this->input->post('expdate').'-'.(int)$this->input->post('mrp').'-'.(int)$this->input->post('purrate').'-'.(int)$this->input->post('salerate');
		if($batchno === $this->input->post('batchno')){
		$uom = $this->input->post('cbo_uom');
		$prodqty = $this->input->post('productqty');
		//print_r($uom);
		if($uom === 'Boxes'){
			if($prodtype === "Tablet"){
				$prodqty = $this->input->post('productqty') * $this->input->post('strips') * $this->input->post('pcs') + $this->input->post('curqty');
			}else if($prodtype === "Liquid"){
				$prodqty = $this->input->post('productqty') * $this->input->post('botinbox') * $this->input->post('mlinbot') + ($this->input->post('curqty') * $this->input->post('mlinbot'));
			}
				
		}elseif($uom === 'Strips'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('pcs') + $this->input->post('curqty');
		}elseif($uom === 'Pcs'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') + $this->input->post('curqty');
		}elseif($uom === 'Bottles'){
			$prodqty = $this->input->post('productqty') * $this->input->post('mlinbot') + ($this->input->post('curqty') * $this->input->post('mlinbot'));
		}elseif($uom === 'Ml'){
			$prodqty = $this->input->post('productqty') + ($this->input->post('curqty') * $this->input->post('mlinbot'));
		}
		
		if($prodtype === "Tablet"){
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
				'bottlesinbox'=>1,
				'mlinbottle'=>1,
				'pcsinstrip'=>$this->input->post('pcs'),
				'qtylimit'=>$this->input->post('qtylmt'),
				'tax_percent'=>$this->input->post('taxper')
				
			);	
			$this->Product_model->edit_record($data,$id);
		}else if($prodtype === "Liquid"){
			$data =array
			(
				'status'=>'Active',
				'user_id'=>$userId,
				'product_code'=>$prodcode,
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
				'stripsinbox'=>1,
				'pcsinstrip'=>1,
				'qtylimit'=>$qtylmt,
				'tax_percent'=>$this->input->post('taxper'),
				'product_type'=>$prodtype
				
			);	
			$this->Product_model->edit_record($data,$id);
		}
			
		}else{
		$uom = $this->input->post('cbo_uom');
		$prodqty = $this->input->post('productqty');
		if($uom === 'Boxes'){
			if($prodtype === "Tablet"){
				$prodqty = $this->input->post('productqty') * $this->input->post('strips') * $this->input->post('pcs');
			}else if($prodtype === "Liquid"){
				$prodqty = $this->input->post('productqty') * $this->input->post('botinbox') * $this->input->post('mlinbot');
			}
			
		}elseif($uom === 'Strips'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty') * $this->input->post('pcs');
		}elseif($uom === 'Pcs'){
			//print_r($uom);
			$prodqty = $this->input->post('productqty');
		}elseif($uom === 'Bottles'){
			$prodqty = $this->input->post('productqty') * $this->input->post('mlinbot');
		}elseif($uom === 'Ml'){
			$prodqty = $this->input->post('productqty');
		}
		
		if($prodtype === "Tablet"){
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
				'bottlesinbox'=>1,
				'mlinbottle'=>1,
				'pcsinstrip'=>$this->input->post('pcs'),
				'qtylimit'=>$this->input->post('qtylmt'),
				'tax_percent'=>$this->input->post('taxper')
				
			);	
			$this->Product_model->add_record($data);
		}else if($prodtype === "Liquid"){
			$data =array
			(
				'status'=>'Active',
				'user_id'=>$userId,
				'product_code'=>$prodcode,
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
				'stripsinbox'=>1,
				'pcsinstrip'=>1,
				'qtylimit'=>$qtylmt,
				'tax_percent'=>$this->input->post('taxper'),
				'product_type'=>$prodtype
				
			);	
			$this->Product_model->add_record($data);
		}
		
			$product_updated[] = array('message' => 'medicine updated successfully');
				
			print_r(json_encode($product_updated));

	}
	}
	public function getinvoicecode()
	{
	$userId = $this->input->post('userId');
	//$userId = 2;
	$data['auto_code'] = $this->Mobile_model->get_invoicecode($userId);
	//print_r($data['auto_code']);
	$invoicecode = $data['auto_code']['series_id'].''.$data['auto_code']['user_id'].'-'.$data['auto_code']['continues_count'];
					
					
	$invoice_data[] = array('nextMethod' => 'createinvoice',
							 'invoicecode' => $invoicecode,
							 'invoicecount' =>$data['auto_code']['continues_count']
	);
			print_r(json_encode($invoice_data));
	
	}
	
	public function invoiceList()
	{
	$userId = $this->input->post('userId');
	$invoice = $this->Mobile_model->view_invoice_details('DESC',$userId);
	
	/*
	print_r($invoice);
	*/
					
	if(count($invoice) >0){
		foreach($invoice as $row)
		$all_invoice[] = array('invoice_id' =>$row['id'],
								'fees' =>$row['fees'],
								'invoice_no' =>$row['invoice_no'],
								'patient_name' =>$row['patient_name'],
								'patient_gender' =>$row['patient_gender'],
								'patient_phoneno' =>$row['patient_phoneno'],
								'patient_address' =>$row['patient_address'],
								'user_id' =>$row['user_id'],
								'created_datetime' =>$row['created_datetime'],
								'invoice_amt' =>$row['invoice_amt'],
								'total_tax_amt' =>$row['total_tax_amt'],
								'total_gross_amt' =>$row['total_gross_amt'],
								'created_date' =>$row['created_date'],
								'first_name' =>$row['first_name'],
								'last_name' =>$row['last_name']
								
		
		);
		
		$all_invoice_data[] = array('nextMethod' => 'getinvoicecode',
								  'invoicedetails' => $all_invoice
				);
				
		print_r(json_encode($all_invoice_data));
		}else{
		$no_invoice_data[] = array('message' => 'No Items Found.'
				);
				
		print_r(json_encode($no_invoice_data));
		}		
	
	
	}
	
	
	
	public function createinvoice()
	{
		$userId = $this->input->post('userId');
		$entId = $this->input->post('entId');
		$invoicecount = (int)$this->input->post('invoiceCount');
		
		
		$datestring = date('Y-m-d');
		$data =array
			(
				'user_id'=>$userId,
				'patient_name'=>$this->input->post('patientName'),
				'patient_gender'=>$this->input->post('patientGender'),
				'patient_phoneno'=>$this->input->post('patientPhNo'),
				'age'=>$this->input->post('patientAge'),
				'patient_address'=>$this->input->post('patientAdd'),
				'invoice_amt'=>$this->input->post('invoiceTotal'),
				'total_tax_amt'=>$this->input->post('invoiceTax'),
				'created_date'=>$datestring,
				'fees'=>$this->input->post('invoiceFees'),
				'total_gross_amt'=>$this->input->post('invoiceGross'),
				'invoice_no'=>$this->input->post('invoiceCode'),
				
			);			
			
		$this->Mobile_model->add_patient_record($data);
		
		
		$data = $this->input->post('invoiceProductList');
		
		$data = json_decode($data);
		
		for($i=0; $i <= count($data); $i++){
		print_r($data[$i]->{'productId'});
		
		
		print_r($data[$i]->{'productName'});	
		
		
		print_r($data[$i]->{'productCode'});	
		
		
		print_r($data[$i]->{'productType'});
		
			
		print_r($data[$i]->{'productSaleRate'});	
		
		
		print_r($data[$i]->{'productTaxPer'});	
		
		
		print_r($data[$i]->{'productTaxAmt'});	
		
		
		print_r($data[$i]->{'productUOM'});
		
			
		print_r($data[$i]->{'productQty'});
		
			
		print_r($data[$i]->{'productGross'});
		
		
		print_r($data[$i]->{'productTotal'});
		
			
		print_r($data[$i]->{'productTotal'});
		
				
		print_r($data[$i]->{'productStock'});	
		
			
		print_r($data[$i]->{'productBatchNo'});	
		
		}
			
			
		$datestring = date('Y-m-d');			
			$data =array
			(
				'last_updated'=>mdate($datestring),
				'continues_count' => (int)$invoicecount + 1 
				
			);
			//print_r($data);
			$this->Mobile_model->incriment_invoice_no($data,$entId);*/
			
			$new_invoice_generated = array('message' => 'Invoice generated successfully');
				
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
	
}
