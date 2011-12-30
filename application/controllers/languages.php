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