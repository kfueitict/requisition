<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/HTML2PDF/vendor/autoload.php";

class Html2pdfl extends HTML2PDF {
    public function __construct() {
        parent::__construct();
    }

}
?>