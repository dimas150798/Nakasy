<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

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
        $data['DataExcel']      = $this->M_ImportExcel->DataExcel();

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
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
            }
            for ($i = 1; $i < count($sheetData); $i++) {
                $kode_customer = $sheetData[$i]['0'];
                $phone_customer = $sheetData[$i]['1'];

                $data_customer = array(
                    'kode_customer' => $kode_customer,
                    'phone_customer' => $phone_customer
                );

                $a = $this->M_CRUD->get('data_customer', "kode_customer='$kode_customer'")->result_array();

                $getData = $this->db->query("SELECT `id_customer`, `kode_customer`, `phone_customer`, `latitude`, `longitude`, `nama_customer`, `nama_paket`, `name_pppoe`, `password_pppoe`, `id_pppoe`, `alamat_customer`, `email_customer`, `start_date`, `stop_date`, `nama_area`, `deskripsi_customer`, `nama_sales`, `created_at`, `updated_at` FROM `data_customer`
                ")->result_array();

                if (count($a) != 0) {
                    foreach ($getData as $data) {
                        if ($data['kode_customer'] == $sheetData[$i]['0']) {
                            $this->db->update("data_customer", ['phone_customer' => $sheetData[$i]['1']], ['kode_customer' => $data['kode_customer']]);
                        }
                    }
                }

                if (count($a) == 0) {
                    $this->M_CRUD->insertData($data_customer, 'data_customer');
                }
            }
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
