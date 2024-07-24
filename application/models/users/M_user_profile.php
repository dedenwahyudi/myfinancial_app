<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user_profile extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllDataProfileById($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->get('users')->result_array();
    }

    public function get_user_by_id($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->get('users')->row();
    }

    public function update_password($id_user, $new_password)
    {
        $this->db->where('id_user', $id_user);
        $this->db->update('users', array('password' => md5($new_password)));
        return $this->db->affected_rows() > 0;
    }
}
