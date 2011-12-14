<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statuses extends CI_Controller {
	public function get()
	{
    $this->load->library('StatusesHandler');
    StatusesHandler::GetAllStatuses();
  }
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */