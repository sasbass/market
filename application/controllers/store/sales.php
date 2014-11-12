<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->data["isLogin"] = $this->isLogin("store");
		if($this->isLogin("store")){
			$this->data["menu"] = $this->common_model->getMenu();
		} else {
			if($this->uri->segment("3") != 'login') {
				redirect(base_url() . "store/index/login/");
			}
		}
	}
	
	public function index(){
        $check = null;
		if($this->input->post("go")){
			$date = $this->input->post("date");
			$this->data["date_from"] = $date["from"];
			$this->data["date_to"] = $date["to"];
		} else {
			$this->data["date_from"] = date("Y-m-01 00:00:00");
			$this->data["date_to"] = date("Y-m-t 00:00:00");
			
		}
        
        $this->load->model("store/sales_model");
        
        if($this->input->post("invoice")){
            $check = $this->input->post('check');
            $this->createInvoice($check);
        }
        
        $this->data["check"] = $check;
        $this->data["city"] = $this->common_model->getCityList();
        $this->data["campanies"] = $this->common_model->getCampaniesList();
        if(!empty($this->message->type)) {
            $this->data["message"] = $this->message;
        }
        
        $flashdata = $this->session->flashdata('message');
        if(!empty($flashdata)){
           $this->data["message"] = $flashdata;
        }
        
		$this->data["list"] = $this->sales_model->getList($this->data);
        $result_data = $this->sales_model->getTotal($this->data);
        $this->data['total'] = $result_data;
		$this->data["first_year"] = $this->sales_model->getFirstYearOfSales();
		$this->load->view('store/sales/list', $this->data);
	}
    
    public function setFlashData(){        
        
        $client = $this->input->post('client');
        $client['type'] = $this->input->post('type');
        
        if($this->input->post('type') == 0) {
            $this->load->library("rules");
            $this->form_validation->set_rules($this->rules->addEditCampany());
            if($this->form_validation->run() == false){
                $this->message->type = "error";
                $this->message->title = "Попълнете задължителните полета!";
                $this->message->body = validation_errors();
            } else {
                $this->message->type = "success";
               
            }
        }
        
        if(!empty($client) && $this->message->type === 'success' || $this->input->post('type') == 'ch'){
            
            //Rregiter new company.
            if(isset($client["save"])){
                $post = array(
                   'name'=>$client['company_name'],
                   'mol'=>$client['company_mol'],
                   'register_address'=>$client['company_address_register'],
                   'ident'=>$client['company_ident'],
                   'ident_num'=>$client['company_ident_num'],
                   'ident'=>$client['company_ident']
                );
                
                if(isset($client['phone'])) $post['phone'] = $client['phone'];
                if(isset($client['email'])) $post['email'] = $client['email'];
                
                // Checking if have problem at register the new company.
                $post['flag'] = true;
                if(!$this->message = $this->add($post)){
                    $this->message->type = "error";
                    $this->message->title = "Проблем при регистрация!";
                    $this->message->body = "Възникна проблем при регистрацията на тази фирма.<br/>Моля опитайте отново.";
                } else {
                    $this->message = null;
                }
            }
            
            if(isset($client['company_city']) && is_numeric($client['company_city'])) {
                $city_data = $this->common_model->getCity($client['company_city']);
                $client['company_city'] = $city_data->name;
            }
            $check = $this->session->userdata('check');
            if(isset($check)) {
                $this->message = $this->createInvoice($check, $client);
                
            }
            
            //$this->message->form = false;
            //Everything is ok and go to next step.
            $message = array(
                'type'=>1,
                'msg'=>$this->message
            );
            $this->session->set_flashdata('message',$this->message);
            print json_encode($message);
            return;
        }
        
        $message = array(
            'type'=>0,
            'msg'=>$this->message
        );
        print json_encode($message);
        exit;
    }
    
    private function createInvoice($check, $client=null){
        $this->message->type = false;
        if(is_array($check) && !empty($check)){
           
            $this->session->set_userdata('check',$check);
            $this->load->model("store/sales_model");
            $result = $this->sales_model->getSalesData($check);
            
            if(sizeof($result->result())>0 && $this->input->post('company_id')>0 || !empty($client)) {
                $this->load->model("common_model");
                $company_id = $this->input->post('company_id');
                if(isset($company_id) && !empty($company_id)) {
                    $this->data['client'] = $this->common_model->getCampalnies($company_id);
                }
                $this->data['list'] = $result->data;
                $this->data['total'] = $result->total;
                $calc_vat = $this->calcVat($result->total);
                $this->data['vat'] = $calc_vat['vat'];
                $this->data['grand_total'] = $calc_vat['sum'];
                if(isset($client)) {
                    $this->data['client'] = $client;
                }
                $pdf_result = $this->createPDF();
                $this->message->type = "check";
                $this->message->title = "Генериране на фактура!";
                $this->message->body = 'Вашата фактура беше създадена успешно.<br/>'
                        . 'Може да я свалите от тук: <a target="__blank" href="' . $pdf_result["url"] . '"><img src="' . base_url() . 'interface/16/upcoming-work.png"</a><br/>'
                        . 'Фактура номер: <strong>' . $pdf_result["invoice_number"] . '</strong>';
            } elseif($this->input->post('company_id')== 'ch') {
                $this->message->form = true;
                $this->message->type = "check_member";
                $this->message->title = "Въведете данни за фактура";
            } elseif($this->input->post('company_id')==0) {
                $this->message->form = true;
                $this->message->type = "check";
                $this->message->title = "Въведете данни за фактура";
            }

        } else {
            $this->message->type = "alert";
            $this->message->title = "Няма избрани продукти!";
            $this->message->body = 'Не сте избрали продукт/и за да създадете фактура.<br/>Моля изберете поне един продукт.';
        }
        return $this->message;
    }
}