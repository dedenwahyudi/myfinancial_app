<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data_pemasukan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllDataPemasukan()
    {
        $query = $this->db->get('pemasukan');
        return $query->result_array();
    }

    public function getDataPemasukanByDate($start_date, $end_date, $id_user)
    {
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->where('id_user', $id_user);
        return $this->db->get('pemasukan')->result_array();
    }

    public function getDataPemasukanById($id_pemasukan)
    {
        $this->db->where('id_pemasukan', $id_pemasukan);
        $query = $this->db->get('pemasukan');
        return $query;
    }

    public function getDataPemasukanByIdUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('pemasukan');
        return $query->result_array();
    }

    public function deleteDataPemasukan($id_pemasukan)
    {
        $this->db->where('id_pemasukan', $id_pemasukan);
        return $this->db->delete('pemasukan');
    }

    public function getFotoProfile($id_user)
    {
        $this->db->select('file_path');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('users');
        return $query->result_array();
    }
}
