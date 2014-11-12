<?php
class MY_Controller extends CI_Controller {
	
/**
 * Служебни съобщения
 * @var Object 
 * 		$this->message->type 		= 	'[types]' 	// error OR success
 *  	$this->message->title 		= 	'[titles]' 	// Title message
 *  	$this->message->body 		= 	'[body]' 	// Body message
 *  	$this->message->redirect	= 	[redirect] 	// Integer number 2000 = 2 seconds
 *      $this->message->url			=	'[url]'		// Enter URL address.
 */
	public $message;
	
/**
 * 
 * Съдържа общо ползвани данни за всички views - меню, base_url...
 * @var array
 */
	protected $data = array();
	
/**
 * 
 * Конструктор на базочия контролер. Грижи се да зареди всички общо ползвани данни и да контролира правата на потребителя
 * @param boolean $forse_menu true - не отчита правата на потребителя и покзва всички достъпни страници
 */
	public function __construct() {
		parent::__construct();
		$this->message = $this->Message();
		$this->data["base_url"] = base_url();
        $this->data['var'] = $this->getSettings();
	}
	
	public function Message(){
		$this->message = new stdClass();
		return $this->message;
	}
    
    private function getSettings(){
        $this->load->model('common_model');
        return $this->common_model->getSettings();
    }
    
    /**
     * This function for is register new company.
     * @param array $post
     */
    public function add($post=null){
		$this->data["city"] = $this->common_model->getCityList();
		$this->data["action"] = "add";
		if($this->input->post("add") || !empty($post)){
			$this->load->model("store/campanies_model");
			if(empty($post)) {
                $post = $this->input->post();
                $post['flag'] = false;
            }
            
			$this->load->library("rules");
            if($post['flag'] === false) {
                $set_ruls = $this->rules->addEditCamanies();
            } else {
                $set_ruls = $this->rules->addEditCampany();
            }
            
			$this->form_validation->set_rules($set_ruls);
			if($this->form_validation->run() == false){
				$this->message->type = "error";
				$this->message->title = "Грешка!";
				$this->message->body = validation_errors();
                if($post['flag'] === true){
                    return $this->message;
                    exit;
                }
			} else {
				if($post['flag'] === false) {
                    unset($post["add"]);
                }
                $flag = $post['flag'];
				foreach ($post as $key=>$value){
					if(empty($post[$key])) unset($post[$key]);
				}
				$post["added_date"] = date(__DATE_PRODUCT);
				$this->campanies_model->add($post);
				if($flag === false){
                    redirect(base_url() . "store/campanies/");
                } else {
                    return true;
                }
			}
		}
		
        $this->data["message"] = $this->message;
		$this->load->view('store/campanies/campanies_add_edit', $this->data);
	}


    /**
	 * Check is login
	 * @param string $section store, salse or manage
	 */
	public function isLogin($section){
		if(isset($this->session->userdata[$section])) {
			return true;
		} else {
			return false;
		}
	}
    
    protected function getInvoiceNumber(){
        $this->load->model('common_model');
        return $this->common_model->getInvoiceNumber();
    }


    protected function createPDF(){
        $lang = 'bg';
        $this->data['invoice_date'] = date('Y-m-d_H:i:s');
        $this->data['accounting_invoice_number'] = $this->getInvoiceNumber();
        $this->data['filename'] = date('YmdHis') . '_' . $this->data['accounting_invoice_number'];
        
        $this->data['invoice_type'] = 'ОРИГИНАЛ';
        $this->data['sum'] = $this->data['grand_total'];
       
        $this->load->library('numbers/words');
        $this->data['number_words'] = $this->words->toCurrency($this->data['sum'], $lang);
       
        $this->load->library('pdf2');
        $result = $this->pdf2->createPDF('store/invoice/invoice', $this->data, $this->data['filename']);
        $result['invoice_number'] = $this->data['accounting_invoice_number'];
        $this->data['filename'] = $result['filename'];
        
        $this->load->model('common_model');
        $this->common_model->copyInviceData($this->data);
        
        return $result;
    }
    
    protected function calcVat($sum=0){
        $result = $sum*((100+$this->data['var']['vat'])/100);
        $result = array('sum'=>$result,'vat'=>$result-$sum);
        return $result;
    }
}
