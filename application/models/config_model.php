<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'memcached'));
    }

    public function &__get($key)
    {
        $CI =& get_instance();
        return $CI->$key;
    }

    public function save_welcome()
    {
        $up_config = array(
            'upload_path'   => FCPATH.'img/',
            'allowed_types' => 'jpg',
            'overwrite'     => TRUE,
        );
        $image_types = array(
            'nl_img'    => 'welcome.jpg',
            'logo_img'  => 'logo.png',
        );
        $this->load->library('upload');
        foreach ($image_types as $image_type => $image_file_name)
        {
            if (empty($_FILES[$image_type]['name'])) continue;
            if ($image_type == 'logo_img')
            {
                $up_config['allowed_types'] = 'png';
            }
            else
            {
                $up_config['allowed_types'] = 'jpg';
            }
            $up_config['file_name'] = $image_file_name;
            $this->upload->initialize($up_config);
            if (!$this->upload->do_upload($image_type))
            {
                $this->session->set_flashdata('message', $this->upload->display_errors());
                redirect('admin/config');
            }
        }
        $this->session->set_flashdata('message', '上传成功');
        redirect('admin/config');
    }

    public function get_keys()
    {
        $this->db->select('count(id) as num')->from('config_key');
        $query = $this->db->get();
        $num_row = $query->row();
        $total_keys = $num_row->num;

        $uri = $this->uri->uri_to_assoc(4);
        $offset = (isset($uri['page'])) ? $uri['page'] : FALSE;
        $config['uri_segment']  = 5;
        $config['base_url']     = base_url('admin/config/search_key/page/');
        $config['total_rows']   = $total_keys;
        $config['per_page']     = 10;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $this->data['pagination']['links']      = $this->pagination->create_links();
        $this->data['pagination']['total_keys'] = $total_keys;
        $query = $this->db->get('config_key', $config['per_page'], $offset);
        $this->data['keys'] = $query->result_array();
    }

    public function get_key($key_id)
    {
        if (empty($key_id) || !is_numeric($key_id))
        {
            $this->data['message'] = '关键词映射错误';
            return FALSE;
        }
        $query = $this->db->get_where('config_key', array('id' => $key_id));
        $this->data['key_info'] = $query->row_array();
    }

    public function delete_key()
    {
        if ($delete_keys = $this->input->post('delete_key'))
        {
            foreach ($delete_keys as $key_id => $delete)
            {
                $rtn = $this->db->delete('config_key', array('id' => $key_id));
                $message = ($rtn == TRUE) ? '删除成功' : '删除失败';
                if ($rtn != TRUE) break;
            }
            $this->session->set_flashdata('message', $message);
            redirect('admin/config/search_key');
        }
    }

    public function get_intro_info()
    {
        $cache_name = 'intro';
        $rtn = $this->cache->get($cache_name);
        if (!empty($rtn))
            return $rtn;
        $query = $this->db->get_where('system_config', array('config_name' => 'intro'));
        $info = $query->row_array();
        $data = array(
            'logo'      => '',
            'intro_img' => '',
            'badge'     => ''
        );
        if (!empty($info))
        {
            $data = unserialize($info['config_value']);
            if (isset($data['logo']))
            {
                $data['logo'] = $this->imagecheck->check_img($data['logo']);
            }
            if (isset($data['intro_img']))
            {
                $data['intro_img'] = $this->imagecheck->check_img($data['intro_img']);
            }
            if (isset($data['badge']))
            {
                $data['badge'] = $this->imagecheck->check_img($data['badge']);
            }
        }
        $this->cache->save($cache_name, $data, 3600);
        return $data;
    }

    public function get_contact_info()
    {
        $cache_name = 'contact';
        $rtn = $this->cache->get($cache_name);
        if (!empty($rtn))
            return $rtn;
        $query = $this->db->get_where('system_config', array('config_name' => 'contact'));
        $info = $query->row_array();
        if (empty($info))
        {
            $intro = '';
        }
        else
        {
            $intro = $info['config_value'];
        }
        $this->cache->save($cache_name, $intro, 3600);
        return $intro;
    }

    public function get_intro()
    {
        $query = $this->db->get_where('system_config', array('config_name' => 'intro'));
        $info = $query->row_array();
        if (empty($info))
        {
            $data = '';
        }
        else
        {
            $this->load->library('imagecheck');
            $data = unserialize($info['config_value']);
            if (isset($data['logo']))
            {
                $data['logo'] = $this->imagecheck->check_img($data['logo']);
            }
            if (isset($data['intro_img']))
            {
                $data['intro_img'] = $this->imagecheck->check_img($data['intro_img']);
            }
            if (isset($data['badge']))
            {
                $data['badge'] = $this->imagecheck->check_img($data['badge']);
            }
        }
        $this->data['data'] = $data;
    }

    public function save_intro()
    {
        $this->load->library('form_validation');
        $validation_rules = array(
            array('field' => 'intro1', 'label' => 'intro1', 'rules' => 'required')
        );
        $this->form_validation->set_rules($validation_rules);
        if (! $this->form_validation->run())
        {
            $this->data['message'] = validation_errors();
            return FALSE;
        }
        $query = $this->db->get_where('system_config', array('config_name' => 'intro'));
        $info = $query->row_array();
        if (!empty($info))
        {
            $intro = unserialize($info['config_value']);
        }
        $intro['weibo'] = $this->input->post('weibo');
        $intro['weixin']= $this->input->post('weixin');
        $intro['host']  = $this->input->post('host');
        $intro['intro1']= $this->input->post('intro1');
        $intro['intro2']= $this->input->post('intro2');
        $up_config = array(
            'upload_path'   => FCPATH.'img/about/',
            'allowed_types' => 'gif|jpg|png|jpeg',
            'encrypt_name'  => TRUE
        );
        $this->load->library('upload', $up_config);
        if ($this->upload->do_upload('logo'))
        {
            $logo_data = array('upload_data' => $this->upload->data());
            $intro['logo'] = str_replace(FCPATH, "", $logo_data['upload_data']['full_path']);
        }
        if ($this->upload->do_upload('intro_img'))
        {
            $intro_data = array('upload_data' => $this->upload->data());
            $intro['intro_img'] = str_replace(FCPATH, "", $intro_data['upload_data']['full_path']);
        }
        if ($this->upload->do_upload('badge'))
        {
            $badge_data = array('upload_data' => $this->upload->data());
            $intro['badge'] = str_replace(FCPATH, "", $badge_data['upload_data']['full_path']);
        }

        $intro_serialize = serialize($intro);
        if (empty($info))
        {
            $this->db->insert('system_config', array('config_name' => 'intro', 'config_value' => $intro_serialize));
        }
        else
        {
            $this->db->where('config_name', 'intro');
            $this->db->update('system_config', array('config_value' => $intro_serialize));
        }
        $this->cache->delete('intro');
        redirect('admin/config/intro');
    }

    public function save_contact()
    {
        $this->load->library('form_validation');
        $validation_rules = array(
            array('field' => 'contact', 'label' => 'contact', 'rules' => 'required|max_length[200]')
        );
        $this->form_validation->set_rules($validation_rules);
        if ($this->form_validation->run())
        {
            $query = $this->db->get_where('system_config', array('config_name' => 'contact'));
            $info = $query->row_array();
            if (empty($info))
            {
                $this->db->insert('system_config', array('config_name' => 'contact', 'config_value' => $this->input->post('contact')));
            }
            else
            {
                $this->db->where('config_name', 'contact');
                $this->db->update('system_config', array('config_value' => $this->input->post('contact')));
            }
            $this->cache->delete('contact');
            redirect('admin/config/contact');
        }
        else
        {
            $this->data['message'] = validation_errors();
            return FALSE;
        }
    }

    public function get_contact()
    {
        $query = $this->db->get_where('system_config', array('config_name' => 'contact'));
        $info = $query->row_array();
        if (empty($info))
        {
            $this->data['contact'] = '';
        }
        else
        {
            $this->data['contact'] = $info['config_value'];
        }
    }

    public function save_key()
    {
        $this->load->library('form_validation');
        $validation_rules = array(
            array('field' => 'key_str', 'label' => '搜索关键词', 'rules' => 'required'),
            array('field' => 'key_map_str', 'label' => '搜索映射', 'rules' => 'required')
        );
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run())
        {
            if ($this->search_key_exists($this->input->post('key_str')) == TRUE)
            {
                $this->data['message'] = '搜索词已经存在';
                return FALSE;
            }
            $this->db->insert('config_key', array(
                'key_str'       => trim($this->input->post('key_str')),
                'key_map_str'   => trim($this->input->post('key_map_str')),
            ));
            redirect('admin/config/search_key');
        }
        else
        {
            $this->data['message'] = validation_errors();
            return FALSE;
        }
    }

    public function edit_key($key_id)
    {
        if (empty($key_id) || !is_numeric($key_id))
        {
            $this->data['message'] = '用户编辑错误';
            return FALSE;
        }
        $this->load->library('form_validation');
        $validation_rules = array(
            array('field' => 'key_str', 'label' => '搜索关键词', 'rules' => 'required'),
            array('field' => 'key_map_str', 'label' => '搜索映射', 'rules' => 'required')
        );
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run())
        {
            $this->db->where('id', $key_id);
            $this->db->update('config_key', array(
                'key_str'       => $this->input->post('key_str'),
                'key_map_str'   => $this->input->post('key_map_str')
            ));
            redirect('admin/config/search_key');
        }
        else
        {
            $this->data['message'] = validation_errors();
            return FALSE;
        }
    }

    private function search_key_exists($key_str)
    {
        if (empty($key_str))
            return FALSE;
        $this->db->select('id');
        $query = $this->db->get_where('config_key', array('key_str' => $key_str));
        if ($query->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function back()
    {
        $back_file = $this->input->post('back');
        $back_file_path = BASEPATH."../dbback/".$back_file;
        if (!file_exists($back_file_path))
        {
            $this->data['message'] = '备份文件不存在:'.$back_file;
            return FALSE;
        }
        $cmd = 'nohup /bin/sh '.BASEPATH.'../dbimport.sh '.$back_file.' > /dev/null 2>&1 &';
        exec($cmd);
        $this->load->driver('cache', array('adapter' => 'memcached'));
        $this->_set_version('bake');
        $this->_set_version('shop');
        $this->data['message'] = '恢复成功';
        redirect('auth');
    }

    private function _set_version($name)
    {
        if (!in_array($name, array('bake', 'shop')))
        {
            return 1;
        }
        $version = $this->cache->get($name.'_version', $version, 86400);
        $version ++;
        $this->cache->save($name.'_version', $version, 86400);
    }
}
