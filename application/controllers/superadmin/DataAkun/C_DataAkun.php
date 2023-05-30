<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DataAkun extends CI_Controller
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

    public function index()
    {
        $data['DataLogin'] = $this->M_DataAkun->DataAkun();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/DataAkun/V_DataAkun', $data);
        $this->load->view('template/footer', $data);
    }
}
