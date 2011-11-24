<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order {
    function __construct($db_order) {
       $this->id = $db_order->orders_id;
       $this->customer = new stdClass();
       $this->customer->id = $db_order->customers_id;
       $this->customer->name = $db_order->customers_name;
       $this->customer->address = $db_order->customers_street_address . ', ' . $db_order->customers_postcode . ' ' . $db_order->customers_city;
       $this->delivery = new stdClass();
       $this->delivery->name = $db_order->delivery_name;
       $this->delivery->address = $db_order->delivery_street_address . ', ' . $db_order->delivery_postcode . ' ' . $db_order->delivery_city;
       $this->delivery->method = $db_order->shipping_method;       
       $this->billing = new stdClass();
       $this->billing->name = $db_order->billing_name;
       $this->billing->address = $db_order->billing_street_address . ', ' . $db_order->billing_postcode . ' ' . $db_order->billing_city;
       $this->billing->method = $db_order->payment_method;
    }
}

class Orders extends CI_Controller {
	public function get()
	{
    $language_id = $this->session->userdata('language');
    if(!$language_id)
    {
      $language_id = DEFAULT_LANGUAGE_INDEX;
    }

    $last_known_timestamp = isset($_POST['time_from'])?$_POST['time_from']:FALSE;
    $status_filter = isset($_POST['status'])?$_POST['status']:FALSE;
    $index_list = isset($_POST['index_list'])?$_POST['index_list']:FALSE;
    $indexes_only = isset($_POST['indexes_only'])?$_POST['indexes_only']:FALSE;

    if(is_array($index_list))
    {
      //change this to the comma separated string
      $index_list = implode(",", $index_list);
    }
    
    $query = $this->db->query("select * from orders
                               where orders_id in (select distinct orders_id
                                                   from orders_status_history
                                                   where date_added > '2011-11-01'
                                                   order by date_added desc)
                               and orders_status = 3
                               order by date_purchased desc
                               limit 200;")->result();

    print_r($query[0]);echo '<br/><br/><br/>';
                               
    $orders = array();     
     
    foreach($query as $row)
    {
      $orders[] = new Order($row);
    }
    echo json_encode($orders);
  }
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */