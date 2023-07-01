<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditAkunUser extends CI_Controller
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

    public function EditAkun($id_penagih)
    {
        //memanggil mysql dari model 
        $data['DataAkun']       = $this->M_AkunPenagihan->EditPenagihan($id_penagih);
        $data['DataLogin']      = $this->M_Login->DataLoginUser();
        $data['DataArea']       = $this->M_Area->DataArea();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/AkunUser/V_EditAkunUser', $data);
        $this->load->view('template/V_FooterAkun', $data);
    }

    public function EditAkunSave()
    {
        //mengambil data post pada view 
        $id_penagih         = $this->input->post('id_penagih');
        $email_login        = $this->input->post('email_login');
        $area_1             = $this->input->post('area_1');
        $area_2             = $this->input->post('area_2');
        $area_3             = $this->input->post('area_3');
        $area_4             = $this->input->post('area_4');
        $area_5             = $this->input->post('area_5');

        //menyimpan data akun ke dalam array
        $dataAkun = array(
            'email_login'       => $email_login,
            'area_1'            => $area_1,
            'area_2'            => $area_2,
            'area_3'            => $area_3,
            'area_4'            => $area_4,
            'area_5'            => $area_5,
            'updated_at'        => date('Y-m-d H:i:s', time())
        );

        $idPenagih = array(
            'id_penagih' => $id_penagih
        );

        //memanggil mysql dari model 
        $data['DataAkun']       = $this->M_AkunPenagihan->EditPenagihan($id_penagih);
        $data['DataLogin']      = $this->M_Login->DataLoginUser();
        $data['DataArea']       = $this->M_Area->DataArea();

        $this->M_CRUD->updateData('data_penagih', array_unique($dataAkun), $idPenagih);

        // Notifikasi Edit Berhasil
        $this->session->set_flashdata('Edit_icon', 'success');
        $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

        redirect('superadmin/AkunUser/C_DataAkunUser');
    }
}
