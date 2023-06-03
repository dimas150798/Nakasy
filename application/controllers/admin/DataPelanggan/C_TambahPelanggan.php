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

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_TambahPelanggan', $data);
        $this->load->view('template/V_FooterPelanggan', $data);
    }

    public function TambahPelangganSave()
    {
        // Mengambil data post pada view
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
        $nama_sales               = $this->input->post('nama_sales');

        // Menyimpan data pelanggan ke dalam array
        $dataPelanggan = array(
            'id_customer'       => $id_customer,
            'kode_customer'     => $kode_customer,
            'phone_customer'    => $phone_customer,
            'nama_customer'     => $nama_customer,
            'nama_paket'        => $nama_paket,
            'name_pppoe'        => $name_pppoe,
            'password_pppoe'    => $password_pppoe,
            'alamat_customer'   => $alamat_customer,
            'email_customer'    => $email_customer,
            'start_date'        => $start_date,
            'nama_area'         => $nama_area,
            'deskripsi_customer' => $deskripsi_customer,
            'nama_sales'          => $nama_sales,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        // Memanggil mysql dari model
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

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
            $this->M_CRUD->insertData($dataPelanggan, 'data_customer');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>UPDATE DATA BERHASIL</strong>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>');
            redirect('admin/DataPelanggan/C_DataPelanggan');
        }
    }
}
