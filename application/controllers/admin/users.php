<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

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

        $this->data = null;
    }

    /**
     * Show a list of all the users.
     *
     * @return View
     */
    public function index()
    {
        if (!$this->flexi_auth->is_privileged('list_user'))
        {
            $this->session->set_flashdata('message', '没有权限查看用户');
            redirect('admin/welcome');
        }
        if ($this->input->post('search_users') && $this->input->post('search_query'))
        {
            $search_query = str_replace(' ','-',$this->input->post('search_query'));
            redirect('admin/users/index/search/'.$search_query.'/page/');
        }
        else if ($this->input->post('update_users'))
        {
            $this->auth_model->update_user_accounts();
        }

        // Get user account data for all users.
        // If a search has been performed, then filter the returned users.
        $this->auth_model->get_user_accounts();

        // Set any returned status/error messages.
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $content = $this->load->view('backend/users/list', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '用户列表'));
    }

    /**
     * User update
     */
    public function edit($user_id = null)
    {
        if (!$this->flexi_auth->is_privileged('add_user'))
        {
            $this->session->set_flashdata('message', '没有权限修改用户');
            redirect('admin/users');
        }

        if ($this->input->post('update_user'))
        {
            $this->auth_model->update_user_account($user_id);
        }

        // Get users current data.
        $sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $user_id);
        $this->data['user'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);

        // Get users groups.
        $this->data['groups'] = $this->flexi_auth->get_groups_array();

        // Get all privilege data.
        $sql_select = array(
            $this->flexi_auth->db_column('user_privileges', 'id'),
            $this->flexi_auth->db_column('user_privileges', 'name'),
            $this->flexi_auth->db_column('user_privileges', 'description')
        );
        $this->data['privileges'] = $this->flexi_auth->get_privileges_array($sql_select);
        
        // Get user groups current privilege data.
        $sql_select = array($this->flexi_auth->db_column('user_privilege_groups', 'privilege_id'));
        $sql_where = array($this->flexi_auth->db_column('user_privilege_groups', 'group_id') => $this->data['user'][$this->flexi_auth->db_column('user_acc', 'group_id')]);
        $group_privileges = $this->flexi_auth->get_user_group_privileges_array($sql_select, $sql_where);
        
        $this->data['group_privileges'] = array();
        foreach($group_privileges as $privilege)
        {
            $this->data['group_privileges'][] = $privilege[$this->flexi_auth->db_column('user_privilege_groups', 'privilege_id')];
        }

        // Get users current privilege data.
        $sql_select = array($this->flexi_auth->db_column('user_privilege_users', 'privilege_id'));
        $sql_where = array($this->flexi_auth->db_column('user_privilege_users', 'user_id') => $user_id);
        $user_privileges = $this->flexi_auth->get_user_privileges_array($sql_select, $sql_where);
        
        $this->data['user_privileges'] = array();
        foreach($user_privileges as $privilege)
        {
            $this->data['user_privileges'][] = $privilege[$this->flexi_auth->db_column('user_privilege_users', 'privilege_id')];
        }

        $this->data['privilege_sources'] = $this->auth->auth_settings['privilege_sources'];
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        
        $content = $this->load->view('backend/users/edit', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '修改用户'));
    }

    public function welcome()
    {
        $this->load->view('backend/layouts/default', array('content' => '欢迎开始使用后台', 'title' => '用户欢迎信息'));
    }
}
