<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        <span style="font-size: 14px;">Silahkan login...!</span>
                                                    </div>');
            redirect('C_auth');
        }
        $this->load->model('dashboard/M_dashboard', 'M_dashboard');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $id_user = $this->session->userdata('id_user');

        $data['pemasukan'] = $this->M_dashboard->getTotalPemasukanByIdUser($id_user);
        if (!empty($data['pemasukan'])) {
            $data['data_pemasukan'] = $data['pemasukan'];
        } else {
            $data['data_pemasukan'] = 0;
        }

        $data['pengeluaran'] = $this->M_dashboard->getTotalPengeluaranByIdUser($id_user);
        if (!empty($data['pengeluaran'])) {
            $data['data_pengeluaran'] = $data['pengeluaran'];
        } else {
            $data['data_pengeluaran'] = 0;
        }

        $data['data_action_log'] = $this->M_dashboard->getAllDataActionLog($id_user);

        $data['saldo_utama'] = $this->M_dashboard->getSisaSaldo();

        $limit_budget = $this->M_dashboard->getBudgetCurrentMonth($id_user);
        $data['limit_budget'] = round($limit_budget);

        $foto_profile = $this->M_dashboard->getFotoProfile($id_user);
        $data['foto'] = $foto_profile[0]['file_path'];

        $data['view'] = 'v_dashboard';

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
}
