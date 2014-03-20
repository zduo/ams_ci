<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privileges extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->auth = new stdClass;
        $this->load->library('flexi_auth');

        if (!$this->flexi_auth->is_logged_in_via_password() || !$this->flexi_auth->is_admin())
        {
            $this->flexi_auth->set_error_message('只有管理员才能管理用户', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
    }

    /**
     * Show a list of all the privileges.
     *
     * @return View
     */
    public function index()
    {
        $this->show_list();
    }

    private function show_list($message = null)
    {
        if (! $this->flexi_auth->is_privileged('list_privilege'))
        {
            $this->session->set_flashdata('message', '没有权限浏览');
            redirect('admin/welcome');
        }
        $pri_list = $this->flexi_auth->get_privileges_query("upriv_id, upriv_name, upriv_desc")->result_array();
        $content    = $this->load->view('backend/privileges/list', array('pri_list' => $pri_list, 'message' => $message), TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '权限列表'));
    }

    /**
     * Privilege Create
     */
    public function create()
    {
        if (! $this->flexi_auth->is_privileged('add_privilege'))
        {
            $this->session->set_flashdata('message', '没有权限添加');
            redirect('admin/privileges');
        }
        if ($this->input->post('create_privilege'))
        {
            $name = $this->input->post('privilege_name');
            $desc = $this->input->post('privilege_desc');
            $privilege_id = $this->flexi_auth->insert_privilege($name, $desc);
            if ($privilege_id !== false) {
                redirect('admin/privileges');
                return TRUE;
            }
        }
        $this->data['message']  = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content    = $this->load->view('backend/privileges/create', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '新建权限'));
    }

    /**
     * Privilege update
     */
    public function edit($id = null)
    {
        if (! $this->flexi_auth->is_privileged('add_privilege'))
        {
            $this->session->set_flashdata('message', '没有权限修改');
            redirect('admin/privileges');
        }
        if (is_null($id) && !$this->input->post('create_privilege')) {
            $message = "权限编号为空，无法修改"; 
            $this->show_list($message);
            return;
        }
        $message = '';
        if ($this->input->post('create_privilege'))
        {
            $id   = $this->input->post('privilege_id'); 
            $name = $this->input->post('privilege_name');
            $desc = $this->input->post('privilege_desc');
            $status = $this->flexi_auth->update_privilege($id, array('upriv_name' => $name, 'upriv_desc' => $desc));
            if ($status == true) {
                redirect('admin/privileges');
                return TRUE;
            }
            $message = '修改失败，或没有进行改动';
        }
        $pri_info = $this->flexi_auth->get_privileges_query("upriv_id, upriv_name, upriv_desc", array("upriv_id" => $id))->row_array();
        $content = $this->load->view('backend/privileges/edit', array('pri_info' => $pri_info, 'message' => $message), TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '编辑权限'));
    }

    /**
     * Privilege delete
     */
    public function delete($id = null)
    {
        if (is_null($id)) {
            $this->show_list('删除编号为空，无法删除');
            return;
        }
        if ($this->flexi_auth->delete_privilege($id)) {
            redirect('admin/privileges');
            return TRUE;
        }
        $this->show_list('删除失败');
    }
}
