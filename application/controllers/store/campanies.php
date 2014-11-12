<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  Function for add and register new company have in MY_Controller.php
 */
class Campanies extends MY_Controller {
	
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
	
	public function index($start_from=0){

		$search = $this->input->post("search");

		$this->load->library('pagination');

		$config['base_url'] = base_url() . 'store/campanies/index/';
		$config['total_rows'] = $this->common_model->CampaniesTotatlRows($search["result"]);
		
        if(isset($search) && !empty($search["result"])){
			$config['per_page'] = $config['total_rows'];
		} elseif($this->input->post('per_page') || $this->session->userdata('campanies_per_page')){
            
            if($this->input->post('per_page')) {
                $this->session->set_userdata('campanies_per_page',$this->input->post('per_page'));
            }
           
            $config['per_page'] = $this->session->userdata('campanies_per_page');
            
        } else $config['per_page'] = 20;
        
	 	$config['full_tag_open'] = '<p id="pagination">';
	    $config['full_tag_close'] = '</p>';
	    $config['uri_segment'] = '4';
	    $config['num_links'] = '5';
        
		$this->pagination->initialize($config);

		$this->data["list"] = $this->common_model->getCampaniesList($search["result"], $config['per_page'], $start_from, true);
		$this->data["pagination"] = $this->pagination->create_links();
        
        if($this->input->post('per_page') || $this->session->userdata('campanies_per_page')) {
            $this->data['per_page'] = $this->session->userdata('campanies_per_page');
        } else $this->data['per_page'] = $config['per_page'];
        
		$this->load->view('store/campanies/campanies', $this->data);
	}
	/**
     * Function for add and register new company have in MY_Controller.php
     * 
     * @param int $id
     */
	public function edit($id){
		$id = (int)filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		if($id){
			$this->data["action"] = "edit/".$id;
			$this->data["city"] = $this->common_model->getCityList();
			$this->load->model("store/campanies_model");
			$this->data["edit"] = $this->campanies_model->getRow($id);
			
			if($this->input->post("add")){
				$this->load->model("store/campanies_model");
				$post = $this->input->post();
				$this->load->library("rules");
				$this->form_validation->set_rules($this->rules->addEditCamanies());
				if($this->form_validation->run() == false){
					$this->message->type = "error";
					$this->message->title = "Грешка!";
					$this->message->body = validation_errors();
				} else {
					unset($post["add"]);
					foreach ($post as $key=>$value){
						if(empty($post[$key])) unset($post[$key]);
					}
					$result = $this->campanies_model->edit($id, $post);
					if($result) {
						$this->message->type = 'success';
						$this->message->title = 'Готово!';
						$this->message->body = 'Данните са запазени.';
					} else {
						$this->message->type = 'error';
						$this->message->title = 'Грешка!';
						$this->message->body = 'Проблем при записване на днните.';
					}
				}
			}
			
			$this->data["message"] = $this->message;
			$this->load->view('store/campanies/campanies_add_edit', $this->data);
		} else {
			redirect(base_url() . "store/campanies/");
		}
	}
	
	public function delete($id){
		$id = (int)filter_var($id, FILTER_SANITIZE_NUMBER_INT);
		if($id){
			$this->load->model("store/campanies_model");
			$this->campanies_model->delete($id);
			redirect(base_url() . "store/campanies/", 'location');
		}
	}
}