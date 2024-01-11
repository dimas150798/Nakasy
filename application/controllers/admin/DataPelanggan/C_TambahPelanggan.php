<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahPelanggan extends CI_Controller
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
        // Memanggil mysql dari model
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();
        $data['DaerahMikrotik'] = $this->M_DaerahMikrotik->DaerahMikrotik();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_TambahPelanggan', $data);
        $this->load->view('template/V_FooterPelanggan', $data);
    }

    public function TambahPelangganSave()
    {
        // Mengambil data post pada view
        $order_id               = $this->input->post('order_id');
        $id_customer            = $this->input->post('id_customer');
        $kode_customer          = $this->input->post('kode_customer');
        $phone_customer         = $this->input->post('phone_customer');
        $nama_customer          = $this->input->post('nama_customer');
        $nama_paket             = $this->input->post('nama_paket');
        $name_pppoe             = $this->input->post('name_pppoe');
        $password_pppoe         = $this->input->post('password_pppoe');
        $alamat_customer        = $this->input->post('alamat_customer');
        $email_customer         = $this->input->post('email_customer');
        $start_date             = $this->input->post('start_date');
        $nama_area              = $this->input->post('nama_area');
        $deskripsi_customer     = $this->input->post('deskripsi_customer');
        $nama_sales             = $this->input->post('nama_sales');
        $nama_DaerahMikrotik    = $this->input->post('nama_DaerahMikrotik');

        $GetDataPaket           = $this->M_Paket->CheckDuplicatePaket($nama_paket);
        $price_paket            = $GetDataPaket->harga_paket;

        $DeleteSpasi_Name_PPPOE     = rtrim($name_pppoe);
        $DeleteSpasi_Password_PPPOE = rtrim($password_pppoe);

        // Menyimpan data pelanggan ke dalam array
        $dataPelanggan = array(
            'id_customer'       => $id_customer,
            'kode_customer'     => $kode_customer,
            'phone_customer'    => $phone_customer,
            'nama_customer'     => $nama_customer,
            'nama_paket'        => $nama_paket,
            'name_pppoe'        => $DeleteSpasi_Name_PPPOE,
            'password_pppoe'    => $DeleteSpasi_Password_PPPOE,
            'alamat_customer'   => $alamat_customer,
            'email_customer'    => $email_customer,
            'start_date'        => $start_date,
            'nama_area'         => $nama_area,
            'deskripsi_customer' => $deskripsi_customer,
            'nama_sales'        => $nama_sales,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        $dataPembayaran = array(
            'order_id'              => $order_id,
            'gross_amount'          => $price_paket,
            'biaya_admin'           => '0',
            'name_pppoe'            => $DeleteSpasi_Name_PPPOE,
            'nama_paket'            => $nama_paket,
            'nama_admin'            => 'Registrasi Baru',
            'keterangan'            => 'Registrasi Baru',
            'transaction_time'      => date('Y-m-d H:i:s', time()),
            'status_code'           => '200'
        );

        $dataPembayaranDuplicate = array(
            'order_id'              => $this->M_BelumLunas->invoice(),
            'gross_amount'          => $price_paket,
            'biaya_admin'           => '0',
            'name_pppoe'            => $DeleteSpasi_Name_PPPOE,
            'nama_paket'            => $nama_paket,
            'nama_admin'            => 'Registrasi Baru',
            'keterangan'            => 'Registrasi Baru',
            'transaction_time'      => date('Y-m-d H:i:s', time()),
            'status_code'           => '200'
        );

        // Memanggil mysql dari model
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();
        $data['DaerahMikrotik'] = $this->M_DaerahMikrotik->DaerahMikrotik();

        $checkDuplicate         = $this->M_Pelanggan->CheckDuplicatePelanggan($name_pppoe);

        // Check duplicate code
        $checkDuplicateCode = $this->M_Pelanggan->CheckDuplicateCode($order_id);

        // Rules form validation
        $this->form_validation->set_rules('nama_customer', 'Nama Customer', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('kode_customer', 'Kode Customer', 'required');
        $this->form_validation->set_rules('name_pppoe', 'Name PPPOE', 'required');
        $this->form_validation->set_rules('password_pppoe', 'Password PPPOE', 'required');
        $this->form_validation->set_rules('phone_customer', 'Phone Customer', 'required');
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('nama_area', 'Nama Area', 'required');
        $this->form_validation->set_rules('nama_sales', 'Nama Sales', 'required');
        $this->form_validation->set_rules('email_customer', 'Email Customer', 'required');
        $this->form_validation->set_rules('alamat_customer', 'Alamat Customer', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataPelanggan/V_TambahPelanggan', $data);
            $this->load->view('template/V_FooterPelanggan', $data);
        } else {
            if ($name_pppoe == $checkDuplicate->name_pppoe) {
                // Notifikasi Duplicate Name 
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Pelanggan');
                $this->session->set_flashdata('DuplicateName_text', 'Name PPPOE Sudah Ada');

                redirect('admin/DataPelanggan/C_TambahPelanggan');
            } else {
                if ($order_id != $checkDuplicateCode->order_id) {
                    if ($nama_DaerahMikrotik == 'Kraksaan') {
                        // Tambah Pelanggan Ke Mikrotik
                        $api = connectKraksaaan();
                        $api->comm('/ppp/secret/add', [
                            "name" => $name_pppoe,
                            "password" => $password_pppoe,
                            "service" => "any",
                            "profile" => $nama_paket,
                            "comment" => $deskripsi_customer,
                        ]);
                        $api->disconnect();
                    }

                    if ($nama_DaerahMikrotik == 'Paiton') {
                        // Tambah Pelanggan Ke Mikrotik
                        $api = connectPaiton();
                        $api->comm('/ppp/secret/add', [
                            "name" => $name_pppoe,
                            "password" => $password_pppoe,
                            "service" => "any",
                            "profile" => $nama_paket,
                            "comment" => $deskripsi_customer,
                        ]);
                        $api->disconnect();
                    }

                    $this->M_CRUD->insertData($dataPelanggan, 'data_customer');
                    $this->M_CRUD->insertData($dataPembayaran, 'data_pembayaran');
                    $this->M_CRUD->insertData($dataPembayaran, 'data_pembayaran_history');

                    // Notifikasi Tambah Data Berhasil
                    $this->session->set_flashdata('Tambah_icon', 'success');
                    $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                    $this->MikrotikKraksaanModel->index();
                    $this->MikrotikPaitonModel->index();

                    redirect('admin/DataPelanggan/C_DataPelanggan');
                } else {
                    if ($nama_DaerahMikrotik == 'Kraksaan') {
                        // Tambah Pelanggan Ke Mikrotik
                        $api = connectKraksaaan();
                        $api->comm('/ppp/secret/add', [
                            "name" => $name_pppoe,
                            "password" => $password_pppoe,
                            "service" => "any",
                            "profile" => $nama_paket,
                            "comment" => $deskripsi_customer,
                        ]);
                        $api->disconnect();
                    }

                    if ($nama_DaerahMikrotik == 'Paiton') {
                        // Tambah Pelanggan Ke Mikrotik
                        $api = connectPaiton();
                        $api->comm('/ppp/secret/add', [
                            "name" => $name_pppoe,
                            "password" => $password_pppoe,
                            "service" => "any",
                            "profile" => $nama_paket,
                            "comment" => $deskripsi_customer,
                        ]);
                        $api->disconnect();
                    }

                    $this->M_CRUD->insertData($dataPelanggan, 'data_customer');
                    $this->M_CRUD->insertData($dataPembayaranDuplicate, 'data_pembayaran');
                    $this->M_CRUD->insertData($dataPembayaranDuplicate, 'data_pembayaran_history');

                    // Notifikasi Tambah Data Berhasil
                    $this->session->set_flashdata('Tambah_icon', 'success');
                    $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                    $this->MikrotikKraksaanModel->index();
                    $this->MikrotikPaitonModel->index();

                    redirect('admin/DataPelanggan/C_DataPelanggan');
                }
            }
        }
    }
}
