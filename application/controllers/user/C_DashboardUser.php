<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_DashboardUser extends CI_Controller
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
        date_default_timezone_set("Asia/Jakarta");
        $toDay = date('Y-m-d');

        // Memisahkan Tanggal
        $pecahDay       = explode("-", $toDay);

        $tahun          = $pecahDay[0];
        $bulan          = $pecahDay[1];
        $tanggal        = $pecahDay[2];

        // Menampilkan tanggal pada awal bulan
        $tanggal_awal     = date("01");
        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir    = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        // Menggabungkan bulan dan tahun
        $TanggalAwal      = $tahun . '-' . $bulan . '-' . $tanggal_awal;
        $TanggalAkhir     = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $data['JumlahPelanggan']            = $this->M_Pelanggan->JumlahPelangganAktif();
        $data['JumlahPelangganMonth']       = $this->M_Pelanggan->JumlahPelangganAktifMonth();
        $data['JumlahPelangganLunas']       = $this->M_SudahLunas->JumlahSudahLunas($bulan, $tahun, $TanggalAkhir);
        $data['JumlahPelangganJatuhTempo']  = $this->M_JatuhTempo->JumlahJatuhTempo($TanggalAwal, $TanggalAkhir, $tanggal);

        // Memanggil data Mikrotik
        // $this->MikrotikModel->index();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarUser', $data);
        $this->load->view('user/V_DashboardUser', $data);
        $this->load->view('template/footer', $data);
    }
}
