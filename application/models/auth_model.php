<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function &__get($key)
    {
        $CI =& get_instance();
        return $CI->$key;
    }
    
    /**
     * login
     */
    public function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        if ($this->flexi_auth->ip_login_attempts_exceeded()) {
            $this->form_validation->set_rules('login_captcha', 'Captcha Answer', 'required|validate_math_captcha['.$this->input->post('login_captcha').']');
        }

        if ($this->form_validation->run())
        {
            $remember_user = ($this->input->post('remember-me') == 1);
            $info = $this->flexi_auth->login($this->input->post('email'), $this->input->post('password'), $remember_user);

            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth/signin');
        }
        else
        {
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
            return FALSE;
        }
    }

    /**
     * 保存用户组
     */
    public function save_group()
    {
        $group_name     = $this->input->post('group_name');
        $group_desc     = $this->input->post('group_desc');
        $group_admin    = $this->input->post('is_admin');
        $group_priv     = $this->input->post('permission');
        if ($group_admin == 1)
            $group_admin = true;
        else
            $group_admin = false;
        $group_id = $this->flexi_auth->insert_group($group_name, $group_desc, $group_admin);
        if ($group_id == false) {
            return false;
        }
        if (isset($group_priv) && !empty($group_priv)) {
            foreach ($group_priv as $group_priv_id) {
                $this->flexi_auth->insert_user_group_privilege($group_id, $group_priv_id);
            }
        }
        return true;
    }

    /**
     * 修改用户
     */
    public function edit_group()
    {
        $group_id       = $this->input->post('group_id');
        $group_name     = $this->input->post('group_name');
        $group_desc     = $this->input->post('group_desc');
        $group_admin    = $this->input->post('is_admin');
        $group_priv     = $this->input->post('permission');
        if ($group_admin == 1)
            $group_admin = true;
        else
            $group_admin = false;
        $this->flexi_auth->update_group($group_id, array(
            $this->flexi_auth->db_column('user_group', 'name') => $group_name,
            $this->flexi_auth->db_column('user_group', 'description') => $group_desc,
            $this->flexi_auth->db_column('user_group', 'admin') => $group_admin,
        ));
        if (isset($group_priv) && !empty($group_priv)) {
            foreach ($group_priv as $group_priv_id => $group_priv_item) {
                if ($group_priv_item['current_status'] != $group_priv_item['new_status']) {
                    if ($group_priv_item['new_status'] == 1) {
                        $this->flexi_auth->insert_user_group_privilege($group_id, $group_priv_id);
                    } else {
                        $sql_where = array(
                            $this->flexi_auth->db_column('user_privilege_groups', 'group_id') => $group_id,
                            $this->flexi_auth->db_column('user_privilege_groups', 'privilege_id') => $group_priv_id
                        );
                        $this->flexi_auth->delete_user_group_privilege($sql_where); 
                    }
                }
            }
        }
        return true;
    }

    public function register_account()
    {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'email', 'label' => '邮件', 'rules' => 'required|valid_email|identity_available'),
            array('field' => 'username', 'label' => '用户名', 'rules' => 'required|min_length[4]|identity_available'),
            array('field' => 'password', 'label' => '密码', 'rules' => 'required|validate_password'),
            array('field' => 'repassword', 'label' => '重复密码', 'rules' => 'required|matches[password]')
        );

        $this->form_validation->set_rules($validation_rules);
        if ($this->form_validation->run()) {
            $email      = $this->input->post('email');
            $username   = $this->input->post('username');
            $password   = $this->input->post('password');
            // Set whether to instantly activate account.
            $instant_activate = TRUE;
            $response = $this->flexi_auth->insert_user($email, $username, $password, NULL, 3, $instant_activate);

            if ($response)
            {
                $email_data = array('identity' => $email);
                $this->flexi_auth->send_email($email, 'Welcome', 'registration_welcome.tpl.php', $email_data);
                $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

                if ($instant_activate && $this->flexi_auth->login($email, $password))
                {
                    redirect('auth/welcome');
                }
                // Redirect user to login page
                redirect('auth');
            }
        }
        return FALSE;
    }

    public function get_user_accounts()
    {
        $sql_select = array(
            $this->flexi_auth->db_column('user_acc', 'id'),
            $this->flexi_auth->db_column('user_acc', 'email'),
            $this->flexi_auth->db_column('user_acc', 'suspend'),
            $this->flexi_auth->db_column('user_acc', 'username'),
            $this->flexi_auth->db_column('user_group', 'name'),
        );
        $this->flexi_auth->sql_select($sql_select);
        
        $uri = $this->uri->uri_to_assoc(4);
        $limit = 10;
        $offset = (isset($uri['page'])) ? $uri['page'] :  FALSE;

        if (array_key_exists('search', $uri))
        {
            $pagination_url = 'admin/users/index/search/'.$uri['search'].'/';
            $config['uri_segment'] = 7; // Changing to 6 will select the 6th segment, example 'controller/function/search/query/page/10'.

            $search_query = str_replace('-',' ',$uri['search']);

            // Get users and total row count for pagination.
            // Custom SQL SELECT, WHERE and LIMIT statements have been set above using the sql_select(), sql_where(), sql_limit() functions.
            // Using these functions means we only have to set them once for them to be used in future function calls.
            $total_users = $this->flexi_auth->search_users_query($search_query)->num_rows();

            $this->flexi_auth->sql_limit($limit, $offset);
            $this->data['users'] = $this->flexi_auth->search_users_array($search_query);
        }
        else
        {
            $pagination_url = 'admin/users/index/';
            $search_query = FALSE;
            $config['uri_segment'] = 5; // 'controller/function/page/10'
            
            $total_users = $this->flexi_auth->get_users_query()->num_rows();

            $this->flexi_auth->sql_limit($limit, $offset);
            $this->data['users'] = $this->flexi_auth->get_users_array();
        }

        // Create user record pagination
        $this->load->library('pagination');
        $config['base_url']     = base_url($pagination_url.'page/');
        $config['total_rows']   = $total_users;
        $config['per_page']     = $limit;
        $this->pagination->initialize($config);

        // Make search query and pagination data available to view.
        $this->data['search_query']                 = $search_query;
        $this->data['pagination']['links']          = $this->pagination->create_links();
        $this->data['pagination']['total_users']    = $total_users;
    }

    public function update_user_accounts()
    {
        // 删除用户
        if ($delete_users = $this->input->post('delete_user'))
        {
            foreach ($delete_users as $user_id => $delete)
            {
                $this->flexi_auth->delete_user($user_id);
            }
        }

        // 更改用户禁用状态
        if ($user_status = $this->input->post('suspend_status'))
        {
            // Get current statuses to check if submitted status has changed.
            $current_status = $this->input->post('current_status');

            foreach ($user_status as $user_id => $status)
            {
                if ($current_status[$user_id] != $status)
                {
                    if ($status == 1)
                    {
                        $this->flexi_auth->update_user($user_id, array($this->flexi_auth->db_column('user_acc', 'suspend') => 1));
                    }
                    else
                    {
                        $this->flexi_auth->update_user($user_id, array($this->flexi_auth->db_column('user_acc', 'suspend') => 0));
                    }
                }
            }
        }

        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
        redirect('admin/users');
    }

    public function update_user_account($user_id)
    {
        $this->load->library('form_validation');

        // Set validation rules.
        $validation_rules = array(
            array('field' => 'email', 'label' => '邮箱', 'rules' => 'required|valid_email|identity_available['.$user_id.']'),
            array('field' => 'username', 'label' => '昵称', 'rules' => 'min_length[4]|identity_available['.$user_id.']'),
            array('field' => 'group', 'label' => '用户组', 'rules' => 'required|integer')
        );
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run())
        {
            $profile_data = array(
                $this->flexi_auth->db_column('user_acc', 'email') => $this->input->post('email'),
                $this->flexi_auth->db_column('user_acc', 'username') => $this->input->post('username'),
                $this->flexi_auth->db_column('user_acc', 'group_id') => $this->input->post('group')
            );
            $update_info_status = $this->flexi_auth->update_user($user_id, $profile_data);
            if ($update_info_status == TRUE)
            {
                foreach ($this->input->post('update') as $row)
                {
                    if ($row['new_status'] != $row['current_status'])
                    {
                        // Insert new user privilege.
                        if ($row['new_status'] == 1)
                        {
                            $this->flexi_auth->insert_privilege_user($user_id, $row['id']);
                        }
                        // Delete existing user privilege.
                        else
                        {
                            $sql_where = array(
                                $this->flexi_auth->db_column('user_privilege_users', 'user_id') => $user_id,
                                $this->flexi_auth->db_column('user_privilege_users', 'privilege_id') => $row['id'],
                            );
                            $this->flexi_auth->delete_privilege_user($sql_where);
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('admin/users');
        }
        return FALSE;
    }

    public function forgotten_password()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('forgot_password_identity', '邮箱或用户名', 'required');
        if ($this->form_validation->run())
        {
            $response = $this->flexi_auth->forgotten_password($this->input->post('forgot_password_identity'));
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
        else
        {
            // Set validation errors.
            $this->data['message'] = validation_errors();
            return FALSE;
        }
    }

    public function manual_reset_forgotten_password($user_id, $token)
    {
        $this->load->library('form_validation');
        $validation_rules = array(
            array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'required|validate_password|matches[confirm_new_password]'),
            array('field' => 'confirm_new_password', 'label' => 'Confirm Password', 'rules' => 'required')
        );
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run())
        {
            $new_password = $this->input->post('new_password');
            $this->flexi_auth->forgotten_password_complete($user_id, $token, $new_password);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
        else
        {
            $this->data['message'] = validation_errors();
            return FALSE;
        }
    }
}
