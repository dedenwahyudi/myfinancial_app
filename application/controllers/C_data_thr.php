<?php
date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') or exit('No direct script access allowed');

class C_data_thr extends CI_Controller
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
        $this->load->model('thr/M_data_thr', 'M_data_thr');
        $this->load->helper('rupiah');
    }

    public function index()
    {
        $data['title'] = 'Data THR';
        $id_user = $this->session->userdata('id_user');
        $data['foto'] = $this->M_data_thr->getFotoProfile($id_user)[0]['file_path'];
        $data['data_thr'] = $this->M_data_thr->getDataThrByIdUser($id_user);
        $data['view'] = 'super_admin/v_data_thr';

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

    public function buat_data_thr()
    {
        $id_user = $this->session->userdata('id_user');
        $penerima = $this->input->post('penerima', true);
        $jumlah = $this->input->post('nominal', true);
        $cleanedValue = clean_rupiah($jumlah);
        $nominal = (float) $cleanedValue;
        $status = $this->input->post('status', true);
        $keterangan = $this->input->post('keterangan', true);

        $this->db->trans_begin();

        $data_thr = array(
            'penerima' => $penerima,
            'nominal' => $nominal,
            'status' => $status,
            'keterangan' => $keterangan,
            'id_user' => $id_user,
        );
        $this->db->insert('thr', $data_thr);

        $action_log = array(
            'menu' => 'Lain-lain > THR > Buat Data THR',
            'keterangan' => 'Buat Data THR',
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
            redirect('C_data_thr');
        }
    }

    public function edit_data_thr()
    {
        $id_thr = $this->input->post('id_thr', true);
        $id_user = $this->session->userdata('id_user');
        $edit_penerima = $this->input->post('edit_penerima', true);
        $edit_jumlah = $this->input->post('edit_nominal', true);
        $cleanedValue = clean_rupiah($edit_jumlah);
        $edit_nominal = (float) $cleanedValue;
        $edit_status = $this->input->post('edit_status', true);
        $edit_keterangan = $this->input->post('edit_keterangan', true);

        $this->db->trans_begin();

        $data = array(
            'penerima' => $edit_penerima,
            'nominal' => $edit_nominal,
            'status' => $edit_status,
            'keterangan' => $edit_keterangan,
            'id_user' => $id_user,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id_thr', $id_thr);
        $this->db->update('thr', $data);

        $action_log = array(
            'menu' => 'Lain-lain > THR > Edit Data THR',
            'keterangan' => 'Edit Data THR',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_thr');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_thr');
        }
    }

    public function delete_data_thr($id_thr)
    {
        $result = $this->M_data_thr->deleteDataThr($id_thr);
        if ($result) {
            $id_user = $this->session->userdata('id_user');
            $action_log = array(
                'menu' => 'Lain-lain > Delete Data THR',
                'keterangan' => 'Delete data THR',
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
        redirect('C_data_thr');
    }

    public function get_data_thr_by_id()
    {
        $id_thr = $this->input->post('id_thr');
        $query = $this->M_data_thr->getDataThrById($id_thr);
        $result = $query->result();
        echo json_encode($result);
    }
}
