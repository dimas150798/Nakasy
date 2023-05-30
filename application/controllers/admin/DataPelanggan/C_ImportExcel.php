<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

class C_ImportExcel extends CI_Controller
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
        // Memanggil mysql dari model
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_ImportExcel', $data);
        $this->load->view('template/V_FooterImportExcel', $data);
    }

    public function  ImportExcel()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $upload_status = $this->uploadDoc();
            if ($upload_status != false) {
                $inputFileName = 'assets/uploads/imports/' . $upload_status;
                $inputTileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputTileType);
                $spreadsheet = $reader->load($inputFileName);
                $sheet = $spreadsheet->getSheet(0);
                $count_Rows = 0;

                $counter = 0;
                foreach ($sheet->getRowIterator(6) as $row) {
                    if (++$counter == 6) continue;
                    $Kode_Customer   = $spreadsheet->getActiveSheet()->getCell('B' . $row->getRowIndex());
                    $Phone_Customer             = $spreadsheet->getActiveSheet()->getCell('C' . $row->getRowIndex());
                    $Nama_Customer           = $spreadsheet->getActiveSheet()->getCell('D' . $row->getRowIndex());

                    $data = array(
                        'kode_customer'            => $Kode_Customer,
                        'phone_customer'         => $Phone_Customer,
                        'nama_customer'        => $Nama_Customer,
                    );

                    $this->db->insert('data_customer', $data);
                    $count_Rows++;
                }


                // Notifikasi Insert Data Berhasil
                $this->session->set_flashdata('ExcelSuccess_icon', 'success');
                $this->session->set_flashdata('ExcelSuccess_title', 'Insert Data Berhasil');

                redirect('admin/DataPelanggan/C_DataPelanggan');
            } else {
                // Notifikasi Insert Data Gagal
                $this->session->set_flashdata('ExcelGagal_icon', 'warning');
                $this->session->set_flashdata('ExcelGagal_title', 'Insert Data Gagal');

                redirect('admin/DataPelanggan/C_ImportExcel');
            }
        } else {
            // Notifikasi Insert Data Gagal
            $this->session->set_flashdata('ExcelGagal_icon', 'warning');
            $this->session->set_flashdata('ExcelGagal_title', 'Insert Data Gagal');

            redirect('admin/DataPelanggan/C_DataPelanggan');
        }
    }

    function uploadDoc()
    {

        $uploadPath = 'assets/uploads/imports/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = 'csv|xlsx|xls';
        $config['max_size'] = 1000000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload('upload_excel')) {
            $fileData = $this->upload->data();
            $data['file_name'] = $fileData['file_name'];
            $this->db->insert('data_excel', $data);
            $insert_id = $this->db->insert_id();
            $_SESSION['lastid'] = $insert_id;

            return $fileData['file_name'];
        } else {
            return false;
        }
    }
}
