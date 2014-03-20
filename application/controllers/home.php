<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
    
    /**
     * 网站首页
     */
    public function index()
    {
        //$this->load->view('frontend/web/home');
		redirect('auth');
    }

    
}
