<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getTotalPemasukanByIdUser($id_user)
    {
        $this->db->select_sum('jumlah');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('pemasukan');
        return $query->row()->jumlah;
    }

    public function getTotalPengeluaranByIdUser($id_user)
    {
        $this->db->select_sum('jumlah');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('pengeluaran');
        return $query->row()->jumlah;
    }

    public function getSisaSaldo()
    {
        $id_user = $this->session->userdata('id_user');

        $total_pemasukan = $this->getTotalPemasukanByIdUser($id_user);
        $total_pengeluaran = $this->getTotalPengeluaranByIdUser($id_user);
        return $total_pemasukan - $total_pengeluaran;
    }

    public function getAllDataActionLog($id_user)
    {
        $this->db->select('a.*, b.firstname, b.lastname');
        $this->db->join('users b', 'b.id_user = a.id_user', 'left');
        $this->db->where('a.id_user', $id_user);
        $this->db->order_by('a.timestamp', 'desc');
        $query = $this->db->get('action_log a');
        return $query->result_array();
    }

    public function getBudgetCurrentMonth($id_user)
    {
        $this->db->select('jumlah');
        $this->db->from('budget');
        $this->db->where('MONTH(timestamp)', date('m'));
        $this->db->where('YEAR(timestamp)', date('Y'));
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->jumlah;
        } else {
            return 0;
        }
    }

    // public function getAllDataBudgetPengeluaran()
    // {
    //     $this->db->select('b.*, p.total_pengeluaran');
    //     $this->db->from('budget b');
    //     $this->db->join('(SELECT kode_budget, SUM(jumlah) AS total_pengeluaran FROM pengeluaran GROUP BY kode_budget) p', 'b.kode_budget = p.kode_budget', 'left');
    //     $query = $this->db->get();

    //     return $query->result_array();
    // }

    public function getFotoProfile($id_user)
    {
        $this->db->select('file_path');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('users');
        return $query->result_array();
    }
}
