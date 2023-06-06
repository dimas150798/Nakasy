<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditPaket extends CI_Controller
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

    public function EditPaket($id_paket)
    {
        //memanggil mysql dari model 
        $data['DataPaket']       = $this->M_Paket->EditPaket($id_paket);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPaket/V_EditPaket', $data);
        $this->load->view('template/V_FooterPaket', $data);
    }

    public function EditPaketSave()
    {
        //mengambil data post pada view 
        $id_paket           = $this->input->post('id_paket');
        $nama_paket         = $this->input->post('nama_paket');
        $harga_paket        = $this->input->post('harga_paket');
        $deskripsi_paket    = $this->input->post('deskripsi_paket');

        //memanggil mysql dari model 
        $data['DataPaket']       = $this->M_Paket->EditPaket($id_paket);
        $checkDuplicate          = $this->M_Paket->CheckDuplicatePaket($nama_paket);

        //menyimpan data ke dalam array
        $dataPaket = array(
            'nama_paket'        => $nama_paket,
            'harga_paket'       => $harga_paket,
            'deskripsi_paket'   => $deskripsi_paket,
            'updated_at'        => date('Y-m-d H:i:s', time())
        );

        $idPaket = array(
            'id_paket' => $id_paket
        );

        // Rules form Validation
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('harga_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('deskripsi_paket', 'Deskripsi Paket', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataPaket/V_EditPaket', $data);
            $this->load->view('template/V_FooterPaket', $data);
        } else {
            $this->M_CRUD->updateData('data_paket', $dataPaket, $idPaket);

            // Notifikasi Edit Berhasil
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            redirect('admin/DataPaket/C_DataPaket');
        }
    }
}
