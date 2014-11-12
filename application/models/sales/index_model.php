<?php
class Index_model extends MY_Model {
	public $_start_invoice_number=1000000001;
	
	public function __construct(){
		parent:: __construct();	
	}
    
    public function setClearSales($cashier_id=0){
        if($cashier_id==0) return false;
        $this->db->where('user_id',$cashier_id);
        $this->db->where('status','wait');
        $this->db->update(__TBL_SALES, array('status'=>'clear'));
    }

    /**
	 * Only write.
	 * Return invoice number.
	 * @return mixed
	 */
	public function invoiceNumberGet(){
		$query = $this->db->get(__TBL_INVOICE_NUMBER);
		if(sizeof($query->row())>0) {
			return (int)$query->row()->number;
		} else return false;
	}
	
	/**
	 * Auto increment at invoice number.
	 * @return number
	 */
	public function invoiceNumberUp(){
		$this->db->query("LOCK TABLES `" . __TBL_INVOICE_NUMBER . "` WRITE");
		if($this->invoiceNumberGet()){
			$newinvoice = $this->invoiceNumberGet()+1;
			$this->db->update(__TBL_INVOICE_NUMBER, array("number"=>$newinvoice));
			$this->db->query("UNLOCK TABLES");
			return $newinvoice;
		} else {
			$this->db->insert(__TBL_INVOICE_NUMBER, array("number"=>$this->_start_invoice_number));
			$this->db->query("UNLOCK TABLES");
			return $this->_start_invoice_number;
		}
	}
	
	/**
	 * Return back invoice number.
	 * @return number
	 */
	public function invoiceNumberRollback(){
		$this->db->query("LOCK TABLES `" . __TBL_INVOICE_NUMBER . "` WRITE");
		if($this->invoiceNumberGet()){
			$newinvoice = $this->invoiceNumberGet()-1;
			$this->db->update(__TBL_INVOICE_NUMBER, array("number"=>$newinvoice));
			$this->db->query("UNLOCK TABLES");
			return $newinvoice;
		}
	}
	
