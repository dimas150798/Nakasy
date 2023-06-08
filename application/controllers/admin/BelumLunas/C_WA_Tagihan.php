<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_WA_Tagihan extends CI_Controller
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

    public function KirimWA($id_customer)
    {
        //memanggil mysql dari model 
        $data['DataPelanggan']  = $this->M_BelumLunas->Payment($id_customer);

        $this->session->userdata('tahunGET');
        $this->session->userdata('bulanGET');

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/BelumLunas/V_WA_Tagihan', $data);
        $this->load->view('template/V_FooterBelumLunas', $data);
    }

    public function KirimWAAksi()
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
        $checkDuplicate         = $this->M_Area->CheckDuplicateArea($nama_area);

        // Rules form Validation
        $this->form_validation->set_rules('nama_area', 'Nama', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataArea/V_EditArea', $data);
            $this->load->view('template/V_FooterArea', $data);
        } else {
            if ($nama_area == $checkDuplicate->nama_area) {

                // Notifikasi Duplicate Name 
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Edit Area');
                $this->session->set_flashdata('DuplicateName_text', 'Nama area sudah ada');

                redirect('admin/DataArea/C_DataArea');
            } else {
                $this->M_CRUD->updateData('data_area', $dataArea, $idArea);

                // Notifikasi Edit Berhasil
                $this->session->set_flashdata('Edit_icon', 'success');
                $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

                redirect('admin/DataArea/C_DataArea');
            }
        }
    }
}
