<?php 

class Mobile_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}
	
	public function validate($mailid,$password,$imei)
	{
		$this->db->where('email_id', $mailid );
		$this->db->where('password', $password );
		$this->db->where('imei', $imei );
		$query= $this->db->get('tab_registration');
		//print_r( $query->row_array());
		if($query->num_rows() == 1)
		{
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	public function validate_expiry($imei,$todaysdate)
	{
		$this->db->where('imei',$imei);
		$this->db->where('service_expiry_Date >=', $todaysdate);
		$query= $this->db->get('tab_registration');
		//print_r( $query->row_array() );
		if($query->num_rows() == 1)
		{
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	public function incriment_productcode_no($data,$userid)
    {
	$this->db->where('series_id', 'P');
	$this->db->where('user_id', $userid);
	$this->db->update('tab_series', $data);	
    }
	
	public function incriment_invoice_no($data,$userid)
    {
	$this->db->where('series_id', '#I');
	$this->db->where('user_id', $userid);
	$this->db->update('tab_series', $data);	
    }
	
	public function get_user_detail($email_id,$password)
	{
		$this->db->select('r.*,d.designation,s.speciality,s.abtspeciality');
		$this->db->from('tab_registration as r');
		$this->db->where('email_id', $email_id);
		$this->db->where('password', $password);
		$this->db->join('tab_designation as d', 'd.id = r.user_type','left');
		$this->db->join('tab_speciality as s', 's.id = r.speciality','left');
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	public function send_mail($email_id)
	{
		$this->db->select('r.*,d.designation');
		$this->db->from('tab_registration as r');
		$this->db->where('email_id', $email_id);
		$this->db->join('tab_designation as d', 'd.id = r.user_type','left');
		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	public function update_logout($data,$id)
    {
    $this->db->where('id', $id);
    $this->db->update('tab_registration', $data);		
    }
	
	 public function low_stock_details($userid)
    {
    $sql = "select p.* from tab_product as p join tab_product as q on (p.id = q.id) where p.product_qty <= q.qtylimit and p.user_id = ? and p.status = ?";
    $query = $this->db->query($sql,array($userid,'Active'));
    return $query->result_array();
    }
	
	public function stock_details($order_by = '',$userid)
    {
    $this->db->select('p.*');
	$this->db->from('tab_product as p');
	$this->db->where('p.user_id', $userid);
    if($order_by != ''){
    $this->db->order_by('p.product_qty',$order_by);
    }
    $query = $this->db->get();		
    return $query->result_array();
    }
	
	public function all_stock_count($id)
    {
    $this->db->where('user_id', $id);
    $this->db->where('product_qty !=', 0);
	return $this->db->count_all_results('tab_product');	
    }
	
	public function auto_featch_low_stock($prodname,$userid)
    {
	$this->db->select('*');
	$this->db->like('product_name',$prodname,'BOTH');
    $this->db->where('user_id', $userid);
    $this->db->where('product_qty >', 0);
	$this->db->order_by('product_qty','ASC');
    return $this->db->get('tab_product')->result();
	
	
    }
	
	public function get_invoicecode($userid)
    {
	$this->db->select('p.*');
	$this->db->from('tab_series as p');
	$this->db->join('tab_registration as r', 'r.ent_id = p.user_id','left');
	$this->db->where('r.id', $userid);
	$this->db->where('p.series_id', '#I');
	$query = $this->db->get();
	
	return $query->row_array();
    }
	
	public function view_invoice_details($order_by = '',$userId)
    {
    $this->db->select('h.*,r.first_name,r.last_name');
    $this->db->from('tab_invoice_h as h');
	$this->db->where('user_id', $userId);
	$this->db->join('tab_registration as r', 'r.id = h.user_id', 'left');
    if($order_by != ''){
    $this->db->order_by('h.id',$order_by);
    }
    $query = $this->db->get();		
    return $query->result_array();
    }
 }