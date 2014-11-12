<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settings extends MY_Controller {
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
        $this->load->model('common_model');
        $this->data['settings'] = $this->common_model->getSettings(false);
        $this->data['page'] = 'settings';
        $this->load->view('store/settings/index', $this->data);
    }
    
    public function save(){
        $post = $this->input->post();
        if(isset($post['var']) && !empty($post['var'])){
            $this->load->model('common_model');
            $this->common_model->updateSettings($post['var']);
        }
        redirect(base_url() . 'store/settings/');
    }
}
