<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DataSales extends CI_Controller
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

        // Memanggil mysql dari model
        $data['DataSales'] = $this->M_Sales->DataSales();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataSales/V_DataSales', $data);
        $this->load->view('template/V_FooterSales', $data);
    }
}
