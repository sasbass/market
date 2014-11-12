<?php
class Index_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
    
    public function updateUserData($data, $cashier_id=0){
        if($cashier_id==0 || empty($data)) return false;
        $this->db->where('id',$cashier_id);
        $this->db->update(__TBL_USERS, $data);
        echo $this->db->last_query();
    }


    public function getUserData($cashier_id=0){
        if($cashier_id==0) return false;
        $this->db->where('id',$cashier_id);
        $query = $this->db->get(__TBL_USERS);
        if(sizeof($query->row())>0){
            return $query->row_array();
        }
        return false;
    }
	
	public function login($data){
		if(isset($data)) {
			$query = $this->db->query("
				SELECT id, username
				FROM `" . __TBL_USERS . "`
				WHERE username = ".$this->db->escape($data["store"])."
					AND `password` = MD5(".$this->db->escape($data["password"]).")
			");
			if(sizeof($query->row())>0) {
				return $query->row();
			} else return false;
		}
	}
	
	public function getList($search='', $limit = NULL, $offset = NULL){

		$this->db->select("p.*, u.first_name, u.last_name");
		$this->db->from(__TBL_PRODUCTS." AS p");
		$this->db->join(__TBL_USERS." AS u","u.id = p.user_id","left");
		$this->db->like("u.first_name",$search);
		$this->db->or_like("u.last_name",$search);
		$this->db->or_like("p.barcode",$search);
		$this->db->or_like("p.name",$search);
		$this->db->order_by("p.id");
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		if(sizeof($query->result())>0) {
			return $query->result();
		} else return false;
	}

	public function TotatlRows($search=''){
		$this->db->like("u.first_name",$search);
		$this->db->or_like("u.last_name",$search);
		$this->db->or_like("p.barcode",$search);
		$this->db->or_like("p.name",$search);
		$this->db->from(__TBL_PRODUCTS." AS p");
		$this->db->join(__TBL_USERS." AS u","u.id = p.user_id","left");
		return $this->db->count_all_results();
	}
	
	public function add($data){
		if(!empty($data)) {
			return $this->save(__TBL_PRODUCTS, $data);
		}
	}
	
	public function edit($id, $data){
		if($id && !empty($data)){
			return $this->save(__TBL_PRODUCTS, $data, $id);
		} else return false;
	}
    
    public function productLog($id, $data, $action){
        if(empty($data)) return;
        $data = array(
            'user_id'=> $this->session->userdata['user_data']->id,
            'product_id'=>$id,
            'quality_in'=>$data['quality_in'],
            'delivery_price'=>$data['delivery_price'],
            'market_price'=>$data['market_price'],
            'added_date'=>date(__DATE_PRODUCT),
            'action'=>$action
        );
        $this->db->insert(__TBL_PRODUCTS_LOG, $data);
    }

    public function getRow($id){
		if($id){
			$query = $this->db->query("
				SELECT *
				FROM `" . __TBL_PRODUCTS . "`
				WHERE id = ".$id."
			");
			if(sizeof($query->row())>0){
				return $query->row();
			} else return false;
		} else return false;
	}
	
	public function save($table, $data, $id=0){
		if($id){
			$this->db->where('id', $id);
			$this->db->update($table, $data);
			return $id;
		} else {
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
	}
	
	public function delete($id){
		if($id){
			$this->db->delete(__TBL_PRODUCTS, array('id' => $id));
		} else return false;
	}
}