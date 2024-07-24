<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data_tagihan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getDataTagihanById($id_tagihan)
    {
        $this->db->where('id_tagihan', $id_tagihan);
        $query = $this->db->get('tagihan');
        return $query;
    }

    public function getDataTagihanByIdUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tagihan');
        return $query->result_array();
    }

    public function deleteDataTagihan($id_tagihan)
    {
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->delete('tagihan');
    }

    public function getFotoProfile($id_user)
    {
        $this->db->select('file_path');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('users');
        return $query->result_array();
    }
}
