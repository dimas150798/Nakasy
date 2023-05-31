<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_DashboardAdmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('email') == null) {

            // Notifikasi Login Terlebih Dahulu
            $this->session->set_flashdata('BelumLogin_icon', 'error');
            $this->session->set_flashdata('BelumLogin_title', 'Login Terlebih Dahulu');

            redirect('C_FormLogin');
        }
    }

    public function index()
    {
        // Memanggil data Mikrotik
        // $this->MikrotikModel->index();

        // Notifikasi Login Berhasil
        $this->session->set_flashdata('LoginBerhasil_icon', 'success');
        $this->session->set_flashdata('LoginBerhasil_title', 'Selamat Datang <br>' . $this->session->userdata('email'));

        $this->load->view('template/header');
        $this->load->view('template/sidebarAdmin');
        $this->load->view('admin/V_DashboardAdmin');
        $this->load->view('template/footer');
    }
}
