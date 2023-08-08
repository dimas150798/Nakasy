<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_SudahLunas extends CI_Controller
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
        // clear session login
        $this->session->unset_userdata('LoginBerhasil_icon');

        // Mengambil data area
        $checkLogin                 = $this->M_AkunPenagihan->CheckLogin($this->session->userdata('email'));

        $area_1                     = $checkLogin->area_1;
        $area_2                     = $checkLogin->area_2;
        $area_3                     = $checkLogin->area_3;
        $area_4                     = $checkLogin->area_4;
        $area_5                     = $checkLogin->area_5;

        // nama penagih
        $nama_penagih               = $checkLogin->nama_penagih;

        if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
            $bulanGET                   = $_GET['bulan'];
            $tahunGET                   = $_GET['tahun'];

            // Menampilkan tanggal pada akhir bulan GET
            $tanggal_akhir_GET          = cal_days_in_month(CAL_GREGORIAN, $bulanGET, $tahunGET);

            // Menggabungkan tanggal, bulan, tahun
            $TanggalAkhirGET            = $tahunGET . '-' . $bulanGET . '-' . $tanggal_akhir_GET;

            // Menyimpan Dalam Session
            $this->session->set_userdata('bulanGET', $bulanGET);
            $this->session->set_userdata('tahunGET', $tahunGET);
            $this->session->set_userdata('TanggalAkhirGET', $TanggalAkhirGET);

            // Memanggil mysql dari model
            $data['SudahLunas']         = $this->M_SudahLunasUser->SudahLunas($bulanGET, $tahunGET, $TanggalAkhirGET, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
            $data['JumlahSudahLunas']   = $this->M_SudahLunasUser->JumlahSudahLunas($bulanGET, $tahunGET, $TanggalAkhirGET, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
            $NominalSudahLunas          = $this->M_SudahLunasUser->NominalSudahLunas($bulanGET, $tahunGET, $TanggalAkhirGET, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
            $NominalBiayaAdmin          = $this->M_SudahLunasUser->NominalBiayaAdmin($bulanGET, $tahunGET, $TanggalAkhirGET, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);

            // Menyimpan query di dalam data
            $data['bulanGET']           = $bulanGET;
            $data['tahunGET']           = $tahunGET;
            $data['NominalSudahLunas']  = $NominalSudahLunas->hargaPaket;
            $data['NominalBiayaAdmin']  = $NominalBiayaAdmin->biayaAdmin;
            $data['TotalAkhir']         = $NominalSudahLunas->hargaPaket - $NominalBiayaAdmin->biayaAdmin;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarUser', $data);
            $this->load->view('user/SudahLunas/V_SudahLunas', $data);
            $this->load->view('template/V_FooterSudahLunasUser', $data);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $bulan                      = date("m");
            $tahun                      = date("Y");

            // Menampilkan tanggal pada akhir bulan
            $tanggal_akhir              = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

            // Menggabungkan tanggal, bulan, tahun
            $TanggalAkhir               = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

            // Menyimpan Dalam Session
            $this->session->set_userdata('bulan', $bulan);
            $this->session->set_userdata('tahun', $tahun);
            $this->session->set_userdata('TanggalAkhir', $TanggalAkhir);

            // Memanggil mysql dari model
            $data['SudahLunas']         = $this->M_SudahLunasUser->SudahLunas($bulan, $tahun, $TanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
            $data['JumlahSudahLunas']   = $this->M_SudahLunasUser->JumlahSudahLunas($bulan, $tahun, $TanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
            $NominalSudahLunas          = $this->M_SudahLunasUser->NominalSudahLunas($bulan, $tahun, $TanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);
            $NominalBiayaAdmin          = $this->M_SudahLunasUser->NominalBiayaAdmin($bulan, $tahun, $TanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);

            // Menyimpan query di dalam data
            $data['bulan']              = $bulan;
            $data['tahun']              = $tahun;
            $data['NominalSudahLunas']  = $NominalSudahLunas->hargaPaket;
            $data['NominalBiayaAdmin']  = $NominalBiayaAdmin->biayaAdmin;
            $data['TotalAkhir']         = $NominalSudahLunas->hargaPaket - $NominalBiayaAdmin->biayaAdmin;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarUser', $data);
            $this->load->view('user/SudahLunas/V_SudahLunas', $data);
            $this->load->view('template/V_FooterSudahLunasUser', $data);
        }
    }

    public function GetSudahLunas()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan                      = date("m");
        $tahun                      = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir              = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir               = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        // Mengambil data area
        $checkLogin                 = $this->M_AkunPenagihan->CheckLogin($this->session->userdata('email'));

        $area_1                     = $checkLogin->area_1;
        $area_2                     = $checkLogin->area_2;
        $area_3                     = $checkLogin->area_3;
        $area_4                     = $checkLogin->area_4;
        $area_5                     = $checkLogin->area_5;

        // nama penagih
        $nama_penagih               = $checkLogin->nama_penagih;

        if ($this->session->userdata('tahunGET') == NULL && $this->session->userdata('bulanGET') == NULL) {
            $result        = $this->M_SudahLunasUser->SudahLunas($bulan, $tahun, $TanggalAkhir, $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);

            $no = 0;

            foreach ($result as $dataCustomer) {
                $GrossAmount = $dataCustomer['gross_amount'] == NULL;

                $row = array();
                $row[] = ++$no;
                $row[] = $dataCustomer['nama_customer'];
                $row[] = $dataCustomer['name_pppoe'];
                $row[] = '<div class="text-center">' . ($GrossAmount ? 'Penagihan Tanggal ' . $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';
                $row[] = '<div class="text-center">' . $dataCustomer['namaPaket'] . '</div>';
                $row[] = '<div class="text-center">' . 'Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.') . '</div>';
                $row[] = '<div class="text-center">' . ($GrossAmount ? changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time']) : '<span class="badge bg-success">' . strtoupper($dataCustomer['nama_admin']) . '</span>') . '</div>';
                // $row[] =
                //     '<div class="text-center">
                //         <div class="btn-group">
                //             <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                //                 Opsi
                //             </button>
                //             <div class="dropdown-menu text-black" style="background-color:aqua;">
                //                 <a onclick="KwitansiLunas(' . $dataCustomer['id_customer'] . ')"class="dropdown-item text-black"></i> Kwitansi</a>
                //                 <a onclick="KirimWA_Lunas(' . $dataCustomer['id_customer'] . ')"class="dropdown-item text-black"></i> Kirim WA Lunas</a>
                //             </div>
                //         </div>
                //     </div>';

                $data[] = $row;
            }

            $ouput = array(
                'data' => $data
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
        } else {
            $result        = $this->M_SudahLunasUser->SudahLunas($this->session->userdata('bulanGET'), $this->session->userdata('tahunGET'), $this->session->userdata('TanggalAkhirGET'), $area_1, $area_2, $area_3, $area_4, $area_5, $nama_penagih);

            $no = 0;

            foreach ($result as $dataCustomer) {
                $GrossAmount = $dataCustomer['gross_amount'] == NULL;

                $row = array();
                $row[] = ++$no;
                $row[] = $dataCustomer['nama_customer'];
                $row[] = $dataCustomer['name_pppoe'];
                $row[] = '<div class="text-center">' . ($GrossAmount ? 'Penagihan Tanggal ' . $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';
                $row[] = '<div class="text-center">' . $dataCustomer['namaPaket'] . '</div>';
                $row[] = '<div class="text-center">' .  'Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.') . '</div>';
                $row[] = '<div class="text-center">' . ($GrossAmount ? changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time']) : '<span class="badge bg-success">' . strtoupper($dataCustomer['nama_admin']) . '</span>') . '</div>';
                // $row[] =
                //     '<div class="text-center">
                //         <div class="btn-group">
                //             <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                //                 Opsi
                //             </button>
                //             <div class="dropdown-menu text-black" style="background-color:aqua;">
                //                 <a onclick="KwitansiLunas(' . $dataCustomer['id_customer'] . ')"class="dropdown-item text-black"></i> Kwitansi</a>
                //                 <a onclick="KirimWA_Lunas(' . $dataCustomer['id_customer'] . ')"class="dropdown-item text-black"></i> Kirim WA Lunas</a>
                //             </div>
                //         </div>
                //     </div>';

                $data[] = $row;
            }

            $ouput = array(
                'data' => $data
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
        }
    }
}
