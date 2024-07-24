<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data_thr extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getDataThrById($id_thr)
    {
        $this->db->where('id_thr', $id_thr);
        $query = $this->db->get('thr');
        return $query;
    }

    public function getDataThrByIdUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('thr');
        return $query->result_array();
    }

    public function deleteDataThr($id_thr)
    {
        $this->db->where('id_thr', $id_thr);
        return $this->db->delete('thr');
    }

    public function getFotoProfile($id_user)
    {
        $this->db->select('file_path');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('users');
        return $query->result_array();
    }
}
