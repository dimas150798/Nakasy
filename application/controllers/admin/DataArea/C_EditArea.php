<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditArea extends CI_Controller
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

    public function EditArea($id_area)
    {
        //memanggil mysql dari model 
        $data['DataArea']       = $this->M_Area->EditArea($id_area);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataArea/V_EditArea', $data);
        $this->load->view('template/V_FooterArea', $data);
    }

    public function EditAreaSave()
    {
        //mengambil data post pada view 
        $id_area           = $this->input->post('id_area');
        $nama_area         = $this->input->post('nama_area');

        //menyimpan data ke dalam array
        $dataArea = array(
            'id_area'          => $id_area,
            'nama_area'        => $nama_area,
            'updated_at'        => date('Y-m-d H:i:s', time())
        );

        $idArea = array(
            'id_area' => $id_area
        );

        //memanggil mysql dari model 
        $data['DataArea']       = $this->M_Area->EditArea($id_area);

        // Rules form Validation
        $this->form_validation->set_rules('nama_area', 'Nama', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataArea/V_EditArea', $data);
            $this->load->view('template/V_FooterArea', $data);
        } else {
            $this->M_CRUD->updateData('data_area', $dataArea, $idArea);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>EDIT DATA BERHASIL</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('admin/DataArea/C_DataArea');
        }
    }
}
