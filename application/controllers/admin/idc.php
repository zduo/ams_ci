<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Idc extends CI_Controller {

	function __construct()
    {
        parent::__construct();

        $this->auth = new stdClass;
        $this->load->library('flexi_auth');
        $this->load->model('auth_model');

        if (!$this->flexi_auth->is_logged_in_via_password())
        {
            $this->flexi_auth->set_error_message('请先登录.', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }

		$this->table = 't_idc_info';
        $this->load->model('idc_model');
        $this->data = null;
    }

    /**
     * Compary Info.
     *
     * @return view
     */
    public function index()
    {
		$this->show_list();
    }

	public function show_list(){
        if (! $this->flexi_auth->is_privileged('list_idc'))
        {
            $this->session->set_flashdata('message', '没有权限浏览');
            redirect('admin/welcome');
        }
        $this->idc_model->idc_list();
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content = $this->load->view('backend/idc/list', $this->data, TRUE);
		$this->load->view('backend/layouts/default', array('content' => $content, 'title' => 'IDC列表'));
	}

	/**
     * 添加IDC信息
     */
	public function create()
    {
        if (! $this->flexi_auth->is_privileged('add_idc'))
        {
            $this->session->set_flashdata('message', '没有权限创建烘培分类');
            redirect('admin/idc');
        }
        if ($this->input->post('create_idc'))
        {
            $this->idc_model->save_idc();
        }
        $this->data['message']  = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content    = $this->load->view('backend/idc/create', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '新增IDC'));
    }

	/**
     * 编辑IDC信息
     */
	public function edit($id=null)
    {       
        if (! $this->flexi_auth->is_privileged('add_idc'))
        {
            $this->session->set_flashdata('message', '没有权限修改烘培分类');
            redirect('admin/idc');
        }
		if (is_null($id) && !$this->input->post('edit_idc')) {
            $message = "IDC编号为空，无法修改"; 
            $this->show_list($message);
            return;
        }
        $message = '';
        if ($this->input->post('edit_idc'))
        {
            $status = $this->idc_model->edit_idc();
            if ($status == true) {
                redirect('admin/idc');
                return TRUE;
            }
            $message = '修改失败';
        }
        $idc = $this->idc_model->idc_info($id);
        $content = $this->load->view('backend/idc/edit', array('idc' => $idc, 'message' => $message), TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '编辑IDC'));
    }
	
	/**
     * 删除IDC信息
     */
	public function delete($id = null)
    {
        if (!$this->flexi_auth->is_privileged('del_idc'))
        {
            $this->session->set_flashdata('message', '没有权限删除');
            redirect('admin/welcome');
        }
        if (is_null($id)) {
            $this->show_list('删除编号为空，无法删除');
            return;
        }
        if ($this->idc_model->delete_idc($id))
        {
            redirect('admin/idc');
            return TRUE;
        }
		redirect('admin/idc');
    }

}
