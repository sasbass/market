<?php
class Common_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
    
    public function copyInviceData($data){
        if(empty($data)) return;
        $client = $data['client'];
        if(isset($data['client']['type']) && $data['client']['type'] == 0) {
            $client['type'] = 'company';
        } else {
            $client['type'] = 'member';
        }
        
        $this->db->trans_begin();
        $id = $this->saveInvpiceCompanyData($client);
        $indata['writer'] = $data['var']['invoice_company_mol'];
        $indata['invoice_number'] = $data['accounting_invoice_number'];
        $indata['filename'] = $data['filename'];
        $this->saveInvoice($id, $indata);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        
    }
    
    private function saveInvoice($id, $data){
        $array_data = array(
            'invoice_market_data_id'=>$id,
            'writer'=>$data['writer'],
            'invoice_number'=>$data['invoice_number'],
            'filename'=>$data['filename'],
            'invoice_date'=>date(__DATE_PRODUCT)
        );
        $this->db->insert(__TBL_INVOICES, $array_data);
    }
    
    private function saveInvpiceCompanyData($data){
        $array_data = array(
            'company_name'=>(isset($data['company_name']) ? $data['company_name'] : ''),
            'company_mol'=>(isset($data['company_mol']) ? $data['company_mol'] : ''),
            'company_address'=>(isset($data['company_address_register']) ? $data['company_address_register'] : ''),
            'company_city'=>(isset($data['company_city']) ? $data['company_city'] : ''),
            'company_ident'=>(isset($data['company_ident']) ? $data['company_ident'] : ''),
            'company_ident_num'=>(isset($data['company_ident_num']) ? $data['company_ident_num'] : ''),
            'type'=>$data['type'],
        );
        $this->db->insert(__TBL_INVOICE_COMPANY_DATA, $array_data);
        return $this->db->insert_id();
    }

    public function getInvoiceNumber(){
        $result = $this->db->get(__TBL_INVOICE_NUMBER);
        if(sizeof($result->row())>0){
            if($this->upInvoice($result->row()->number)){
                return $result->row()->number+1;
            }
            return false;
        } else {
            $this->insertInvoice();
            return 1000000001;
        }
    }
    
    private function upInvoice($number){
        return $this->db->update(__TBL_INVOICE_NUMBER,
                array('number'=>$number+1)
            );
    }
    
    private function insertInvoice(){
        $this->db->insert(__TBL_INVOICE_NUMBER, array('number'=>1000000001));
    }


    public function getMenu(){
		$query = $this->db->query("
			SELECT `id`,`name`,`title`,`icon`
			FROM `" . __TBL_PAGES . "`
			WHERE `active` = 1
				AND `ident` = 'store'
				AND `parent_id` = 0
			ORDER BY `position`
		");
		$query_array = $query->result_array();
		if(is_array($query_array)) {
			foreach ($query_array as $key=>&$val){
				if($this->getSubMenu($val["id"])){		
					$val["sub_menu"] = $this->getSubMenu($val["id"]);
				}
			}
		}
		
		if(sizeof($query->result())>0) {
			return $query_array;
		} else return false;
	}
	
	public function getSubMenu($id){
		$query = $this->db->query("
			SELECT `id`,`name`,`title`,`parent_id`,`icon`
			FROM `" . __TBL_PAGES . "`
			WHERE `active` = 1
				AND `ident` = 'store'
				AND `parent_id` = ".$id."
		");
		if(sizeof($query->result())>0) {
			return $query->result_array();
		} else return false;
	}
	
	public function getCityList(){
		$query = $this->db->query("
			SELECT * 
			FROM `" . __TBL_CITY . "` 
			ORDER BY id
		");
		if(sizeof($query->result())>0){
			return $query->result();
		} else return false;
	}
    
    public function getCity($id=0){
        if($id==0) return;
        
		$query = $this->db->query("
			SELECT id, name 
			FROM `" . __TBL_CITY . "` 
            WHERE id = ".$id."
			ORDER BY id
		");
		if(sizeof($query->row())>0){
			return $query->row();
		} else return false;
	}
    
    public function getCampalnies($id=0){
        if($id==0) return;
        $this->db->select(''
                . 'k.name AS company_name, c.name AS company_city,'
                . 'k.register_address AS company_address_register,'
                . 'k.ident_num AS company_ident_num, k.mol AS company_mol,'
                . 'k.ident AS company_ident');
        $this->db->join(__TBL_CITY . ' AS c','c.id=k.city_id','left');
        $this->db->where('k.id',$id);
        $result = $this->db->get(__TBL_COMPANIES . ' AS k');
        if(sizeof($result->row())>0){
            return $result->row_array();
        }
        return false;
    }


    public function getCampaniesList($search='', $limit = NULL, $offset = NULL, $flag = false){
        if($flag){
            $this->db->like("name",$search);
            $this->db->or_like("address",$search);
            $this->db->or_like("mol",$search);
            $this->db->or_like("ident",$search);
            $this->db->or_like("phone",$search);
            $this->db->or_like("email",$search);
            $this->db->limit($limit, $offset);
        }
		$query = $this->db->get(__TBL_COMPANIES);
        
		if(sizeof($query->result())>0){
			return $query->result();
		} else return false;
	}

	public function CampaniesTotatlRows($search=''){
		$this->db->like("name",$search);
		$this->db->or_like("address",$search);
		$this->db->or_like("mol",$search);
		$this->db->or_like("ident",$search);
		$this->db->or_like("phone",$search);
		$this->db->or_like("email",$search);
		$this->db->from(__TBL_COMPANIES);
		return $this->db->count_all_results();
	}
    
    /**
     * 
     * @param boolean $array_type - If $array_type equal true return standart
     *                              arrray [name] = [value] or false return
     *                              array from objects.
     * @return array
     */
    public function getSettings($array_type=true){
        $query = $this->db->get(__TBL_SETTINGS);
        
        if($array_type === false){
            if(sizeof($query->result())>0) {
                return $query->result();
            }
            return false;
        }
        
        $query = $query->result_array();
        if(is_array($query) && !empty($query)){
            $newArr = array();
            foreach ($query as $key=>$var) {
                $newArr[$var['name']] = $var['value'];
            }
            return $newArr;
        }
        return false;
    }
    
    public function updateSettings($data){
        if(empty($data)) return false;
        $arr_data = array();
        $cnt = 0;
        foreach ($data as $key=>$var){
            $arr_data[$cnt]['name'] = $key;
            $arr_data[$cnt]['value'] = $var;
            $cnt++;
        }
//        var_dump($arr_data);
//        
//        exit;
        $this->db->update_batch(__TBL_SETTINGS, $arr_data, 'name');
    }
}