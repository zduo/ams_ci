<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->auth = new stdClass;
        $this->load->library('flexi_auth');
        $this->data = null;

        if (!$this->flexi_auth->is_logged_in_via_password())
        {
            $this->flexi_auth->set_error_message('请先登录.', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
    }

    public function index()
    {
        $this->welcome();
    }

    public function welcome()
    {
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content = $this->load->view('backend/layouts/welcome', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '用户欢迎'));
    }
}
