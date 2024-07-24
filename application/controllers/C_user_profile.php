<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_user_profile extends CI_Controller
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
        $this->load->model('users/M_user_profile', 'M_user_profile');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $id_user = $this->session->userdata('id_user');

        $data['data_profile'] = $this->M_user_profile->getAllDataProfileById($id_user);

        $data['id_user'] = $data['data_profile'][0]['id_user'];
        $data['username'] = $data['data_profile'][0]['username'];
        $data['firstname'] = $data['data_profile'][0]['firstname'];
        $data['lastname'] = $data['data_profile'][0]['lastname'];
        $data['foto'] = $data['data_profile'][0]['file_path'];
        $data['nama'] = $data['data_profile'][0]['firstname'] . ' ' . $data['data_profile'][0]['lastname'];
        $data['profesi'] = $data['data_profile'][0]['profesi'];
        $data['email'] = $data['data_profile'][0]['email'];
        $data['no_telp'] = $data['data_profile'][0]['no_telp'];

        $this->load->view('templates/tmp_header');
        $this->load->view('templates/tmp_navbar', $data);
        $this->load->view('templates/tmp_sidebar');
        $this->load->view('users/v_user_profile', $data);
        $this->load->view('templates/tmp_footer');
    }

    public function edit_profile()
    {
        $id_user = $this->input->post('id_user', true);
        $username = $this->input->post('edit_username', true);
        $firstname = $this->input->post('edit_firstname', true);
        $lastname = $this->input->post('edit_lastname', true);
        $email = $this->input->post('edit_email', true);
        $no_telp = $this->input->post('edit_no_telp', true);
        $profesi = $this->input->post('edit_profesi', true);

        $this->db->trans_begin();

        $data_user = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'no_telp' => $no_telp,
            'profesi' => $profesi
        );
        $this->db->where('id_user', $id_user);
        $this->db->update('users', $data_user);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0 mt-2" role="alert">
                                            <span>Data profile gagal di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_user_profile');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show mb-0 mt-2" role="alert">
                                            <span>Data profile berhasil di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_user_profile');
        }
    }

    public function user_password()
    {
        $data['title'] = 'Change Password';
        $id_user = $this->session->userdata('id_user');

        $data['data_profile'] = $this->M_user_profile->getAllDataProfileById($id_user);

        $data['id_user'] = $data['data_profile'][0]['id_user'];
        $data['username'] = $data['data_profile'][0]['username'];
        $data['firstname'] = $data['data_profile'][0]['firstname'];
        $data['lastname'] = $data['data_profile'][0]['lastname'];
        $data['foto'] = $data['data_profile'][0]['file_path'];
        $data['nama'] = $data['data_profile'][0]['firstname'] . ' ' . $data['data_profile'][0]['lastname'];
        $data['profesi'] = $data['data_profile'][0]['profesi'];
        $data['email'] = $data['data_profile'][0]['email'];
        $data['no_telp'] = $data['data_profile'][0]['no_telp'];

        $this->load->view('templates/tmp_header');
        $this->load->view('templates/tmp_navbar', $data);
        $this->load->view('templates/tmp_sidebar');
        $this->load->view('users/v_change_password', $data);
        $this->load->view('templates/tmp_footer');
    }

    public function edit_password()
    {
        $this->form_validation->set_rules('old_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Change Password';
            $id_user = $this->session->userdata('id_user');

            $data['data_profile'] = $this->M_user_profile->getAllDataProfileById($id_user);

            $data['id_user'] = $data['data_profile'][0]['id_user'];
            $data['username'] = $data['data_profile'][0]['username'];
            $data['firstname'] = $data['data_profile'][0]['firstname'];
            $data['lastname'] = $data['data_profile'][0]['lastname'];
            $data['foto'] = $data['data_profile'][0]['file_path'];
            $data['nama'] = $data['data_profile'][0]['firstname'] . ' ' . $data['data_profile'][0]['lastname'];
            $data['profesi'] = $data['data_profile'][0]['profesi'];
            $data['email'] = $data['data_profile'][0]['email'];
            $data['no_telp'] = $data['data_profile'][0]['no_telp'];

            $this->load->view('templates/tmp_header');
            $this->load->view('templates/tmp_navbar');
            $this->load->view('templates/tmp_sidebar');
            $this->load->view('users/v_change_password', $data);
            $this->load->view('templates/tmp_footer');
        } else {
            $id_user = $this->input->post('id_user');
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');

            $user = $this->M_user_profile->get_user_by_id($id_user);

            if ($user && $user->password == md5($old_password)) {
                if ($this->M_user_profile->update_password($id_user, $new_password)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show mb-0 mt-2" role="alert">
                                                                    <span>Password berhasil di update.</span>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                </div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-error alert-dismissible fade show mb-0 mt-2" role="alert">
                                                                    <span>Password gagal di update.</span>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                </div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show mb-0 mt-2" role="alert">
                                                                    <span>Password lama tidak cocok.</span>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                </div>');
            }

            redirect('C_user_profile/user_password');
        }
    }

    public function edit_foto()
    {
        $id_user = $this->session->userdata('id_user');
        $foto_lama = $this->input->post('foto_lama', true);

        // Upload gambar
        $config['upload_path'] = FCPATH . 'assets/uploads/profile/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 0;
        $config['file_name'] = 'edit_profile' . time();

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_baru')) {
            $upload_data = $this->upload->data();

            // Hapus foto lama jika berhasil upload foto baru
            if (!empty($foto_lama)) {
                unlink(FCPATH . 'assets/uploads/profile/' . basename($foto_lama));
            }

            $foto_baru = base_url() . 'assets/uploads/profile/' . $upload_data['file_name'];
        } else {
            $foto_baru = $foto_lama;
        }

        $this->db->trans_begin();

        $data = array(
            'file_path' => $foto_baru,
        );
        $this->db->where('id_user', $id_user);
        $this->db->update('users', $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show mb-0 mt-2" role="alert">
                                            <span>Foto gagal di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_user_profile');
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show mb-0 mt-2" role="alert">
                                            <span>Foto berhasil di update.</span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>');
            redirect('C_user_profile');
        }
    }
}
