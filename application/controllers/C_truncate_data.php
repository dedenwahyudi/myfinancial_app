<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_truncate_data extends CI_Controller
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
    }

    public function truncate_tables()
    {
        $tables = [
            'action_log',
            'budget',
            'pemasukan',
            'pengeluaran',
            'planning',
            'planning_detail',
            'tagihan',
            'thr'
        ];

        foreach ($tables as $table) {
            $this->db->truncate($table);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                                        <span style="font-size: 14px;">Tables truncated successfully</span>
                                                    </div>');

        redirect('C_dashboard');
    }
}
