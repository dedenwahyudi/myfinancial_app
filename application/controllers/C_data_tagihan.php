<?php
date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') or exit('No direct script access allowed');

class C_data_tagihan extends CI_Controller
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
        $this->load->model('tagihan/M_data_tagihan', 'M_data_tagihan');
        $this->load->helper('rupiah');
    }

    public function index()
    {
        $data['title'] = 'Data Tagihan';
        $id_user = $this->session->userdata('id_user');
        $data['foto'] = $this->M_data_tagihan->getFotoProfile($id_user)[0]['file_path'];
        $data['data_tagihan'] = $this->M_data_tagihan->getDataTagihanByIdUser($id_user);
        $data['view'] = 'super_admin/v_data_tagihan';

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

    public function buat_data_tagihan()
    {
        $id_user = $this->session->userdata('id_user');
        $nama_merchant = $this->input->post('nama_merchant', true);
        $jumlah_tenor = $this->input->post('jumlah_tenor', true);
        $jml_bayar = $this->input->post('jumlah_bayar', true);
        $cleanedValue = clean_rupiah($jml_bayar);
        $jumlah_bayar = (float) $cleanedValue;
        $sudah_dibayar = $this->input->post('sudah_dibayar', true);
        $belum_dibayar = $this->input->post('belum_dibayar', true);
        $jatuh_tempo = $this->input->post('jatuh_tempo', true);
        $keterangan = $this->input->post('keterangan', true);
        $status = $this->input->post('status', true);

        $this->db->trans_begin();

        $data_tagihan = array(
            'nama_merchant' => $nama_merchant,
            'jml_tenor' => $jumlah_tenor,
            'jml_bayar' => $jumlah_bayar,
            'sudah_dibayar' => $sudah_dibayar,
            'belum_dibayar' => $belum_dibayar,
            'tgl_jatuh_tempo' => $jatuh_tempo,
            'keterangan' => $keterangan,
            'status' => $status,
            'id_user' => $id_user
        );
        $this->db->insert('tagihan', $data_tagihan);

        $action_log = array(
            'menu' => 'Lain-lain > Tagihan > Buat Data Tagihan',
            'keterangan' => 'Buat Data Tagihan',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);


        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di simpan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pengeluaran');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di simpan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_tagihan');
        }
    }

    public function edit_data_tagihan()
    {
        $id_tagihan = $this->input->post('id_tagihan', true);
        $id_user = $this->session->userdata('id_user');
        $edit_nama_merchant = $this->input->post('edit_nama_merchant', true);
        $edit_jumlah_tenor = $this->input->post('edit_jumlah_tenor', true);
        $jml_bayar = $this->input->post('edit_jumlah_bayar', true);
        $cleanedValue = clean_rupiah($jml_bayar);
        $edit_jumlah_bayar = (float) $cleanedValue;
        $edit_sudah_dibayar = $this->input->post('edit_sudah_dibayar', true);
        $edit_belum_dibayar = $this->input->post('edit_belum_dibayar', true);
        $edit_jatuh_tempo = $this->input->post('edit_jatuh_tempo', true);
        $edit_keterangan = $this->input->post('edit_keterangan', true);
        $edit_status = $this->input->post('edit_status', true);

        $this->db->trans_begin();

        $data = array(
            'nama_merchant' => $edit_nama_merchant,
            'jml_tenor' => $edit_jumlah_tenor,
            'jml_bayar' => $edit_jumlah_bayar,
            'sudah_dibayar' => $edit_sudah_dibayar,
            'belum_dibayar' => $edit_belum_dibayar,
            'tgl_jatuh_tempo' => $edit_jatuh_tempo,
            'keterangan' => $edit_keterangan,
            'status' => $edit_status,
            'id_user' => $id_user,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id_tagihan', $id_tagihan);
        $this->db->update('tagihan', $data);

        $action_log = array(
            'menu' => 'Lain-lain > Tagihan > Edit Data Tagihan',
            'keterangan' => 'Edit Data Tagihan',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_tagihan');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_tagihan');
        }
    }

    public function delete_data_tagihan($id_tagihan)
    {
        $result = $this->M_data_tagihan->deleteDataTagihan($id_tagihan);
        if ($result) {
            $id_user = $this->session->userdata('id_user');
            $action_log = array(
                'menu' => 'Lain-lain > Delete Data Tagihan',
                'keterangan' => 'Delete data tagihan',
                'id_user' => $id_user
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
        redirect('C_data_tagihan');
    }

    public function get_data_tagihan_by_id()
    {
        $id_tagihan = $this->input->post('id_tagihan');
        $query = $this->M_data_tagihan->getDataTagihanById($id_tagihan);
        $result = $query->result();
        echo json_encode($result);
    }
}
