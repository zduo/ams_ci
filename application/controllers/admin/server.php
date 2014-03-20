<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Server extends CI_Controller {

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

		$this->table = 't_server_info';
        $this->load->model('server_model');
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
        if (! $this->flexi_auth->is_privileged('list_server'))
        {
            $this->session->set_flashdata('message', '没有权限浏览');
            redirect('admin/welcome');
        }
        $this->server_model->server_list();
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content = $this->load->view('backend/server/list', $this->data, TRUE);
		$this->load->view('backend/layouts/default', array('content' => $content, 'title' => 'SERVER列表'));
	}

	/**
     * 添加SERVER信息
     */
	public function create()
    {
        if (! $this->flexi_auth->is_privileged('add_server'))
        {
            $this->session->set_flashdata('message', '没有权限创建烘培分类');
            redirect('admin/server');
        }
        if ($this->input->post('create_server'))
        {
            $this->server_model->save_server();
        }
        $this->data['message']  = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->data['table_column']  = $this->server_model->table_column();
		$this->data['idcs'] = $this->idc_model->idc_list_content($this->idc_model->idc_list_num());
        $content    = $this->load->view('backend/server/create', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '新增SERVER'));
    }

	/**
     * 编辑SERVER信息
     */
	public function edit($id=null)
    {       
        if (! $this->flexi_auth->is_privileged('add_server'))
        {
            $this->session->set_flashdata('message', '没有权限修改烘培分类');
            redirect('admin/server');
        }
		if (is_null($id) && !$this->input->post('edit_server')) {
            $message = "SERVER编号为空，无法修改"; 
            $this->show_list($message);
            return;
        }
        $message = '';
        if ($this->input->post('edit_server'))
        {
            $status = $this->server_model->edit_server();
            if ($status == true) {
                redirect('admin/server');
                return TRUE;
            }
            $message = '修改失败';
        }
        $server = $this->server_model->server_info($id);
		$table_column  = $this->server_model->table_column();
		$idcs = $this->idc_model->idc_list_content($this->idc_model->idc_list_num());
        $content = $this->load->view('backend/server/edit', array('server' => $server, 'message' => $message,'table_column'=>$table_column,'idcs'=>$idcs), TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '编辑SERVER'));
    }
	
	/**
     * 删除SERVER信息
     */
	public function delete($id = null)
    {
        if (!$this->flexi_auth->is_privileged('del_server'))
        {
            $this->session->set_flashdata('message', '没有权限删除');
            redirect('admin/welcome');
        }
        if (is_null($id)) {
            $this->show_list('删除编号为空，无法删除');
            return;
        }
        if ($this->server_model->delete_server($id))
        {
            redirect('admin/server');
            return TRUE;
        }
        $this->show_list();
    }

}
