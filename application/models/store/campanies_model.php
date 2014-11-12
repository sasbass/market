<?php
class Campanies_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function add($data){
		if(!empty($data)) {
			return $this->save(__TBL_COMPANIES, $data);
		}
	}
	
	public function edit($id, $data){
		if($id && !empty($data)){
			return $this->save(__TBL_COMPANIES, $data, $id);
		} else return false;
	}
	
	public function getRow($id){
		if($id){
			$query = $this->db->query("
				SELECT * 
				FROM `" . __TBL_COMPANIES . "`
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
			$this->db->delete(__TBL_COMPANIES, array('id' => $id));
		} else return false;
	}
	
}