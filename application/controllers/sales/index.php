<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->data["isLogin"] = $this->isLogin();
		if($this->isLogin()){
			$this->data["menu"] = $this->common_model->getMenu();
		} else {
			if($this->uri->segment("3") != 'login') {
				redirect(base_url() . "sales/index/login/");
			}
		}
	}
	
	public function index() {
		$this->load->model("sales/index_model");
		$cashier = $this->session->userdata["user_data"];
		$this->data["list"] = $this->index_model->getList($cashier->id);
		$this->data["total"] = $this->index_model->getTotal($cashier->id);
		$this->load->view('sales/index', $this->data);
	}
    
    public function clear(){
        $cashier = $this->session->userdata["user_data"];
        $this->load->model("sales/index_model");
        $this->index_model->setClearSales($cashier->id);
        redirect(base_url() . 'sales/index/');
    }


    public function pay(){
		$this->load->model("sales/index_model");
		$post = $this->input->post();
		if(isset($post["id"]) && !empty($post["id"][0])) {
			if(isset($post["payment"]) && $post["payment"]>0 && $post["payment"] > $post["total"]) {
				$this->data["products"] = $this->index_model->getProductPay(
                        $post["id"], $this->session->userdata("user_data")
                    );
			} else {
				$this->message->type = 'error';
				$this->message->title = 'Грешка!';
				$this->message->body = '"'
                        . '<strong>ПЛАТЕНО</strong> не може да бъде по-малко от'
                        . '"<strong>СТОЙНОСТ</strong>".<br/>Корегирайте '
                        . '"<strong>ПЛАТЕНО</strong>" за да бъде положителен баланса ви.';
				$this->data["message"] = $this->message;
			}
		}
		$this->index();
	} 
	
	public function add(){
		$this->load->model("sales/index_model");
		$result = $this->index_model->add($this->input->post());
        
        if($result === false){
            $this->message->type = 'error';
				$this->message->title = 'Грешка!';
				$this->message->body = 'Няма налично такова количество!';
            $this->data["message"] = $this->message;
            
            $cashier = $this->session->userdata["user_data"];
            $this->data["list"] = $this->index_model->getList($cashier->id);
            $this->data["total"] = $this->index_model->getTotal($cashier->id);
            $this->load->view('sales/index', $this->data);
            return;
        }
        
		redirect(base_url());
	}
	
	/**
	 * Load login page.
	 * @param string $type - Folders store, salse or manage.
	 */
	public function login(){
        $post = $this->input->post();
		if(!empty($post["cashier"]) && !empty($post["password"])) {
            $this->load->model("sales/index_model");
            unset($post["login"]);
            $loginInfo = $this->index_model->login($post);
            if($loginInfo) {
                $this->session->set_userdata('user_data',$loginInfo);
                $this->session->set_userdata("cashier",true);
                redirect(base_url() . "sales/");
            } else {
                $this->message->type = 'error';
                $this->message->title = 'Грешка!';
                $this->message->body = 'Грешен касиер или парола, моля корегирайте данните и опитайте отново.';
            }
        }
        
        $this->data["message"] = $this->message;
		
		$this->load->view('sales/login', $this->data);
	}
	
	public function logout(){
		$this->session->unset_userdata('cashier');
		redirect(base_url() . "sales/");
	}
	
	/**
	 * Check is login
	 * @param string $type store, salse or manage
	 */
	public function isLogin(){
		if(isset($this->session->userdata["cashier"])) {
			return true;
		} else {
			return false;
		}
	}
}