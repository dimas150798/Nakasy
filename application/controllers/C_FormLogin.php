<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_FormLogin extends CI_Controller
{

    public function index()
    {
        $this->form_validation->set_rules('email_login', 'email_login', 'required');
        $this->form_validation->set_rules('password_login', 'password_login', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu');

        if ($this->form_validation->run() == false) {
            // apabila error kembali ke form login
            $this->load->view('template/headerLogin');
            $this->load->view('V_FormLogin');
            $this->load->view('template/footerLogin');
        } else {
            // mengambil data dari view post
            $email_login        = $this->input->post('email_login');
            $password_login     = $this->input->post('password_login');

            // pengecheckan data login 
            $checkDataLogin     = $this->M_Login->CheckLogin($email_login, $password_login);

            if ($checkDataLogin == NULL) {
                // Notifikasi gagal login
                $this->session->set_flashdata('LoginGagal_icon', 'error');
                $this->session->set_flashdata('LoginGagal_title', 'Email atau Password Salah');

                $this->load->view('template/headerLogin');
                $this->load->view('V_FormLogin');
                $this->load->view('template/footerLogin');
            } elseif ($email_login == $checkDataLogin->email_login && $checkDataLogin->id_akses == 1) {

                // Notifikasi gagal login
                $this->session->set_flashdata('CheckMikrotik_icon', 'error');
                $this->session->set_flashdata('CheckMikrotik_title', 'Email atau Password Salah');

                // Setting session login email
                $this->session->set_userdata('email', $checkDataLogin->email_login);

                redirect('superadmin/C_DashboardSuperadmin');
            } elseif ($email_login == $checkDataLogin->email_login && $checkDataLogin->id_akses == 2) {

                // Setting session login email
                $this->session->set_userdata('email', $checkDataLogin->email_login);

                redirect('admin/C_DashboardAdmin');
            } elseif ($email_login == $checkDataLogin->email_login && $checkDataLogin->id_akses == 3) {

                // check akun daerah penagih
                $checkDaerah = $this->M_AkunPenagihan->CheckLogin($email_login);

                if ($checkDaerah == null) {
                    // Notifikasi Daerah Tidak Ada
                    $this->session->set_flashdata('Daerah_icon', 'error');
                    $this->session->set_flashdata('Daerah_title', 'Daerah Penagih Kosong');
                    $this->session->set_flashdata('Daerah_text', 'Tambah Nama Daerah Penagih Dahulu');

                    $this->load->view('template/headerLogin');
                    $this->load->view('V_FormLogin');
                    $this->load->view('template/footerLogin');
                } else {
                    // Setting session login email
                    $this->session->set_userdata('email', $checkDataLogin->email_login);

                    redirect('user/C_DashboardUser');
                }
            } else {
                // Notifikasi gagal login
                $this->session->set_flashdata('LoginGagal_icon', 'error');
                $this->session->set_flashdata('LoginGagal_title', 'Email atau Password Salah');

                $this->load->view('template/headerLogin');
                $this->load->view('V_FormLogin');
                $this->load->view('template/footerLogin');
            }
        }
    }

    public function Refresh_Mikrotik()
    {
        $this->MikrotikPaitonModel->index();
        $this->MikrotikKraksaanModel->index();
    }

    public function Terminasi_Paiton_ASC()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan = date("m");
        $tahun = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $this->MikrotikPaitonModel->Terminasi_Paiton_ASC($bulan, $tahun, $TanggalAkhir);
    }

    public function Terminasi_Paiton_DESC()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan = date("m");
        $tahun = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $this->MikrotikPaitonModel->Terminasi_Paiton_DESC($bulan, $tahun, $TanggalAkhir);
    }

    public function Terminasi_Kraksaan_ASC()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan = date("m");
        $tahun = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $this->MikrotikKraksaanModel->Terminasi_Kraksaan_ASC($bulan, $tahun, $TanggalAkhir);
    }

    public function Terminasi_Kraksaan_DESC()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan = date("m");
        $tahun = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $this->MikrotikKraksaanModel->Terminasi_Kraksaan_DESC($bulan, $tahun, $TanggalAkhir);
    }


    public function Terminasi_KraksaanPaiton_DESC()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan = date("m");
        $tahun = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $this->MikrotikPaitonModel->Terminasi_KraksaanPaiton_DESC($bulan, $tahun, $TanggalAkhir);
    }

    public function enableAuto()
    {
        $this->MikrotikModel->EnableAuto();
    }


    public function logout()
    {
        session_start();
        session_destroy();

        redirect('C_FormLogin');
    }
}
