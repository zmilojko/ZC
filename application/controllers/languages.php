<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lang {
    function __construct($db_item) {
       $this->language_id = $db_item->languages_id;
       $this->language_name = $db_item->name;
    }
}

class Languages extends CI_Controller {
	public function get()
	{
    $this->load->library('LanguagesHandler');
    LanguagesHandler::GetAllLanguages();
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */