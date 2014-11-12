<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
	
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
	
	public function index($start_from=0)
	{
		$this->load->model("store/index_model");
		
		$search = $this->input->post("search");

		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'store/index/index/';
		$config['total_rows'] = $this->index_model->TotatlRows($search["result"]);
		
        if(isset($search) && !empty($search["result"])){
			$config['per_page'] = $config['total_rows'];
        } elseif($this->input->post('per_page') || $this->session->userdata('per_page')){
            
            if($this->input->post('per_page')) {
                $this->session->set_userdata('per_page',$this->input->post('per_page'));
            }
           
            $config['per_page'] = $this->session->userdata('per_page');
            
        } else $config['per_page'] = 20;
	 	
        $config['full_tag_open'] = '<p id="pagination">';
	    $config['full_tag_close'] = '</p>';
	    $config['uri_segment'] = '4';
	    $config['num_links'] = '5';
        
		$this->pagination->initialize($config);
		
		$this->data["list"] = $this->index_model->getList($search["result"], $config['per_page'], $start_from);
		$this->data["pagination"] = $this->pagination->create_links();
       
        if($this->input->post('per_page') || $this->session->userdata('per_page')) {
            $this->data['per_page'] = $this->session->userdata('per_page');
        } else $this->data['per_page'] = $config['per_page'];
		
        $this->load->view('store/store/list', $this->data);
	}
	
	public function add(){
		$this->data["action"] = "add";
		if($this->input->post("add")){
			$post = $this->input->post();
			$this->load->library("rules");
			$this->form_validation->set_rules($this->rules->addProduct());
			if($this->form_validation->run() == false){
				$this->message->type = "error";
				$this->message->title = "Грешка!";
				$this->message->body = validation_errors();
			} else {
				
				unset($post["add"]);
				foreach ($post as $key=>$value){
					if(empty($post[$key])) unset($post[$key]);
				}
				$post["added_date"] = date(__DATE_PRODUCT);
				$this->load->model("store/index_model");
                $post['quantity_current'] = $post['quality_in'];
				$id = $this->index_model->add($post);
                
                $post_log = array(
                    'quality_in'=>$post['quality_in'],
                    'delivery_price'=>$post['delivery_price'],
                    'market_price'=>$post['market_price']
                );
                $this->index_model->productLog($id, $post_log, 'add');
				
				redirect(base_url() . "store/");
			}
		}
		
        $this->data["campanies"] = $this->common_model->getCampaniesList();
		$this->data["message"] = $this->message;
		$this->load->view('store/store/add_edit', $this->data);
	}
	
	public function edit($id){
		$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		if($id){
			$this->data["action"] = "edit/".$id;
			$this->data["city"] = $this->common_model->getCityList();
			$this->load->model("store/index_model");
			$this->data["edit"] = $this->index_model->getRow($id);
			if($this->input->post("add")){
				$post = $this->input->post();
				$this->load->library("rules");
				$this->form_validation->set_rules($this->rules->editProduct());
				if($this->form_validation->run() == false){
					$this->message->type = "error";
					$this->message->title = "Грешка!";
					$this->message->body = validation_errors();
				} else {
					unset($post["add"]);
					foreach ($post as $key=>$value){
						if(empty($post[$key])) unset($post[$key]);
					}
                    
                    $post_log = array();
                    
                    $post['quality_in'] = $this->data["edit"]->quality_in+$post['quantity_current'];
                   
                    $post_log_quality_in = $post['quantity_current'];
                    
                    $post['quantity_current'] = $this->data["edit"]->quantity_current+$post['quantity_current'];
					$result = $this->index_model->edit($id, $post);
                    
                    $post_log = array(
                        'quality_in'=>$post_log_quality_in,
                        'delivery_price'=>$post['delivery_price'],
                        'market_price'=>$post['market_price']
                    );
                    
                    $this->index_model->productLog($id, $post_log, 'edit');
					redirect( base_url() . 'store/index/edit/' . $id . '/');
				}
			}
            
            $this->data['uri'] = $this->uri->segment(3);
            $this->data["campanies"] = $this->common_model->getCampaniesList();
			$this->data["message"] = $this->message;
			$this->load->view('store/store/add_edit', $this->data);
		} else {
			redirect(base_url() . "store/");
		}
	}
	
	public function delete($id){
		$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		if($id){
			$this->load->model("store/index_model");
			$this->index_model->delete($id);
			redirect(base_url() . "store/");
		}
	}
	
	/**
	 * Load login page.
	 * @param string $type - Folders store, salse or manage.
	 */
	public function login(){
		if($this->input->post("login")) {
			$post = $this->input->post();
			if(!empty($post["store"]) && !empty($post["password"])) {
				$this->load->model("store/index_model");
				unset($post["login"]);
                $loginInfo = $this->index_model->login($post);
				if($loginInfo) {
                    $this->session->set_userdata('user_data',$loginInfo);
					$this->session->set_userdata("store",true);
					redirect(base_url() . "store/");
				} else {
					$this->message->type = 'error';
					$this->message->title = 'Грешка!';
					$this->message->body = 'Грешен потребител или парола, моля корегирайте данните и опитайте отново.';
				}
			} else {
				$this->message->type = 'error';
				$this->message->title = 'Грешка!';
				$this->message->body = 'Моля попълнете всички полета.';
			}
			$this->data["message"] = $this->message;
		}
	
		$this->load->view('store/login', $this->data);
	}
	
	public function logout(){
		$this->session->unset_userdata('store');
		redirect(base_url() . "store/");
	}
}