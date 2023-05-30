<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahSales extends CI_Controller
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
        //memanggil mysql dari model 
        $data['DataJabatan']      = $this->M_Jabatan->DataJabatan();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataSales/V_TambahSales', $data);
        $this->load->view('template/V_FooterSales', $data);
    }

    public function TambahSalesSave()
    {
        //mengambil data post pada view 
        $nama_sales      = $this->input->post('nama_sales');
        $phone_sales     = $this->input->post('phone_sales');
        $id_jabatan      = $this->input->post('id_jabatan');


        //menyimpan data Sales ke dalam array
        $dataSales = array(
            'nama_sales'       => $nama_sales,
            'phone_sales'      => $phone_sales,
            'id_jabatan'       => $id_jabatan,
            'created_at'       => date('Y-m-d H:i:s', time())
        );

        //memanggil mysql dari model 
        $data['DataJabatan']      = $this->M_Jabatan->DataJabatan();

        // Rules form Validation
        $this->form_validation->set_rules('nama_sales', 'Nama Sales', 'required');
        $this->form_validation->set_rules('phone_sales', 'Phone Sales', 'required');
        $this->form_validation->set_rules('id_jabatan', 'Id Jabatan', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataSales/V_TambahSales', $data);
            $this->load->view('template/V_FooterSales', $data);
        } else {
            $this->M_CRUD->insertData($dataSales, 'data_sales');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>TAMBAH DATA BERHASIL</strong>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>');
            redirect('admin/DataSales/C_DataSales');
        }
    }
}
