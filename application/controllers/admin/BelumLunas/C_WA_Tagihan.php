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
        $data['DataRekening']   = $this->M_Rekening->DataRekening();

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
        $id_customer            = $this->input->post('id_customer');
        $nama_paket             = $this->input->post('nama_paket');
        $harga_paket            = $this->input->post('harga_paket');
        $nama_customer          = $this->input->post('nama_customer');
        $phone_customer         = $this->input->post('phone_customer');
        $tanggal_penagihan      = $this->input->post('tanggal_penagihan');
        $bulan_penagihan        = $this->input->post('bulan_penagihan');
        $tahun_penagihan        = $this->input->post('tahun_penagihan');
        $tahun_penagihan        = $this->input->post('tahun_penagihan');

        $daerah_rekening        = $this->input->post('daerah_rekening');

        $GetDataRekening        = $this->M_Rekening->CheckRekening($daerah_rekening);

        // Rekening 1
        $nama_bank_1            = $GetDataRekening[0]['nama_bank'];
        $no_rekening_1          = $GetDataRekening[0]['no_rekening'];
        $nama_rekening_1        = $GetDataRekening[0]['nama_rekening'];

        // Rekening 2
        $nama_bank_2            = $GetDataRekening[1]['nama_bank'];
        $no_rekening_2          = $GetDataRekening[1]['no_rekening'];
        $nama_rekening_2        = $GetDataRekening[1]['nama_rekening'];

        $convertPhone = preg_replace('/^\+?08/', '628', $phone_customer);

        header("location:https://api.whatsapp.com/send?phone=$convertPhone&text=*NAKASY* %0a%0a Yth Bapak / Ibu %0a Nama : $nama_customer %0a Telepon : $phone_customer %0a%0a *PEMBAYARAN* %0a Tagihan Bulan : $bulan_penagihan %0a Jenis Paket : $nama_paket %0a Harga Paket : $harga_paket %0a Total : $harga_paket (Sudah Termasuk PPN) %0a%0a Keterangan : *Belum Terbayar* %0a%0a *Informasi Tambahan* %0a Pembayaran dapat dilakukan dengan cara : %0a%0a *Transfer BANK* %0a Nomor rekening $no_rekening_1 Bank $nama_bank_1 atas nama *$nama_rekening_1* %0a%0a Atau *Transfer BANK* %0a Nomor rekening $no_rekening_2 Bank $nama_bank_2 atas nama *$nama_rekening_2* %0a%0a Selesai melakukan pembayaran Mohon dapat *dilampirkan bukti pembayaran* pada balasan pesan ini %0a%0a Jika ada pertanyaan lebih lanjut, anda dapat langsung membalas pesan ini. %0a%0a Terima Kasih. %0a Hormat Kami. %0a%0a *NAKASY*
            ");

        echo "
            <script>
               window.location=history.go(-1);
            </script>
            ";
    }
}
