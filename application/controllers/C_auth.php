<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth/M_auth', 'M_auth');
    }

    public function index()
    {
        $this->load->view('auth/v_login');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->M_auth->get_user($username, $password);

        if ($user) {
            $this->session->set_userdata('id_user', $user['id_user']);
            $this->session->set_userdata('username', $user['username']);
            $this->session->set_userdata('firstname', $user['firstname']);
            $this->session->set_userdata('lastname', $user['lastname']);
            $this->session->set_userdata('email', $user['email']);
            $this->session->set_userdata('img_url', $user['file_path']);
            $this->session->set_userdata('user_level', $user['user_level']);

            if ($user['user_level'] == '1' || $user['user_level'] == '2') {
                redirect('C_dashboard');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                     <span style="font-size: 14px;">Username atau Password salah...!</span>
                                                    </div>');
            redirect('C_auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        <span style="font-size: 14px;">Anda telah keluar...!</span>
                                                    </div>');
        redirect('C_auth');
    }
}
