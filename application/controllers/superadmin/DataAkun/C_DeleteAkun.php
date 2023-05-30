<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DeleteAkun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('email') == null) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>Login Terlebih Dahulu</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('C_FormLogin');
        }
    }

    public function DeleteAkun($id_login)
    {
        // Kondisi delete menggunakan id_customer
        $idLogin = array(
            'id_login'       => $id_login
        );

        $this->M_CRUD->deleteData($idLogin, 'data_login');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>DELETE DATA BERHASIL</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect('superadmin/DataAkun/C_DataAkun');
    }
}
