<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//test comment

class Orders extends CI_Controller {


	public function get()
	{
    $this->load->library('OrderHandler');
    OrderHandler::get_full_orders();
  }
  
  public function test()
  {
    if(!$this->session->userdata('user'))
    {
      die("Must login first");
      return;
    }  
  
    $this->load->helper('form');
    $this->load->view('order_test');
  }
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */