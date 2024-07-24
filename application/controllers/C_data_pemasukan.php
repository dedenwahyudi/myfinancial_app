<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_data_pemasukan extends CI_Controller
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
        $this->load->model('pemasukan/M_data_pemasukan', 'M_data_pemasukan');
        $this->load->helper('rupiah');
    }

    public function index()
    {
        $data['title'] = 'Data Pemasukan';
        $id_user = $this->session->userdata('id_user');
        $data['foto'] = $this->M_data_pemasukan->getFotoProfile($id_user)[0]['file_path'];
        $data['data_pemasukan'] = $this->M_data_pemasukan->getDataPemasukanByIdUser($id_user);
        $data['view'] = 'super_admin/v_data_pemasukan';

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

    public function history_data_pemasukan()
    {
        $data['title'] = 'History Data Pemasukan';
        $id_user = $this->session->userdata('id_user');
        $data['foto'] = $this->M_data_pemasukan->getFotoProfile($id_user)[0]['file_path'];
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        if (!empty($start_date) && !empty($end_date)) {
            $data['history_data_pemasukan'] = $this->M_data_pemasukan->getDataPemasukanByDate($start_date, $end_date, $id_user);
        } else {
            $data['history_data_pemasukan'] = $this->M_data_pemasukan->getDataPemasukanByIdUser($id_user);
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['view'] = 'super_admin/v_history_data_pemasukan';

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

    public function input_data_pemasukan()
    {
        $id_user = $this->session->userdata('id_user');
        $tanggal = $this->input->post('tanggal', true);
        $sumber_dana = $this->input->post('sumber_dana', true);
        $tujuan = $this->input->post('tujuan', true);
        $keterangan = $this->input->post('keterangan', true);
        $jumlah_input = $this->input->post('jumlah', true);
        $cleanedValue = clean_rupiah($jumlah_input);
        $jumlah = (float) $cleanedValue;
        $tanpa_bukti = $this->input->post('tanpa_bukti', true);

        // Upload gambar
        $config['upload_path'] = FCPATH . 'assets/uploads/dokumen_pemasukan/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 0;
        $config['file_name'] = 'bukti_pemasukan_' . time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti')) {
            $upload_data = $this->upload->data();
            $bukti = base_url() . 'assets/uploads/dokumen_pemasukan/' . $upload_data['file_name'];
        } else {
            $bukti = $tanpa_bukti;
        }

        $this->db->trans_begin();

        $data_pemasukan = array(
            'tanggal' => $tanggal,
            'sumber_dana' => $sumber_dana,
            'tujuan' => $tujuan,
            'keterangan' => $keterangan,
            'jumlah' => $jumlah,
            'file_path' => $bukti,
            'status' => 0,
            'id_user' => $id_user
        );
        $this->db->insert('pemasukan', $data_pemasukan);

        $action_log = array(
            'menu' => 'Data Pemasukan > Input Data Pemasukan',
            'keterangan' => 'Input data pemasukan',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di simpan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pemasukan');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di simpan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pemasukan');
        }
    }

    public function edit_data_pemasukan()
    {
        $id_user = $this->session->userdata('id_user');
        $id_pemasukan = $this->input->post('id_pemasukan', true);
        $edit_tanggal = $this->input->post('edit_tanggal', true);
        $edit_sumber_dana = $this->input->post('edit_sumber_dana', true);
        $edit_tujuan = $this->input->post('edit_tujuan', true);
        $edit_keterangan = $this->input->post('edit_keterangan', true);

        $edit_jumlah_input1 = $this->input->post('edit_jumlah1', true);
        $cleanedValue = clean_rupiah($edit_jumlah_input1);
        $edit_jumlah1 = (float) $cleanedValue;

        $edit_jumlah_input2 = $this->input->post('edit_jumlah2', true);
        $cleanedValue = clean_rupiah($edit_jumlah_input2);
        $edit_jumlah2 = (float) $cleanedValue;

        if ($edit_jumlah1 == 0) {
            $edit_jumlah = $edit_jumlah2;
        } else if ($edit_jumlah1 != $edit_jumlah2) {
            $edit_jumlah = $edit_jumlah1;
        } else if ($edit_jumlah1 == $edit_jumlah2) {
            $edit_jumlah = $edit_jumlah1;
        }

        $foto_lama = $this->input->post('foto_lama', true);

        // Upload gambar
        $config['upload_path'] = FCPATH . 'assets/uploads/dokumen_pemasukan/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 0;
        $config['file_name'] = 'edit_bukti_' . time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('edit_bukti')) {
            $upload_data = $this->upload->data();

            // Hapus foto lama jika berhasil upload foto baru
            if (!empty($foto_lama)) {
                unlink(FCPATH . 'assets/uploads/dokumen_pemasukan/' . basename($foto_lama));
            }

            $bukti = base_url() . 'assets/uploads/dokumen_pemasukan/' . $upload_data['file_name'];
        } else {
            $bukti = $foto_lama;
        }

        $this->db->trans_begin();

        $data = array(
            'tanggal' => $edit_tanggal,
            'sumber_dana' => $edit_sumber_dana,
            'tujuan' => $edit_tujuan,
            'keterangan' => $edit_keterangan,
            'jumlah' => $edit_jumlah,
            'file_path' => $bukti,
            'status' => 0,
            'id_user' => $id_user
        );
        $this->db->where('id_pemasukan', $id_pemasukan);
        $this->db->update('pemasukan', $data);

        $action_log = array(
            'menu' => 'History Data Pemasukan > Edit Data Pemasukan',
            'keterangan' => 'Edit data pemasukan',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pemasukan/history_data_pemasukan');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pemasukan/history_data_pemasukan');
        }
    }

    public function get_data_pemasukan_by_id()
    {
        $id_pemasukan = $this->input->post('id_pemasukan');
        $query = $this->M_data_pemasukan->getDataPemasukanById($id_pemasukan);
        $result = $query->result();
        echo json_encode($result);
    }

    public function delete_data_pemasukan($id_pemasukan)
    {
        $result = $this->M_data_pemasukan->deleteDataPemasukan($id_pemasukan);
        if ($result) {
            $id_user = $this->session->userdata('id_user');
            $action_log = array(
                'menu' => 'History Data Pemasukan > Delete Data Pemasukan',
                'keterangan' => 'Delete data pemasukan',
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
        redirect('C_data_pemasukan/history_data_pemasukan');
    }
}
