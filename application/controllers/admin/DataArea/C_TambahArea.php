<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahArea extends CI_Controller
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
        $data['DataArea']      = $this->M_Area->DataArea();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataArea/V_TambahArea', $data);
        $this->load->view('template/V_FooterArea', $data);
    }

    public function TambahAreaSave()
    {
        //mengambil data post pada view 
        $nama_area      = $this->input->post('nama_area');

        //menyimpan data ke dalam array
        $dataArea = array(
            'nama_area'         => $nama_area,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        //memanggil mysql dari model 
        $data['DataArea']      = $this->M_Area->DataArea();

        // Rules form Validation
        $this->form_validation->set_rules('nama_area', 'Nama Area', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataArea/V_TambahArea', $data);
            $this->load->view('template/V_FooterArea', $data);
        } else {
            $this->M_CRUD->insertData($dataArea, 'data_area');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>TAMBAH DATA BERHASIL</strong>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>');
            redirect('admin/DataArea/C_DataArea');
        }
    }
}
