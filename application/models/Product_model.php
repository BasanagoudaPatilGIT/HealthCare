<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function add_record($data)
	{
		//SELECT MAX ID
		$max_id = 1;
		$this->db->select_max('id');
		$query = $this->db->get('tab_product');
		$row = $query->row();
		if (isset($row))
		{
			$max_id = $row->id + 1;
		}
		
		$data['id'] = $max_id;
		return $this->db->insert('tab_product', $data);
	}
	
	
	public function edit_record($data,$id)
    {
    $this->db->where('id', $id);
    $this->db->update('tab_product', $data);		
    }
	
	public function update_stock($data,$batch)
    {
    $this->db->where('batchno', $batch);
    $this->db->update('tab_product', $data);		
    }
	
	
	public function incriment_productcode_no($data,$userid)
    {
	$this->db->select_max('continues_count');
	$this->db->where('series_id', 'P');
	$this->db->where('user_id', $userid);
	$query = $this->db->get('tab_series');
	$row = $query->row();
	if (isset($row))
	{
		$max_id = $row->continues_count + 1;
	}
		
	$data['continues_count'] = $max_id;
	
	
    $this->db->where('id', $id);
    $this->db->update('tab_series', $data);		
    }
	
	
	
	public function view_record($order_by = '')
    {
    $this->db->select('p.*');
	$this->db->from('tab_product as p');
	$this->db->where('p.user_id', $_SESSION['ID']);
    if($order_by != ''){
    $this->db->order_by('p.product_qty',$order_by);
    }
    $query = $this->db->get();		
    return $query->result_array();
    }
	
	public function view_record_admin($order_by = '')
    {
    $this->db->select('p.*,r.*');
	$this->db->from('tab_product as p');
	$this->db->join('tab_registration as r', 'r.id = p.user_id','left');
    if($order_by != ''){
    $this->db->order_by('p.product_qty',$order_by);
    }
    $query = $this->db->get();		
    return $query->result_array();
    }
	
	
	public function get_productcode($userid)
    {
	$this->db->select('p.*');
	$this->db->from('tab_series as p');
	$this->db->join('tab_registration as r', 'r.ent_id = p.user_id','left');
	$this->db->where('r.id', $userid);
	$this->db->where('p.series_id', 'P');
	$query = $this->db->get();
	
	return $query->row_array();
    }
	
	public function get_product_based_on_batch($batch)
    {
	$this->db->select('p.*');
	$this->db->from('tab_product as p');
	$this->db->where('p.batchno', $batch);
	$query = $this->db->get();
	
	return $query->row_array();
    }
	
	public function get_record_by_id($id)
    {
	$this->db->select('p.*');
	$this->db->from('tab_product as p');
	$this->db->where('p.id', $id);
	$query = $this->db->get();
	
	return $query->row_array();
    }
	
	
	public function get_record_by_batch($batch)
    {
	$this->db->select('p.*');
	$this->db->from('tab_product as p');
	$this->db->where('p.batchno', $batch);
	$query = $this->db->get();
	
	return $query->row_array();
    }
	
	public function get_temp_record_by_id($id)
    {
	$this->db->select('p.*');
	$this->db->from('tab_temp_invoice as p');
	$this->db->where('p.id', $id);
	$query = $this->db->get();
	
	return $query->row_array();
    }
	
	public function product_count()
    {
    return $this->db->count_all_results('tab_product');
    }
	
 }