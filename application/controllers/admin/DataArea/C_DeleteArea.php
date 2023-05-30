<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DeleteArea extends CI_Controller
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

    public function DeleteArea($id_area)
    {
        // Kondisi delete menggunakan id_customer
        $idArea = array(
            'id_area'       => $id_area
        );

        $this->M_CRUD->deleteData($idArea, 'data_area');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>DELETE DATA BERHASIL</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect('admin/DataArea/C_DataArea');
    }
}
