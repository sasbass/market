<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users extends MY_Controller {
    public function __construct() {
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
        $cashier = $this->session->userdata["user_data"];
        $this->load->model('store/index_model');
        $post = $this->input->post('data'); 
        if($this->input->post('save')){
			$this->load->library("rules");
			$this->form_validation->set_rules($this->rules->updateUserData());
			if($this->form_validation->run() === false){
				$this->message->type = "error";
				$this->message->title = "Грешка!";
				$this->message->body = validation_errors();
			} else {
                $data = $this->input->post('data');
                if(empty($post['password'])){
                    unset($data['password']);
                }
                $this->index_model->updateUserData($data, $cashier->id);
                redirect(base_url() . 'store/users/');
            }
        }
        
        $this->data['message'] = $this->message;
        $this->data['page'] = 'users';
        $this->data['edit'] = $this->index_model->getUserData($cashier->id);
        $this->load->view('store/users/index', $this->data);
    }
}
