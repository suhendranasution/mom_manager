<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mom_manager_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'mom_manager')->row();
        }
        return $this->db->get(db_prefix() . 'mom_manager')->result_array();
    }
    
    public function get_by_hash($hash)
    {
        $this->db->where('hash', $hash);
        return $this->db->get(db_prefix() . 'mom_manager')->row();
    }

    public function add($data)
    {
        $data['created_at']  = date('Y-m-d H:i:s');
        $data['created_by']  = get_staff_user_id();
        $data['hash']        = md5(uniqid(rand(), true)); // Generate unique hash for public link

        $this->db->insert(db_prefix() . 'mom_manager', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'mom_manager', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'mom_manager');
        return $this->db->affected_rows() > 0;
    }
}