<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Server_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->table = 't_server_info';
		
		$this->column = array(
			'idc_id' => '所在IDC',
			'server_label' => '资产编号',
			'server_cabinet' => '所在机柜',
			'server_oem' => '品牌',
			'server_height' => '服务器U数',
			'server_cpu_model' => 'CPU型号',
			'server_cpu_count' => 'CPU数量',
			'server_memory' => '内存大小',
			'server_hd' => '硬盘',
			'server_powers' => '电源',
			'server_raid' => 'RAID',
			'server_os' => '系统',
			'server_desc' => '用途描述',
			'server_user' => '维护人员'
		);

    }

    public function &__get($key)
    {
        $CI =& get_instance();
        return $CI->$key;
    }
	public function table_column(){
		return $this->column;
	}

    /**
     * 获得SERVER列表
     */
    public function server_list($num = 6) 
    {
        // 列表总数
        $total  = $this->server_list_num();
        $uri    = $this->uri->uri_to_assoc(4);
        $offset = (isset($uri['page'])) ? $uri['page'] : FALSE;
        $config['uri_segment']  = 5;
        $config['base_url']     = base_url('admin/server/index/page/');
        $config['total_rows']   = $total;
        $config['per_page']     = $num;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $this->data['pagination']['links']      = $this->pagination->create_links();
        $this->data['pagination']['total_keys'] = $total;
        $this->data['servers']                    = $this->server_list_content($num, $offset);
    }

    /**
     * 获得SERVER列表内容 
     */
    public function server_list_content($num, $offset)
    {
        if (empty($offset)) $offset = 0;
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table, $num, $offset);
        $servers = $query->result_array();
        
        return $servers;
    }

    /**
     * 获得SERVER列表数
     */
    public function server_list_num()
    {
        $this->db->select('count(id) as num')->from($this->table);
        $query = $this->db->get();
        $num_row = $query->row();
        $num = $num_row->num;
        return $num;
    }

    /**
     * SERVER信息
     */
    public function server_info($server_id)
    {
        if (empty($server_id))
            return array();

        $query = $this->db->get_where($this->table, array('id' => $server_id));
        $server_info = $query->row_array();
        return $server_info;
    }

    public function edit_server()
    {
        $server_id            = $this->input->post('server_id');
        foreach($this->column as $k=>$v){
			if($k=='server_cpu_count' || $k=='server_memory'){
				$bind[$k] = intval($this->input->post($k));
			}else{
				$bind[$k] = $this->input->post($k);
			}
		}
        
        $status = $this->db->update($this->table, $bind, array('id'=>$server_id));
        
        return $status;
    }

    public function save_server()
    {
        
		foreach($this->column as $k=>$v){
			if($k=='server_cpu_count' || $k=='server_memory'){
				$bind[$k] = intval($this->input->post($k));
			}else{
				$bind[$k] = $this->input->post($k);
			}
		}

		$this->db->insert($this->table, $bind);
		redirect('admin/server');
		return true;
        
    }

    public function delete_server($server_id)
    {
        $query = $this->db->query('select id from `t_server_info` where server_id='.$server_id);;
        $row_num = $query->num_rows();
        if ($row_num > 0)
        {
            $this->session->set_flashdata('message', '该SERVER下有服务器，无法删除.');
            return false;
        }
        $status = $this->db->delete($this->table, array('id' => $server_id));
        return $status;
    }

}
