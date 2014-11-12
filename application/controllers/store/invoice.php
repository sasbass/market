<?php
class Invoice extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if($this->isLogin("store")){
			$this->data["isLogin"] = $this->isLogin("store");
			$this->data["menu"] = $this->common_model->getMenu();
		} else {
			if($this->uri->segment("3") != 'login') {
				redirect(base_url() . "store/index/login/");
			}
		}
	}
	
	public function index(){
		$this->load->model("store/sales_model");
		$this->load->view('store/invoice/list', $this->data);
	}
	
	public function create(){
        
        //$this->createPDF();
        
        if($this->input->post('create')){
            
        }
        
		$this->load->view('store/invoice/create', $this->data);
	}
    
}