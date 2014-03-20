<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Idc_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->table = 't_idc_info';

    }

    public function &__get($key)
    {
        $CI =& get_instance();
        return $CI->$key;
    }

    /**
     * 获得IDC列表
     */
    public function idc_list($num = 6) 
    {
        // 列表总数
        $total  = $this->idc_list_num();
        $uri    = $this->uri->uri_to_assoc(4);
        $offset = (isset($uri['page'])) ? $uri['page'] : FALSE;
        $config['uri_segment']  = 5;
        $config['base_url']     = base_url('admin/idc/index/page/');
        $config['total_rows']   = $total;
        $config['per_page']     = $num;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $this->data['pagination']['links']      = $this->pagination->create_links();
        $this->data['pagination']['total_keys'] = $total;
        $this->data['idcs']                    = $this->idc_list_content($num, $offset);
    }

    /**
     * 获得IDC列表内容 
     */
    public function idc_list_content($num, $offset=0)
    {
        if (empty($offset)) $offset = 0;
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table, $num, $offset);
        $idcs = $query->result_array();
        
        return $idcs;
    }

    /**
     * 获得IDC列表数
     */
    public function idc_list_num()
    {
        $this->db->select('count(id) as num')->from($this->table);
        $query = $this->db->get();
        $num_row = $query->row();
        $num = $num_row->num;
        return $num;
    }

    /**
     * IDC信息
     */
    public function idc_info($idc_id)
    {
        if (empty($idc_id))
            return array();

        $query = $this->db->get_where($this->table, array('id' => $idc_id));
        $idc_info = $query->row_array();
        return $idc_info;
    }

    public function edit_idc()
    {
        $idc_id            = $this->input->post('idc_id');
        $bind['idc_name'] = $this->input->post('idc_name');
		$bind['idc_location'] = $this->input->post('idc_location');
		$bind['idc_desc'] = $this->input->post('idc_desc');
		$bind['idc_isp'] = $this->input->post('idc_isp');
		$bind['is_bgp'] = $this->input->post('is_bgp');
        
        $status = $this->db->update($this->table, $bind, array('id'=>$idc_id));
        
        return $status;
    }

    public function save_idc()
    {
        $bind['idc_name'] = $this->input->post('idc_name');
		$bind['idc_location'] = $this->input->post('idc_location');
		$bind['idc_desc'] = $this->input->post('idc_desc');
		$bind['idc_isp'] = $this->input->post('idc_isp');
		$bind['is_bgp'] = $this->input->post('is_bgp');

		$this->db->insert($this->table, $bind);
		redirect('admin/idc');
		return true;
        
    }

    public function delete_idc($idc_id)
    {
        $query = $this->db->query('select id from `t_server_info` where idc_id='.$idc_id);;
        $row_num = $query->num_rows();
        if ($row_num > 0)
        {
            $this->session->set_flashdata('message', '该IDC下有服务器，无法删除.');
            return false;
        }
        $status = $this->db->delete($this->table, array('id' => $idc_id));
        return $status;
    }

}
