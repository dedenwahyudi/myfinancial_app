<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data_planning extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAllDataPlanning()
    {
        $query = $this->db->get('planning');
        return $query->result_array();
    }

    public function getDataPlanningByDate($start_date, $end_date)
    {
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        return $this->db->get('planning')->result_array();
    }

    public function getDataPlanningDetailById($id_planning)
    {
        $this->db->where('id_planning', $id_planning);
        $query = $this->db->get('planning_detail');
        return $query;
    }

    public function getDataPlanningById($id_planning)
    {
        $this->db->where('id_planning', $id_planning);
        $query = $this->db->get('planning');
        return $query;
    }

    public function getDataPlanningByIdUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('planning');
        return $query->result_array();
    }

    public function deleteDataPlanning($id_planning)
    {
        $this->db->where('id_planning', $id_planning);
        return $this->db->delete('planning');
    }

    public function deleteDataPlanningDetail($id_planning)
    {
        $this->db->where('id_planning', $id_planning);
        return $this->db->delete('planning_detail');
    }

    public function getTotalPemasukan()
    {
        $this->db->select_sum('jumlah');
        $query = $this->db->get('pemasukan');
        return $query->row()->jumlah;
    }

    public function getFotoProfile($id_user)
    {
        $this->db->select('file_path');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('users');
        return $query->result_array();
    }
}
