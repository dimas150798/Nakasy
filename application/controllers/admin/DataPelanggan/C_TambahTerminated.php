<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahTerminated extends CI_Controller
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

    public function TerminatedPelanggan($id_customer)
    {
        $data['DataPelanggan']  = $this->M_Pelanggan->EditPelanggan($id_customer);
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_TambahTerminated', $data);
        $this->load->view('template/V_FooterPelanggan', $data);
    }

    public function TerminatedPelangganSave()
    {
        // Mengambil data post pada view
        $id_pppoe               = $this->input->post('id_pppoe');
        $id_customer            = $this->input->post('id_customer');
        $stop_date              = $this->input->post('stop_date');

        // Menyimpan data pelanggan ke dalam array
        $dataPelanggan = array(
            'id_customer'       => $id_customer,
            'stop_date'         => $stop_date,
            'updated_at'        => date('Y-m-d H:i:s', time())
        );

        // Kondisi update menggunakan id_customer
        $idCustomer = array(
            'id_customer'       => $id_customer
        );

        // Memanggil mysql dari model
        $data['DataPelanggan']  = $this->M_Pelanggan->EditPelanggan($id_customer);
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        // Rules form validation
        $this->form_validation->set_rules('stop_date', 'Stop Date', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataPelanggan/V_TambahTerminated', $data);
            $this->load->view('template/V_FooterPelanggan', $data);
        } else {
            if ($kode_mikrotik = 'Kraksaan') {
                $api = connectKraksaaan();
                $api->comm('/ppp/secret/set', [
                    ".id" => $id_pppoe,
                    "disabled" => 'true',
                ]);
                $api->disconnect();
            }

            if ($kode_mikrotik = 'Paiton') {
                $api = connectPaiton();
                $api->comm('/ppp/secret/set', [
                    ".id" => $id_pppoe,
                    "disabled" => 'true',
                ]);
                $api->disconnect();
            }

            $this->M_CRUD->updateData('data_customer', $dataPelanggan, $idCustomer);

            // Notifikasi Login Berhasil
            $this->session->set_flashdata('Terminasi_icon', 'success');
            $this->session->set_flashdata('Terminasi_title', 'Terminasi Pelanggan Berhasil');

            redirect('admin/DataPelanggan/C_DataPelanggan');
        }
    }
}
