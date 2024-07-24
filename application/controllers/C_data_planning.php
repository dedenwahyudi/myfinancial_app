<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_data_planning extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('user_level') != '1') {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <span style="font-size: 14px;">Silahkan login...!</span>
                                                    </div>');
            redirect('C_auth');
        }
        $this->load->model('planning/M_data_planning', 'M_data_planning');
        $this->load->helper('rupiah');
    }

    public function index()
    {
        $data['title'] = 'Data Planning';

        $id_user = $this->session->userdata('id_user');
        $data['foto'] = $this->M_data_planning->getFotoProfile($id_user)[0]['file_path'];

        $data['data_planning'] = $this->M_data_planning->getDataPlanningByIdUser($id_user);

        $total_pemasukan = $this->M_data_planning->getTotalPemasukan();
        $data['total_pemasukan'] = $total_pemasukan !== null ? $total_pemasukan : 0;

        $data['view'] = 'super_admin/v_planning';

        if ($this->input->is_ajax_request()) {
            $this->load->view($data['view'], $data);
        } else {
            $this->load->view('templates/tmp_header');
            $this->load->view('templates/tmp_navbar', $data);
            $this->load->view('templates/tmp_sidebar');
            $this->load->view('templates/tmp_main_content', $data);
            $this->load->view('templates/tmp_footer');
        }
    }

    public function input_data_planning()
    {
        $id_user = $this->session->userdata('id_user');
        $tanggal = $this->input->post('tanggal_planning', true);
        $deadline = $this->input->post('deadline_planning', true);
        $tujuan = $this->input->post('tujuan_planning', true);
        // Jumlah Anggaran
        $jml_anggaran = $this->input->post('jumlah_anggaran_planning', true);
        $jumlah_anggaran = clean_rupiah($jml_anggaran);
        // Dana Tersedia
        $dana = $this->input->post('dana_tersedia', true);
        $dana_tersedia = clean_rupiah($dana);
        $item =  $this->input->post('item_planning', true);
        // Estimasi
        $estimasi =  $this->input->post('estimasi_harga', true);
        $estimasi_harga = clean_rupiah($estimasi);
        // Total Estimasi
        $total =  $this->input->post('total_harga_planning', true);
        $total_estimasi = clean_rupiah($total);

        $this->db->trans_begin();

        // Start Get Last ID From Table planning
        $get_last_id = $this->db->query('SELECT MAX(id_planning) as max_id FROM planning');
        $row = $get_last_id->row();
        $last_id = $row->max_id;
        $id_planning = $last_id + 1;
        // Start Get Last ID From Table planning

        $data_detail_planning = [];
        for ($i = 0; $i < count($item); $i++) {
            $data_detail_planning[] = [
                "id_planning" => $id_planning,
                "nama_item" => $item[$i],
                "estimasi_harga" => $estimasi_harga[$i]
            ];
        }
        $this->db->insert_batch('planning_detail', $data_detail_planning);

        $data_planning = array(
            'tanggal_rencana' => $tanggal,
            'tanggal_deadline' => $deadline,
            'tujuan' => $tujuan,
            'jumlah_anggaran' => $jumlah_anggaran,
            'total_estimasi' =>  $total_estimasi,
            'dana_tersedia' => $dana_tersedia,
            'id_user' => $id_user
        );
        $this->db->insert('planning', $data_planning);

        $action_log = array(
            'menu' => 'Data Planning > Input Data Planning',
            'keterangan' => 'Input data planning',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di simpan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_planning');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di simpan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_planning');
        }
    }

    public function delete_data_planning($id_planning)
    {
        $result1 = $this->M_data_planning->deleteDataPlanning($id_planning);
        $result2 = $this->M_data_planning->deleteDataPlanningDetail($id_planning);

        if (!empty($result1) && !empty($result2)) {
            $user_input = $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname');
            $action_log = array(
                'menu' => 'Planning > Delete Data Planning',
                'keterangan' => 'Delete data planning',
                'user_action' => $user_input
            );
            $this->db->insert('action_log', $action_log);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <span>Data berhasil di hapus.</span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <span>Gagal menghapus data.</span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>');
        }
        redirect('C_data_planning');
    }

    public function get_data_planning_detail_by_id()
    {
        $id_planning = $this->input->post('id_planning');
        $query = $this->M_data_planning->getDataPlanningDetailById($id_planning);
        $result = $query->result();
        echo json_encode($result);
    }

    public function get_data_planning_by_id()
    {
        $id_planning = $this->input->post('id_planning');
        $query = $this->M_data_planning->getDataPlanningById($id_planning);
        $result = $query->result();
        echo json_encode($result);
    }
}
