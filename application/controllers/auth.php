<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->auth = new stdClass;
        $this->load->library('flexi_auth');

        if ($this->flexi_auth->is_logged_in_via_password() && uri_string() != 'auth/logout')
        {
            if ($this->session->flashdata('message')) { $this->session->keep_flashdata('message'); }
            if ($this->flexi_auth->is_admin())
            {
                redirect('admin/users/welcome');
            }
            else
            {
                redirect('admin/welcome');
            }
        }

        $this->load->model('auth_model');
        $this->data = null;
    }

    /**
     * index
     * Forwords to 'signin'
     */
    public function index()
    {
        $this->signin();
    }

    /**
     * Account Sign in.
     *
     * @return View
     */
    public function signin()
    {
        if ($this->input->post('login_user'))
        {
            $this->auth_model->login();
        }
        if ($this->flexi_auth->ip_login_attempts_exceeded()) {
            $this->data['captcha'] = $this->flexi_auth->math_captcha(FALSE);
        }
        $this->data['message']  = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content                = $this->load->view('backend/auth/signin', $this->data, true);
        $this->load->view('backend/layouts/auth', array('content' => $content, 'title' => '用户登录'));
    }

    /**
     * Account Register
     */
    public function register()
    {
        // Redirect user away from registration page if already logged in.
        if ($this->flexi_auth->is_logged_in())
        {
            redirect('auth');
        }
        // If 'Registration' form has been submitted, attempt to register their details as a new account.
        else if ($this->input->post('register_user'))
        {
            $this->auth_model->register_account();
        }
        
        // Get any status message that may have been set.
        $this->data['message']  = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content                = $this->load->view('backend/auth/register', $this->data, true);

        $this->load->view('backend/layouts/auth', array('content' => $content, 'title' => '用户注册'));
    }

    /**
     * Active Account
     */
    public function activate_account($user_id, $token = FALSE)
    {
        $this->flexi_auth->activate_user($user_id, $token, TRUE);
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
        redirect('auth');
    }

    public function logout()
    {
        $this->flexi_auth->logout(TRUE);
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
        redirect('auth');
    }

    public function forgotten_password()
    {
        if ($this->input->post('send_forgotten_password'))
        {
            $this->auth_model->forgotten_password();
        }

        $this->data['message']  = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content                = $this->load->view('backend/auth/forgotten_password', $this->data, TRUE);
        $this->load->view('backend/layouts/auth', array('content' => $content, 'title' => '忘记密码'));
    }

    public function manual_reset_forgotten_password($user_id = FALSE, $token = FALSE)
    {
        if ($this->input->post('change_forgotten_password'))
        {
            $this->auth_model->manual_reset_forgotten_password($user_id, $token);
        }
        $this->data['message']  = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content                = $this->load->view('backend/auth/forgotten_password_update_view', $this->data, TRUE);
        $this->load->view('backend/layouts/auth', array('content' => $content, 'title' => '重置密码'));
    }

}
