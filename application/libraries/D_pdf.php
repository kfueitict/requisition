<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/dompdf/vendor/autoload.php";
use Dompdf\Dompdf;
class D_pdf {
    public $pdf;
    function __construct()
    {
        $this->pdf = new Dompdf();
    }
}