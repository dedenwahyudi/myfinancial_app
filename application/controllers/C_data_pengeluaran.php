<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_data_pengeluaran extends CI_Controller
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
        $this->load->model('pengeluaran/M_data_pengeluaran', 'M_data_pengeluaran');
        $this->load->helper('rupiah');
    }

    public function index()
    {
        $data['title'] = 'Data Pengeluaran';

        $id_user = $this->session->userdata('id_user');
        $data['foto'] = $this->M_data_pengeluaran->getFotoProfile($id_user)[0]['file_path'];

        $data['data_pengeluaran'] = $this->M_data_pengeluaran->getDataPengeluaranByIdUser($id_user);

        $total_pemasukan = $this->M_data_pengeluaran->getTotalPemasukan();
        $data['total_pemasukan'] = $total_pemasukan !== null ? $total_pemasukan : 0;
        $data['sisa_saldo'] = $this->M_data_pengeluaran->getSisaSaldo();
        $data['data_budget'] = $this->M_data_pengeluaran->getAllDataBudgetPengeluaran();

        $current_budget = $this->M_data_pengeluaran->getBudgetCurrentMonth($id_user);
        $data['current_budget'] = $current_budget;

        $data['view'] = 'super_admin/v_data_pengeluaran';


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

    public function history_data_pengeluaran()
    {
        $data['title'] = 'History Data Pengeluaran';

        $id_user = $this->session->userdata('id_user');
        $data['foto'] = $this->M_data_pengeluaran->getFotoProfile($id_user)[0]['file_path'];

        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if (!empty($start_date) && !empty($end_date)) {
            $data['data_pengeluaran'] = $this->M_data_pengeluaran->getDataPengeluaranByDate($start_date, $end_date, $id_user);
        } else {
            $data['data_pengeluaran'] = $this->M_data_pengeluaran->getDataPengeluaranByIdUser($id_user);
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['sisa_saldo'] = $this->M_data_pengeluaran->getSisaSaldo();

        $current_budget = $this->M_data_pengeluaran->getBudgetCurrentMonth($id_user);
        $data['current_budget'] = $current_budget;

        $data['view'] = 'super_admin/v_history_data_pengeluaran';

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

    public function budget_pengeluaran()
    {
        $data['title'] = 'Budget Pengeluaran';

        $id_user = $this->session->userdata('id_user');

        $data['foto'] = $this->M_data_pengeluaran->getFotoProfile($id_user)[0]['file_path'];

        $data['budget_pengeluaran_bulanan'] = $this->M_data_pengeluaran->getDataBudgetPengeluaranByIdUser($id_user);

        $total_pemasukan = $this->M_data_pengeluaran->getTotalPemasukan();
        $data['total_pemasukan'] = $total_pemasukan !== null ? $total_pemasukan : 0;

        $data['data_pengeluaran'] = $this->M_data_pengeluaran->getTotalPengeluaran();

        $last_code = $this->M_data_pengeluaran->getKodeBudget();

        if (!is_null($last_code)) {
            preg_match('/-(\d{3})-/', $last_code, $matches);
            $last_number = isset($matches[1]) ? intval($matches[1]) : 0;
            $next_number = $last_number + 1;
        } else {
            $next_number = 1;
        }

        $bulan_tahun = date('m');
        $tahun_dua_digit = substr(date('Y'), 2);

        $next_code = 'KB/C-' . $bulan_tahun . $tahun_dua_digit . '/USER-' . $id_user . '/' . sprintf('%03d', $next_number);

        $data['next_code'] = $next_code;

        $data['view'] = 'super_admin/v_budget_pengeluaran';

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


    public function input_budget_pengeluaran()
    {
        $id_user = $this->session->userdata('id_user');
        $bulan_budget = $this->input->post('bulan_budget', true);
        $tahun_budget = $this->input->post('tahun_budget', true);
        $keterangan_budget = $this->input->post('keterangan_budget', true);
        $jumlah = $this->input->post('jumlah_budget', true);
        $cleanedValue = clean_rupiah($jumlah);
        $jumlah_budget = (float) $cleanedValue;
        $kode_budget = $this->input->post('kode_budget', true);

        $this->db->trans_begin();

        $budget_pengeluaran = array(
            'kode_budget' => $kode_budget,
            'bulan' => $bulan_budget,
            'tahun' => $tahun_budget,
            'keterangan' => $keterangan_budget,
            'jumlah' => $jumlah_budget,
            'id_user' => $id_user,
            'status' => 0
        );
        $this->db->insert('budget', $budget_pengeluaran);

        $action_log = array(
            'menu' => 'Budget Pengeluaran > Input Data Budget',
            'keterangan' => 'Input data budget pengeluaran per-bulan',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di simpan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pengeluaran/budget_pengeluaran');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di simpan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pengeluaran/budget_pengeluaran');
        }
    }

    public function input_data_pengeluaran()
    {
        $id_user = $this->session->userdata('id_user');
        $tanggal = $this->input->post('tanggal_pengeluaran', true);
        $jenis = $this->input->post('jenis_pengeluaran', true);
        $jumlah_input = $this->input->post('jumlah_pengeluaran', true);
        $cleanedValue = clean_rupiah($jumlah_input);
        $jumlah = (float) $cleanedValue;
        $keterangan = $this->input->post('keterangan_pengeluaran', true);
        $sisa = $this->input->post('sisa_saldo', true);
        $cleanedValue = clean_rupiah($sisa);
        $sisa_saldo = (float) $cleanedValue;
        $tanpa_bukti = $this->input->post('tanpa_bukti', true);

        // Upload gambar
        $config['upload_path'] = FCPATH . 'assets/uploads/dokumen_pengeluaran/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 0;
        $config['file_name'] = 'bukti_pengeluaran_' . time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('bukti_pengeluaran')) {
            $upload_data = $this->upload->data();
            $bukti = base_url() . 'assets/uploads/dokumen_pengeluaran/' . $upload_data['file_name'];
        } else {
            $bukti = $tanpa_bukti;
        }

        $kode_budget = $this->input->post('kode_budget', true);

        $cek_kode_budget = $this->M_data_pengeluaran->cekKodeBudget($kode_budget);

        $this->db->trans_begin();

        if ($cek_kode_budget->num_rows()) {
            $data_pengeluaran = array(
                'kode_budget' => $kode_budget,
                'tanggal' => $tanggal,
                'jenis' => $jenis,
                'jumlah' => $jumlah,
                'keterangan' => $keterangan,
                'file_path' => $bukti,
                'sisa_saldo' => $sisa_saldo,
                'status' => 0,
                'id_user' => $id_user
            );
            $this->db->insert('pengeluaran', $data_pengeluaran);

            $action_log = array(
                'menu' => 'Data Pengeluaran > Input Data Pengeluaran',
                'keterangan' => 'Input data pengeluaran',
                'id_user' => $id_user
            );
            $this->db->insert('action_log', $action_log);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Kode Budget Tidak di Temukan.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pengeluaran');
        }

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
            redirect('C_data_pengeluaran');
        }
    }

    public function edit_data_pengeluaran()
    {
        $id_pengeluaran = $this->input->post('id_pengeluaran', true);
        $edit_tanggal = $this->input->post('edit_tanggal_history_pengeluaran', true);
        $edit_jenis = $this->input->post('edit_jenis_history_pengeluaran', true);

        $edit_jumlah_input1 = $this->input->post('edit_jumlah_history_pengeluaran1', true);
        $cleanedValue = clean_rupiah($edit_jumlah_input1);
        $edit_jumlah1 = (float) $cleanedValue;

        $edit_jumlah_input2 = $this->input->post('edit_jumlah_history_pengeluaran2', true);
        $cleanedValue = clean_rupiah($edit_jumlah_input2);
        $edit_jumlah2 = (float) $cleanedValue;

        if ($edit_jumlah1 == 0) {
            $edit_jumlah = $edit_jumlah2;
        } else if ($edit_jumlah1 != $edit_jumlah2) {
            $edit_jumlah = $edit_jumlah1;
        } else if ($edit_jumlah1 == $edit_jumlah2) {
            $edit_jumlah = $edit_jumlah1;
        }

        $edit_keterangan = $this->input->post('edit_keterangan_history_pengeluaran', true);
        $foto_lama = $this->input->post('foto_lama_history_pengeluaran', true);
        $id_user = $this->session->userdata('id_user');

        // Upload gambar
        $config['upload_path'] = FCPATH . 'assets/uploads/dokumen_pengeluaran/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['file_name'] = 'edit_bukti_pengeluaran' . time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('edit_bukti_history_pengeluaran')) {
            $upload_data = $this->upload->data();

            // Hapus foto lama jika berhasil upload foto baru
            if (!empty($foto_lama)) {
                unlink(FCPATH . 'assets/uploads/dokumen_pengeluaran/' . basename($foto_lama));
            }

            $bukti = base_url() . 'assets/uploads/dokumen_pengeluaran/' . $upload_data['file_name'];
        } else {
            $bukti = $foto_lama;
        }

        $this->db->trans_begin();

        $data = array(
            'tanggal' => $edit_tanggal,
            'jenis' => $edit_jenis,
            'jumlah' => $edit_jumlah,
            'keterangan' => $edit_keterangan,
            'file_path' => $bukti,
            'sisa_saldo' => 0,
            'status' => 0,
            'id_user' => $id_user
        );
        $this->db->where('id_pengeluaran', $id_pengeluaran);
        $this->db->update('pengeluaran', $data);

        $action_log = array(
            'menu' => 'History Data Pengeluaran > Edit Data Pengeluaran',
            'keterangan' => 'Edit data pengeluaran',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pengeluaran/history_data_pengeluaran');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pengeluaran/history_data_pengeluaran');
        }
    }

    public function edit_data_budget_pengeluaran()
    {
        $id_budget = $this->input->post('id_budget', true);
        $edit_bulan = $this->input->post('edit_bulan', true);
        $edit_tahun = $this->input->post('edit_tahun', true);
        $edit_keterangan = $this->input->post('edit_keterangan', true);

        $edit_jumlah_budget1 = $this->input->post('edit_jumlah_budget1', true);
        $cleanedValue = clean_rupiah($edit_jumlah_budget1);
        $edit_jumlah1 = (float) $cleanedValue;

        $edit_jumlah_budget2 = $this->input->post('edit_jumlah_budget2', true);
        $cleanedValue = clean_rupiah($edit_jumlah_budget2);
        $edit_jumlah2 = (float) $cleanedValue;

        if ($edit_jumlah1 == 0) {
            $edit_jumlah = $edit_jumlah2;
        } else if ($edit_jumlah1 != $edit_jumlah2) {
            $edit_jumlah = $edit_jumlah1;
        } else if ($edit_jumlah1 == $edit_jumlah2) {
            $edit_jumlah = $edit_jumlah1;
        }

        $id_user = $this->session->userdata('id_user');

        $this->db->trans_begin();

        $data_budget = array(
            'bulan' => $edit_bulan,
            'tahun' => $edit_tahun,
            'keterangan' => $edit_keterangan,
            'jumlah' => $edit_jumlah,
            'id_user' => $id_user,
            'status' => 0
        );
        $this->db->where('id_budget', $id_budget);
        $this->db->update('budget', $data_budget);

        $action_log = array(
            'menu' => 'Budget Pengeluaran > Edit Budget Pengeluaran',
            'keterangan' => 'Edit data budget pengeluaran bulanan',
            'id_user' => $id_user
        );
        $this->db->insert('action_log', $action_log);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <span>Data gagal di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pengeluaran/budget_pengeluaran');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <span>Data berhasil di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_data_pengeluaran/budget_pengeluaran');
        }
    }

    public function get_data_pengeluaran_by_id()
    {
        $id_pengeluaran = $this->input->post('id_pengeluaran');
        $query = $this->M_data_pengeluaran->getDataPengeluaranById($id_pengeluaran);
        $result = $query->result();
        echo json_encode($result);
    }

    public function get_data_budget_by_id()
    {
        $id_budget = $this->input->post('id_budget');
        $query = $this->M_data_pengeluaran->getDataBudgetById($id_budget);
        $result = $query->result();
        echo json_encode($result);
    }

    public function delete_data_pengeluaran($id_pengeluaran)
    {
        $result = $this->M_data_pengeluaran->deleteDataPengeluaran($id_pengeluaran);
        if ($result) {
            $id_user = $this->session->userdata('id_user');
            $action_log = array(
                'menu' => 'History Data Pengeluaran > Delete Data Pengeluaran',
                'keterangan' => 'Delete data pengeluaran',
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
        redirect('C_data_pengeluaran/history_data_pengeluaran');
    }

    public function delete_data_budget_pengeluaran($id_budget)
    {
        $result = $this->M_data_pengeluaran->deleteDataBudgetPengeluaran($id_budget);
        if ($result) {
            $id_user = $this->session->userdata('id_user');
            $action_log = array(
                'menu' => 'Budget Pengeluaran > Delete Data Budget Pengeluaran',
                'keterangan' => 'Delete data budget pengeluaran',
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
        redirect('C_data_pengeluaran/budget_pengeluaran');
    }

    public function download_pengeluaran()
    {
        // Memuat data dari model
        $data = $this->M_data_pengeluaran->getAllDataPengeluaran(); // Sesuaikan metode ini dengan model Anda

        // Membuat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        var_dump($spreadsheet);
        die;
        $sheet = $spreadsheet->getActiveSheet();

        // Mengatur baris header
        $sheet->setCellValue('A1', 'ID Pengeluaran');
        $sheet->setCellValue('B1', 'Kode Budget');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Jenis');
        $sheet->setCellValue('E1', 'Jumlah');
        $sheet->setCellValue('F1', 'Keterangan');
        $sheet->setCellValue('G1', 'File Path');
        $sheet->setCellValue('H1', 'Sisa Saldo');
        $sheet->setCellValue('I1', 'Status');
        $sheet->setCellValue('J1', 'User Input');
        $sheet->setCellValue('K1', 'Timestamp');

        // Mengisi data ke baris
        $row = 2;
        foreach ($data as $pengeluaran) {
            $sheet->setCellValue('A' . $row, $pengeluaran->id_pengeluaran);
            $sheet->setCellValue('B' . $row, $pengeluaran->kode_budget);
            $sheet->setCellValue('C' . $row, $pengeluaran->tanggal);
            $sheet->setCellValue('D' . $row, $pengeluaran->jenis);
            $sheet->setCellValue('E' . $row, $pengeluaran->jumlah);
            $sheet->setCellValue('F' . $row, $pengeluaran->keterangan);
            $sheet->setCellValue('G' . $row, $pengeluaran->file_path);
            $sheet->setCellValue('H' . $row, $pengeluaran->sisa_saldo);
            $sheet->setCellValue('I' . $row, $pengeluaran->status);
            $sheet->setCellValue('J' . $row, $pengeluaran->user_input);
            $sheet->setCellValue('K' . $row, $pengeluaran->timestamp);
            $row++;
        }

        // Menetapkan nama file
        $filename = 'Data_Pengeluaran_' . date('Ymd') . '.xlsx';

        // Mengarahkan output ke browser klien (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
