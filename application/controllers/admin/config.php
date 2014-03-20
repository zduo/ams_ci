<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->auth = new stdClass;
        $this->load->library('flexi_auth');
        $this->load->model('config_model');

        if (!$this->flexi_auth->is_logged_in_via_password())
        {
            $this->flexi_auth->set_error_message('请先登录', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
        $this->data = null;
    }

    /**
     * Logo image upload
     */
    public function index()
    {
        if (!$this->flexi_auth->is_privileged('list_all'))
        {
            $this->session->set_flashdata('message', '没有权限查看用户');
            redirect('admin/welcome');
        }
        if ($this->input->post('upload_welcome_img'))
        {
            $this->config_model->save_welcome();
        }
        
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $content = $this->load->view('backend/config/welcome', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '欢迎&Logo'));
    }

    /**
     * 关于
     */
    public function intro()
    {
        if (!$this->flexi_auth->is_privileged('list_all'))
        {
            $this->session->set_flashdata('message', '没有权限修改');
            redirect('admin/welcome');
        }
        if ($this->input->post('update_intro'))
        {
            $this->config_model->save_intro();
        }
        $this->config_model->get_intro();
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content = $this->load->view('backend/config/intro', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '关于'));
    }

    /**
     * 联系方式
     */
    public function contact()
    {
        if (!$this->flexi_auth->is_privileged('list_all'))
        {
            $this->session->set_flashdata('message', '没有权限修改');
            redirect('admin/welcome');
        }
        if ($this->input->post('update_contact'))
        {
            $this->config_model->save_contact();
        }
        $this->config_model->get_contact();
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content = $this->load->view('backend/config/contact', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '联系方式'));
    }

    /**
     * 搜索关键词映射
     */
    public function search_key()
    {
        if ($this->input->post('delete_key'))
        {
            $this->config_model->delete_key();
        }
        $this->config_model->get_keys();
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content = $this->load->view('backend/config/key', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '搜索关键字'));
    }

    /**
     * 添加关键词映射
     */
    public function create_key()
    {
        if ($this->input->post('create_key'))
        {
            $rtn = $this->config_model->save_key();
            if ($rtn == true)
            {
                redirect('admin/config/search_key');
                return true;
            }
        }
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content = $this->load->view('backend/config/create_key', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '新建关键词映射'));
    }

    /**
     * 修改关键词映射
     */
    public function edit_key($key_id)
    {
        if ($this->input->post('update_key'))  
        {
            $rtn = $this->config_model->edit_key($key_id);
            if ($rtn == true)
            {
                redirect('admin/config/search_key');
                return true;
            }
        }
        $this->config_model->get_key($key_id);
        $this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $content = $this->load->view('backend/config/update_key', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '修改关键词映射'));
    }

    /**
     * 接口列表
     */
    public function api()
    {
        $this->data['apis'] = array(
            'Logo&欢迎图'   => 'api/config/logo',
            '烘焙分类列表'  => 'api/ordinary/list',
            '烘培蛋糕信息'  => 'api/ordinary/info?id=蛋糕ID',
            '名店列表'      => 'api/star/list',
            '名店信息'      => 'api/star/info?id=名店ID',
            '搜索提示'      => 'api/search/prompt?w=搜索词',
            '搜索结果'      => 'api/search/result?w=搜索词',
        );
        $content = $this->load->view('backend/config/api', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '接口列表'));
    }

    /**
     * 数据备份和恢复
     */
    public function back()
    {
        if ($this->input->post('reverse_back'))
        {
            $this->config_model->back();
        }
        $path = BASEPATH."../dbback/";
        $this->data['back_file'] = array();
        if (is_dir($path))
        {
            if ($dh = opendir($path))
            {
                while (($file = readdir($dh)) !== false)
                {
                    if ($file == '.' || $file == '..') continue;
                    $this->data['back_file'][] = $file;
                }
            }
        }
        $content = $this->load->view('backend/config/back', $this->data, TRUE);
        $this->load->view('backend/layouts/default', array('content' => $content, 'title' => '数据库备份'));
    }
}
