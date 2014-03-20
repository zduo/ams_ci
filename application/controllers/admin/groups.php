<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->auth = new stdClass;
        $this->load->library('flexi_auth');
        $this->load->model('auth_model');

        if (!$this->flexi_auth->is_logged_in_via_password() || !$this->flexi_auth->is_admin())
        {
            $this->flexi_auth->set_error_message('只有管理员才能管理用户', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
    }

    /**
     * Show a list of all the groups.
     *
     * @return View
     */
    public function index()
    {
        $this->show_list();
    }

    private function show_list($message = null)
    {
        if (! $this->flexi_auth->is_privileged('list_group'))
        {
            $this->session->set_flashdata('message', '没有权限查看用户组');
            redirect('admin/welcome');
        }
        $grp_list = $this->flexi_auth->get_groups()->result_array();
        $content    = $this->load->view('backend/groups/list', array('grp_list' => $grp_list, 'message' => $message), TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '用户组列表'));
    }

    /**
     * Group Create
     */
    public function create()
    {
        if (! $this->flexi_auth->is_privileged('add_group'))
        {
            $this->session->set_flashdata('message', '没有权限查看用户组');
            redirect('admin/groups');
        }
        if ($this->input->post('create_group'))
        {
            $rtn = $this->auth_model->save_group();
            if ($rtn == true)
            {
                redirect('admin/groups');
                return true;
            }
        }
        $pri_list   = $this->flexi_auth->get_privileges_array();
        $content    = $this->load->view('backend/groups/create', array('pri_list' => $pri_list), TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '新建用户组'));
    }

    /**
     * Group update
     */
    public function edit($group_id = null)
    {
        if (! $this->flexi_auth->is_privileged('add_group'))
        {
            $this->session->set_flashdata('message', '没有权限查看用户组');
            redirect('admin/groups');
        }
        if (is_null($group_id) && !$this->input->post('create_group')) {
            $this->show_list('用户组编号为空，无法修改');
            return;
        }
        $message = '';
        if ($this->input->post('create_group'))
        {
            // save group update
            $rtn = $this->auth_model->edit_group();
            if ($rtn == true) {
                redirect('admin/groups');
                return true;
            }
            $message = "修改失败，或没有改动";
        }
        $sql_select = array($this->flexi_auth->db_column('user_privilege_groups', 'privilege_id'));
        $sql_where  = array($this->flexi_auth->db_column('user_privilege_groups', 'group_id') => $group_id);
        $group_privs= $this->flexi_auth->get_user_group_privileges_array($sql_select, $sql_where);
        $group_priv = array();
        if (!empty($group_privs)) {
            foreach ($group_privs as $group_item) {
                $group_priv[] = $group_item['upriv_groups_upriv_fk'];
            }
        }

        $pri_list   = $this->flexi_auth->get_privileges_array();
        $grp_where  = array($this->flexi_auth->db_column('user_group', 'id') => $group_id);
        $group_info = $this->flexi_auth->get_groups_row_array(FALSE, $grp_where);
        $content    = $this->load->view('backend/groups/edit', array('pri_list' => $pri_list, 'group_priv' => $group_priv, 'group_info' => $group_info, 'message' => $message), TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '修改用户组'));
    }

    /**
     * Group delete
     */
    public function delete($id = null)
    {
        if (! $this->flexi_auth->is_privileged('del_group'))
        {
            $this->session->set_flashdata('message', '没有权限删除用户组');
            redirect('admin/groups');
        }
        if (is_null($id) || !is_numeric($id)) {
            $this->show_list('删除编号为空，无法删除');
            return;
        }
        if ($this->flexi_auth->delete_group($id)) {
            redirect('admin/groups');
            return true;
        }
        $this->show_list('删除失败');
    }
}
