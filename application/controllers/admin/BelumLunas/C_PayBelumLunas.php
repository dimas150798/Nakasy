<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_PayBelumLunas extends CI_Controller
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

    public function Payment($id_customer)
    {
        $data['DataPelanggan']  = $this->M_BelumLunas->Payment($id_customer);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/BelumLunas/V_PayBelumLunas', $data);
        $this->load->view('template/V_FooterBelumLunas', $data);
    }

    public function PaymentSave()
    {
        // Mengambil data post pada view
        $id_pppoe               = $this->input->post('id_pppoe');
        $id_customer            = $this->input->post('id_customer');
        $nama_paket             = $this->input->post('nama_paket');
        $gross_amount           = $this->input->post('gross_amount');
        $order_id               = $this->input->post('order_id');
        $name_pppoe             = $this->input->post('name_pppoe');
        $biaya_admin            = $this->input->post('biaya_admin');
        $transaction_time       = $this->input->post('transaction_time');
        $nama_admin             = $this->input->post('nama_admin');
        $keterangan             = $this->input->post('keterangan');

        // Menyimpan data payment ke dalam array
        $dataPayment = array(
            'order_id'          => $order_id,
            'gross_amount'      => $gross_amount,
            'biaya_admin'       => $biaya_admin,
            'name_pppoe'        => $name_pppoe,
            'nama_paket'        => $nama_paket,
            'nama_admin'        => $nama_admin,
            'keterangan'        => $keterangan,
            'transaction_time'  => $transaction_time,
            'expired_date'      => $transaction_time,
            'status_code'       => 200,
        );

        // Memanggil mysql dari model
        $data['DataPelanggan']  = $this->M_BelumLunas->Payment($id_customer);

        // Rules form validation
        $this->form_validation->set_rules('biaya_admin', 'Biaya Admin', 'required');
        $this->form_validation->set_rules('transaction_time', 'Tanggal Transaksi', 'required');
        $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_PayBelumLunas', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        } else {
            // Notifikasi Login Berhasil
            $this->session->set_flashdata('payment_icon', 'success');
            $this->session->set_flashdata('payment_title', 'Pembayaran An. <b>' . $name_pppoe . '</b> Berhasil');

            $this->M_CRUD->insertData($dataPayment, 'data_pembayaran');
            $this->M_CRUD->insertData($dataPayment, 'data_pembayaran_history');
            redirect('admin/BelumLunas/C_BelumLunas');
        }
    }
}
