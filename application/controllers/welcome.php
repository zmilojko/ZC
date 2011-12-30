<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ZOM Connector
 *
 * An open source application for webshops based on PHP.
 * Based on the CodeIgniter framework. Visit http://codeigniter.com for more info.
 *
 * @package		ZOM Connector
 * @author		Z-Ware Ltd.
 * @copyright	Copyright (c) 2011, Z-Ware Ltd.
 * @license		http://zom.z-ware.fi/license
 * @link		http://zom.z-ware.fi
 * @since		Version 0.0.1
 * @filesource
 *  
 * Copyright (C) 2011 Z-Ware Ltd.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * This Software is based on the CodeIgniter framework (codeigniter.com).
 * Any use/change/distribution of the Software must comply with the Code Igniter 
 * license (http://codeigniter.com/user_guide/license.html).
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
    $cmd = isset($_POST['command'])?$_POST['command']:FALSE;
    
    switch($cmd) {
    case "get_languages":
      $this->load->library('LanguagesHandler');
      LanguagesHandler::GetAllLanguages();
      return;    
    case "login":
      $this->load->library('LoginHandler');
      LoginHandler::DoLogin();
      return;
    case "get_statuses":
      $this->load->library('StatusesHandler');
      StatusesHandler::GetAllStatuses();
      return;
    case "get_orders":
      $this->load->library('OrderHandler');
      OrderHandler::get_full_orders();
      return;

    default:
        if(!ENABLE_TEST_PAGES) {
          header("HTTP/1.0 404 Not Found");
          die('');
        }    
    		$this->load->view('welcome_message');
    }  
	}
  public function test()
  {
    if(!ENABLE_TEST_PAGES) {
      header("HTTP/1.0 404 Not Found");
      die('');
    }    
    $this->load->helper('form');
    $this->load->view('command_test');
  }  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */