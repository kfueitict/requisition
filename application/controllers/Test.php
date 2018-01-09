<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    function __construct() {
        parent::__construct();

    }

    public function index() {
        $this->load->library('D_pdf');
        $dompdf = $this->d_pdf->pdf;
        $dompdf->loadHtml('<h1>Welcome to CodexWorld.com</h1>');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("codexworld",array("Attachment"=>0));
        
        exit;

    }



}
