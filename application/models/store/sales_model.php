<?php
class Sales_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
    
    public function getSalesData($id){
        if(!is_array($id)) return;
        $this->db->select("p.name,SUM(s.quantity) AS quantity,p.market_price,SUM(p.market_price*s.quantity) AS total",false);
        $this->db->from(__TBL_SALES . ' AS s');
        $this->db->join(__TBL_PRODUCTS . ' AS p','p.id = s.product_id','inner');
        $this->db->where_in('s.id',$id, false);
        $this->db->group_by('s.product_id');
        $result = $this->db->get();
        if(sizeof($result->result())>0){
            $result->data = $result->result();
            $result->total = $this->getSalesDataTotal($id);
            return $result;
        }
        return false;
    }
    
    private function getSalesDataTotal($id){
        if(!is_array($id)) return;
        $this->db->select("SUM(p.market_price*s.quantity) AS total",false);
        $this->db->from(__TBL_SALES . ' AS s');
        $this->db->join(__TBL_PRODUCTS . ' AS p','p.id = s.product_id','inner');
        $this->db->where_in('s.id',$id, false);
        $result = $this->db->get();
        if(sizeof($result->row())>0){
            return $result->row()->total;
        }
        return false;
        
    }


    public function getList($data){
		$query = $this->db->query("
			SELECT p.id, s.id AS sid, p.barcode, s.quantity, p.name,
				ROUND(SUM(s.quantity*p.market_price),2) AS market_price
			FROM `" . __TBL_SALES . "` AS s
				LEFT JOIN `" . __TBL_PRODUCTS . "` AS p ON p.id = s.product_id
			WHERE s.status ='paid'
				AND s.added_date BETWEEN ".$this->db->escape($data["date_from"])." AND ".$this->db->escape($data["date_to"])."
			GROUP BY s.id DESC
		");
		if(sizeof($query->result())>0) {
			return $query->result();
		} else return false;
	}
	
	public function getTotal($data){
		$query = $this->db->query("
			SELECT ROUND(SUM(s.quantity*p.market_price),2) AS total, COUNT(s.id) AS count_product
			FROM `" . __TBL_SALES . "` AS s
				LEFT JOIN `" . __TBL_PRODUCTS . "` AS p ON p.id = s.product_id
			WHERE s.status ='paid'
				AND s.added_date BETWEEN ".$this->db->escape($data["date_from"])." AND ".$this->db->escape($data["date_to"])."
		");
		if(sizeof($query->row())>0) {
            $result = array(
                'data'=>$query->row(),
                'unic_count_product'=>$this->getUnicProducts($data)
            );
			return $result;
		} else return false;
	}
    
    private function getUnicProducts($data){
        $query = $this->db->query("
            SELECT COUNT(*) AS unic_count_product FROM (SELECT COUNT(s.product_id) AS unic_count_product 
            FROM `" . __TBL_SALES . "` AS s 
                LEFT JOIN `" . __TBL_PRODUCTS . "` AS p ON p.id = s.product_id 
            WHERE s.status ='paid' 
                AND s.added_date BETWEEN ".$this->db->escape($data["date_from"])." AND ".$this->db->escape($data["date_to"])."
            GROUP BY s.product_id) AS c
		");
		if(sizeof($query->row())>0) {
			return $query->row()->unic_count_product;
		} else return false;
    }


    public function getFirstYearOfSales(){
		$query = $this->db->query("
			SELECT YEAR(added_date) AS `year`
			FROM `" . __TBL_SALES . "`
		");
		if(sizeof($query->row())>0){
			return $query->row()->year;
		} else return false;
	}
}