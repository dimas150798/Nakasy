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

    public function TerminasiAuto()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan                      = date("m", strtotime("-1 months"));
        $tahun                      = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir              = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir               = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        $data['dataTerminasi']      = $this->MikrotikModel->TerminasiAuto($bulan, $tahun, $TanggalAkhir);

        // $data['tanggal']            = $tanggal;
        $data['bulan']              = $bulan;
        $data['tahun']              = $tahun;

        $this->load->view('template/header', $data);
        $this->load->view('V_TerminasiAuto', $data);
        $this->load->view('template/V_FooterTerminasiAuto', $data);
    }

    public function GetTerminasiAuto()
    {
        date_default_timezone_set("Asia/Jakarta");
        $toDay = date('Y-m-d', strtotime("-1 months"));

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

        $result        = $this->MikrotikModel->TerminasiAuto($bulan, $tahun, $TanggalAkhir);

        $no = 0;

        foreach ($result as $dataCustomer) {
            $GrossAmount = $dataCustomer['gross_amount'] == NULL;

            $row = array();
            $row[] = ++$no;
            $row[] = $dataCustomer['name_pppoe'];
            $row[] = '<div class="text-center">' . ($GrossAmount ? 'Penagihan Tanggal ' . $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['namaPaket'] . '</div>';
            $row[] = '<div class="text-center">' . 'Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.') . '</div>';
            $row[] = '<div class="text-center">' . ($GrossAmount ? '<span class="badge bg-danger">BELUM LUNAS</span>' : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';

            $data[] = $row;
        }

        $ouput = array(
            'data' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
    }

    public function insertCustomer()
    {
        $this->MikrotikModel->index();
    }


    public function logout()
    {
        session_start();
        session_destroy();

        redirect('C_FormLogin');
    }
}
