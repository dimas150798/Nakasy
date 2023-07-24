<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahAkunUser extends CI_Controller
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
        // clear session login
        $this->session->unset_userdata('LoginBerhasil_icon');

        //memanggil mysql dari model 
        $data['DataAkun']       = $this->M_Login->DataLoginUser();
        $data['DataArea']       = $this->M_Area->DataArea();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/AkunUser/V_TambahAkunUser', $data);
        $this->load->view('template/V_FooterAkunUser', $data);
    }

    public function TambahAkunSave()
    {
        //mengambil data post pada view 
        $nama_penagih       = $this->input->post('nama_penagih');
        $email_login        = $this->input->post('email_login');
        $are_1              = $this->input->post('area_1');
        $are_2              = $this->input->post('area_2');
        $are_3              = $this->input->post('area_3');
        $are_4              = $this->input->post('area_4');
        $are_5              = $this->input->post('area_5');

        //menyimpan data akun ke dalam array
        $dataAkun = array(
            'email_login'       => $email_login,
            'nama_penagih'      => $nama_penagih,
            'area_1'            => $are_1,
            'area_2'            => $are_2,
            'area_3'            => $are_3,
            'area_4'            => $are_4,
            'area_5'            => $are_5,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        $checkDuplicate         = $this->M_DataAkun->CheckDuplicateAkunUser($email_login);

        if ($email_login == $checkDuplicate->email_login) {
            // Notifikasi Duplicate Name 
            $this->session->set_flashdata('DuplicateName_icon', 'error');
            $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Akun');
            $this->session->set_flashdata('DuplicateName_text', 'Nama akun sudah ada');

            redirect('superadmin/AkunUser/C_TambahAkunUser');
        } else {
            // Notifikasi Tambah Berhasil
            $this->session->set_flashdata('Tambah_icon', 'success');
            $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

            $this->M_CRUD->insertData(array_unique($dataAkun), 'data_penagih');
            redirect('superadmin/AkunUser/C_DataAkunUser');
        }
    }
}
