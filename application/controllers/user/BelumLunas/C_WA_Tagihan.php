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
        $this->load->view('template/sidebarUser', $data);
        $this->load->view('user/BelumLunas/V_WA_Tagihan', $data);
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

        $convertPhone = preg_replace('/^\+?08/', '628', $phone_customer);

        header("location:https://api.whatsapp.com/send?phone=$convertPhone&text=*INFLY NETWORKS* %0a%0a Yth Bapak / Ibu %0a Nama : $nama_customer %0a Telepon : $phone_customer %0a%0a *PEMBAYARAN* %0a Tagihan Bulan : $bulan_penagihan %0a Jenis Paket : $nama_paket %0a Harga Paket : $harga_paket %0a Total : $harga_paket (Sudah Termasuk PPN) %0a%0a Keterangan : *Belum Terbayar* %0a%0a *Informasi Tambahan* %0a Pembayaran dapat dilakukan dengan cara : %0a%0a *Transfer BANK* %0a Nomor rekening 0561009449 Bank Jatim atas nama *PT. Urban Teknologi Nusantara* %0a%0a Atau via mobile Banking/QRIS dengan cara Scan barcode QRIS %0a%0a Selesai melakukan pembayaran Mohon dapat *dilampirkan bukti pembayaran* pada balasan pesan ini %0a%0a *Tidak melakukan pembayaran disaat jatuh tempo pukul 19.00 WIB Layanan internet akan otomatis terisolir oleh system.* %0a%0a Batas pembayaran maksimal 3 hari setelah melewati jatuh tempo. %0a%0a Jika ada pertanyaan lebih lanjut, anda dapat langsung membalas pesan ini. %0a%0a Terima Kasih. %0a Hormat Kami. %0a%0a *INFLY NETWORKS*
            ");

        echo "
            <script>
               window.location=history.go(-1);
            </script>
            ";
    }
}
