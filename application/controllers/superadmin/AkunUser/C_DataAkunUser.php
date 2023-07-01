<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DataAkunUser extends CI_Controller
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

        $data['DataLogin'] = $this->M_DataAkun->DataAkun();
        $data['DataPenagih'] = $this->M_AkunPenagihan->DataPenagih();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/AkunUser/V_DataAkunUser', $data);
        $this->load->view('template/V_FooterAkunUser', $data);
    }

    public function GetDataAjax()
    {
        $result = $this->M_AkunPenagihan->DataPenagih();

        $no = 0;

        foreach ($result as $dataAkun) {
            $area_1 = $dataAkun['area_1'] == '';
            $area_2 = $dataAkun['area_2'] == '';
            $area_3 = $dataAkun['area_3'] == '';
            $area_4 = $dataAkun['area_4'] == '';
            $area_5 = $dataAkun['area_5'] == '';

            $row = array();
            $row[] = ++$no;
            $row[] = $dataAkun['email_login'];
            $row[] = '<div>' . ($area_1 ? '<span class="badge bg-danger">Data Kosong</span>' : $dataAkun['area_1']) . '</div>';
            $row[] = '<div>' . ($area_2 ? '<span class="badge bg-danger">Data Kosong</span>' : $dataAkun['area_2']) . '</div>';
            $row[] = '<div>' . ($area_3 ? '<span class="badge bg-danger">Data Kosong</span>' : $dataAkun['area_3']) . '</div>';
            $row[] = '<div>' . ($area_4 ? '<span class="badge bg-danger">Data Kosong</span>' : $dataAkun['area_4']) . '</div>';
            $row[] = '<div>' . ($area_5 ? '<span class="badge bg-danger">Data Kosong</span>' : $dataAkun['area_5']) . '</div>';
            $row[] =
                '<div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="EditAkun(' . $dataAkun['id_penagih'] . ')"class="dropdown-item text-black"></i> Edit</a>
                        <a onclick="DeleteAkun(' . $dataAkun['id_penagih'] . ')" class="dropdown-item text-black"><i class="bi bi-trash3-fill"></i> Hapus</a>
                    </div>
                </div>
                </div>';
            $data[] = $row;
        }

        $ouput = array(
            'data' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
    }
}