	public function login($data){
		if(isset($data)) {
			$query = $this->db->query("
				SELECT *
				FROM `" . __TBL_USERS . "`
				WHERE (
						`username` = ".$this->db->escape($data["cashier"])." OR
						`card_number` = ".$this->db->escape($data["cashier"])."
					)
					AND `password` = MD5(".$this->db->escape($data["password"]).")
			");
			if(sizeof($query->row())>0) {
				return $query->row();
			} else return false;
		}
	} 
	
	public function getList($cashier_id){
		$query = $this->db->query("
			SELECT s.id, p.id AS product_id, p.barcode, 
                SUM(s.quantity) AS quantity, 
                p.name,p.market_price,
                ROUND(SUM(s.quantity*p.market_price),2) AS total
			FROM `" . __TBL_SALES . "` AS s
				INNER JOIN `" . __TBL_PRODUCTS . "` AS p ON p.id = s.product_id
			WHERE s.status ='wait'
				AND s.user_id = " . $cashier_id . "
			GROUP BY p.id
		");
		if(sizeof($query->result())>0) {
			return $query->result();
		} else return false;
	}
	
	public function getTotal($cashier_id){
		$query = $this->db->query("
			SELECT ROUND(SUM(s.quantity*p.market_price),2) AS total
			FROM `" . __TBL_SALES . "` AS s
				INNER JOIN `" . __TBL_PRODUCTS . "` AS p ON p.id = s.product_id
			WHERE s.status ='wait'
				AND s.user_id = " . $cashier_id . "
		");
		if(sizeof($query->row())>0) {
			return $query->row();
		} else return false;
	}
	
	/**
	 * @param string $barcode
	 * @param boolean $change
	 * @return boolean
	 */
	public function getProduct($barcode, $change=false){
		if($change){
			$change_where = "WHERE id = ".$this->db->escape($barcode);
		} else {
			$change_where = "WHERE barcode = ".$this->db->escape($barcode);
		}
		$query = $this->db->query("
			SELECT *
			FROM `" . __TBL_PRODUCTS . "` 
			".$change_where
		);
		if(sizeof($query->row())>0){
			return $query->row();
		} else return false;
	}
	
	public function getSales($id){
		
	}
	
	/**
	 * Pay at products.
	 * start transaction
	 * Other functions:
	 * 1. Move down product quantity.
	 * 2. Paid product at table seles.
	 * 3. Get invoice number.
	 * 4. Insert product info.
	 * 5. Insert invoice info.
	 * 6. Commint data or rollback all.
	 * @param int $id
	 * @return boolean
	 */
	public function getProductPay($id, $session){
        $ext = $this->getProductId($id);
        
        foreach ($ext as $val) {
            $exts[] = $val['product_id'];
        }
       
        $products_id = implode(",", $exts);
        
		$query = $this->db->query("
			SELECT s.id, s.product_id, s.barcode, SUM(s.quantity) AS quantity, p.market_price
			FROM `" . __TBL_SALES . "` AS s
				INNER JOIN `" . __TBL_PRODUCTS . "` AS p ON p.id = s.product_id 
			WHERE s.product_id IN(".$products_id.")
				AND s.`status` = 'wait'
                AND s.`user_id` = ".$session->id."
            GROUP BY s.barcode
		");
        
		if(sizeof($query->result())>0){
			$trans[] = $this->moveDownProductQuantity($query->result_array());
			$trans[] = $this->PaidProduct($query->result());
			$trans[] = $this->invoiceSaveProduct($query);
			foreach ($trans as $key=>$val) {
				foreach ($val as $value) {
					$finalTrans[] = $value;
				}
			}
			if($this->getTransaction($finalTrans,
					array(
                        __TBL_SALES,
                        __TBL_PRODUCTS,
                        __TBL_INVOICE_SALES
					)
			))
			return $query->result();
		} else return false;
	}
    
    private function getProductId($id){
        if(!is_array($id)) return;
        
        $this->db->select('product_id');
        $this->db->where_in('id',$id);
        $result = $this->db->get(__TBL_SALES);
        if(sizeof($result)>0){
            return $result->result_array();
        }
        return false;
    }
	
	public function invoiceSaveProduct($data){
		if(sizeof($data->result())>0) {
			$invoice_number = $this->invoiceNumberGet();
			$vat = $this->getVat();
			$unit = $this->getUnit();
			foreach ($data->result() as $key=>$val) {
				$query[] = "INSERT INTO `" . __TBL_INVOICE_SALES . "` SET
						`invoice_number` = 0,
						`name` 	  		 = ".$this->db->escape($this->getProduct($val->product_id, true)->name).",
						`barcode` 		 = ".$this->db->escape($this->getProduct($val->product_id, true)->barcode).",
						`quantity` 		 = ".$val->quantity.",
						`market_price`   = ".$this->db->escape($this->getProduct($val->product_id, true)->market_price).",
						`vat` 	  		 = ".$this->db->escape($vat).",
						`unit`	  		 =".$this->db->escape($unit)."
				";
			}
			return $query;
		}
	}
	
	public function invoiceSaveInvoice($data){
		$data = array(
			"writer"=>$data->invoice_writer,
			"invoice_number"=>$this->invoiceNumberGet(),
			"invoice_date"=>date(__DATE_PRODUCT)
		);
		$this->db->insert(__TBL_INVOICES, $data);
	}
	
	public function PaidProduct($data){
		foreach ($data as  $val) {
            $ext[] = $val->barcode;
        }
		$query[] = ""
                . "UPDATE `" . __TBL_SALES . "` "
                . "SET  `status` = 'paid' "
                . "WHERE `barcode` IN(".implode(",", $ext).")";
		return $query;
	}
	
	public function moveDownProductQuantity($info) {
		if(sizeof($info)>0) {
			$info = $this->_group_by($info, "product_id");
			$query = array();
			foreach ($info as $key=>$val) {
                foreach ($val as $value){
                    $query[] = "
					UPDATE `" . __TBL_PRODUCTS . "` SET
						`quantity_out` = quantity_out+". $value['quantity'] .",
                        `quantity_current` = `quantity_current` - ". $value['quantity'] ."
					WHERE `id` = ".$key;
                }
			}
			return $query;
		}
	}
	
	public function add($data){
		if(!empty($data)) {
			$barcode = $data["barcode"];
			if($this->getProduct($barcode)){
				$product_id = ($this->getProduct($barcode) ? $this->getProduct($barcode)->id : 0);
                
                if(!$this->checkProductQuality($product_id, $data["quantity"])){
                    return false;
                }
                
				$add["product_id"] = $product_id;
				$add["user_id"] = 1;
				$add["quantity"] = $data["quantity"];
                $add["barcode"] = $barcode;
				$add["added_date"] = date(__DATE_PRODUCT);
				$this->db->insert(__TBL_SALES, $add);
			}	
		}
	}
    
    private function checkProductQuality($product_id=0, $quantity){
        if(!isset($product_id) || $product_id == 0) return false;
        $this->db->where('id',$product_id);
        $this->db->where('quantity_current >=',$quantity, FALSE);
        $result = $this->db->get(__TBL_PRODUCTS);
        if(sizeof($result->row())>0){
            return true;
        }
        return false;
    }
}