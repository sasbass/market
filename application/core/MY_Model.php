<?php
class MY_Model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function getVat(){
		$this->db->where("name","vat");
		$query = $this->db->get(__TBL_SETTINGS);
		if(sizeof($query->row())>0){
			return $query->row()->value;
		} else false;
	}
	
	public function getUnit(){
		$this->db->where("name","unit");
		$query = $this->db->get(__TBL_SETTINGS);
		if(sizeof($query->row())>0){
			return $query->row()->value;
		} else false;
	}
	
	/**
	 * Transaction
	 * @param array $query - Queries for execute.
	 * @param array $lock - array("table","table_more"...)
	 * @return boolean
	 */
	public function getTransaction($query, $lock=array()){
		$flag = false;
		if(sizeof($lock)>0) {
			$buff = array();
			foreach($lock as $l) {
				$buff[] = $l." WRITE";
			}
			$buff = implode(",",$buff);
			$this->db->query("LOCK TABLES ".$buff);
		}
		
		$this->db->trans_begin();
		
		if(is_array($query)) {
			foreach ($query as $str) {
				$this->db->query($str);
			}
		}
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$flag = true;
		}
		if(sizeof($lock)>0) $this->db->query("UNLOCK TABLES");
		return $flag;
	}
	
	public function _group_by($array, $key) {
	    $return = array();
	    foreach($array as $val) {
	        $return[$val[$key]][] = $val;
	    }
	    return $return;
	}
}