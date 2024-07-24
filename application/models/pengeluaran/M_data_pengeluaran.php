<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data_pengeluaran extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllDataPengeluaran()
    {
        $query = $this->db->get('pengeluaran');
        return $query->result_array();
    }

    public function getDataPengeluaranByDate($start_date, $end_date, $id_user)
    {
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->where('id_user', $id_user);
        return $this->db->get('pengeluaran')->result_array();
    }

    public function getDataPengeluaranById($id_pengeluaran)
    {
        $this->db->where('id_pengeluaran', $id_pengeluaran);
        $query = $this->db->get('pengeluaran');
        return $query;
    }

    public function getDataPengeluaranByIdUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('pengeluaran');
        return $query->result_array();
    }

    public function getDataBudgetById($id_budget)
    {
        $this->db->where('id_budget', $id_budget);
        $query = $this->db->get('budget');
        return $query;
    }

    public function deleteDataPengeluaran($id_pengeluaran)
    {
        $this->db->where('id_pengeluaran', $id_pengeluaran);
        return $this->db->delete('pengeluaran');
    }

    public function deleteDataBudgetPengeluaran($id_budget)
    {
        $this->db->where('id_budget', $id_budget);
        return $this->db->delete('budget');
    }

    public function getAllDataBudgetPengeluaran()
    {
        $this->db->select('b.*, p.total_pengeluaran');
        $this->db->from('budget b');
        $this->db->join('(SELECT kode_budget, SUM(jumlah) AS total_pengeluaran FROM pengeluaran GROUP BY kode_budget) p', 'b.kode_budget = p.kode_budget', 'left');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getDataBudgetPengeluaranByIdUser($id_user)
    {
        $this->db->select('b.*, p.total_pengeluaran');
        $this->db->from('budget b');
        $this->db->join('(SELECT kode_budget, SUM(jumlah) AS total_pengeluaran FROM pengeluaran GROUP BY kode_budget) p', 'b.kode_budget = p.kode_budget', 'left');
        $this->db->where('b.id_user', $id_user);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getTotalPemasukan()
    {
        $this->db->select_sum('jumlah');
        $query = $this->db->get('pemasukan');
        return $query->row()->jumlah;
    }

    public function getTotalPengeluaran()
    {
        $this->db->select_sum('jumlah');
        $query = $this->db->get('pengeluaran');
        return $query->row()->jumlah;
    }

    public function getSisaSaldo()
    {
        $total_pemasukan = $this->getTotalPemasukan();
        $total_pengeluaran = $this->getTotalPengeluaran();
        return $total_pemasukan - $total_pengeluaran;
    }

    public function getKodeBudget()
    {
        $this->db->select('kode_budget');
        $this->db->order_by('kode_budget', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('budget');

        if ($query->num_rows() > 0) {
            return $query->row()->kode_budget;
        } else {
            return null;
        }
    }

    public function cekKodeBudget($kode_budget)
    {
        $this->db->where('kode_budget', $kode_budget);
        $query = $this->db->get('budget');
        return $query;
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

    public function getFotoProfile($id_user)
    {
        $this->db->select('file_path');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('users');
        return $query->result_array();
    }
}
