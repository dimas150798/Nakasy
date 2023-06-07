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
        $checkKoneksi = $this->MikrotikModel->jumlahMikrotikAktif();

        if ($checkKoneksi == 0) {
            // Notifikasi gagal login
            $this->session->set_flashdata('CheckMikrotik_icon', 'error');
            $this->session->set_flashdata('CheckMikrotik_title', 'Koneksi Gagal');
            $this->session->set_flashdata('CheckMikrotik_text', 'Check Kembali Lagi Koneksi <br> Mikrotik Anda');

            $this->load->view('template/headerLogin');
            $this->load->view('V_FormLogin');
            $this->load->view('template/footerLogin');

            // redirect('admin/DataPaket/C_DataPaket');
        } elseif ($checkKoneksi == 1) {
            // Memanggil data Mikrotik
            $this->MikrotikModel->index();

            // Notifikasi Login Berhasil
            $this->session->set_flashdata('LoginBerhasil_icon', 'success');
            $this->session->set_flashdata('LoginBerhasil_title', 'Selamat Datang <br>' . $this->session->userdata('email'));

            $this->load->view('template/header');
            $this->load->view('template/sidebarAdmin');
            $this->load->view('admin/V_DashboardAdmin');
            $this->load->view('template/footer');
        }
    }
}
