<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahPaket extends CI_Controller
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
        $this->load->view('template/header');
        $this->load->view('template/sidebarAdmin');
        $this->load->view('admin/DataPaket/V_TambahPaket');
        $this->load->view('template/V_FooterPaket');
    }

    public function TambahPaketSave()
    {
        //mengambil data post pada view 
        $nama_paket         = $this->input->post('nama_paket');
        $harga_paket        = $this->input->post('harga_paket');
        $deskripsi_paket    = $this->input->post('deskripsi_paket');

        //menyimpan data ke dalam array
        $dataPaket = array(
            'nama_paket'        => $nama_paket,
            'harga_paket'       => $harga_paket,
            'deskripsi_paket'   => $deskripsi_paket,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        //memanggil mysql dari model 
        $checkDuplicate         = $this->M_Paket->CheckDuplicatePaket($nama_paket);

        // Rules form Validation
        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('harga_paket', 'Harga Paket', 'required');
        $this->form_validation->set_rules('deskripsi_paket', 'Deskripsi Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {

            // Notifikasi kesalahan input
            $this->session->set_flashdata('DuplicateName_icon', 'error');
            $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Paket');
            $this->session->set_flashdata('DuplicateName_text', 'Check kembali data');

            echo "
            <script>history.go(-1);            
            </script>
            ";
        } else {
            if ($nama_paket == $checkDuplicate->nama_paket) {
                // Notifikasi Duplicate Name 
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Paket');
                $this->session->set_flashdata('DuplicateName_text', 'Nama paket sudah ada');

                redirect('admin/DataPaket/C_TambahPaket');
            } else {
                $this->M_CRUD->insertData($dataPaket, 'data_paket');

                // Notifikasi Tambah Berhasil
                $this->session->set_flashdata('Tambah_icon', 'success');
                $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                redirect('admin/DataPaket/C_DataPaket');
            }
        }
    }
}
