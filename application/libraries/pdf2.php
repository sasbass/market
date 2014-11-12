<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf2 extends TCPDF
{
    
    private $pdf_path = '/files/invoices/';
    function __construct()
    {
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }
    
	/**
	 * Get an instance of CodeIgniter
	 *
	 * @access	protected
	 * @return	void
	 */
	protected function ci()
	{
		return get_instance();
	}

	/**
	 * Load a CodeIgniter view into domPDF
	 *
	 * @access	public
	 * @param	string	$view The view to load
	 * @param	array	$data The view data
	 * @return	string - URL to invoice file.
	 */
	public function createPDF($view, $data = array(), $filename='demo')
	{
        
		$html = $this->ci()->load->view($view, $data, TRUE);
		$this->setPrintHeader(false);
        $this->setPrintFooter(false);
        $this->SetMargins(PDF_MARGIN_LEFT, 12, 10);
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->SetFont('dejavusans', '', 10);
        $this->AddPage();
        $this->writeHTML($html, true, false, true, false, '');
        $this->Output( FCPATH . $this->pdf_path.$filename.'.pdf', 'F');
        $result = array(
            'url'=>base_url() . $this->pdf_path.$filename.'.pdf',
            'invoice_number'=>null,
            'filename'=>$this->pdf_path.$filename.'.pdf'
        );
        return $result;
	}
}