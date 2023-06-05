<?php

class M_TerminasiPelanggan extends CI_Model
{
    // Menampilkan Data Pelanggan Terminasi
    public function TerminasiPelanggan()
    {
        $query   = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer,
            data_customer.nama_paket, data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.nama_area, data_customer.nama_sales,
            data_customer.alamat_customer, data_customer.email_customer, data_customer.start_date, data_customer.stop_date, data_customer.deskripsi_customer,
            data_area.nama_area, data_sales.nama_sales, data_paket.nama_paket
            
            FROM data_customer
            
            LEFT JOIN data_area ON data_customer.nama_area = data_area.nama_area
            LEFT JOIN data_sales ON data_customer.nama_sales = data_sales.nama_sales
            LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket

            WHERE stop_date IS NOT NULL
            
            GROUP BY data_customer.name_pppoe
            ORDER BY data_customer.nama_customer ASC");

        return $query->result_array();
    }

    // Menampilkan Jumlah Pelanggan Terminasi
    public function JumlahTerminasi()
    {
        $query   = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer,
        data_customer.nama_paket, data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.nama_area, data_customer.nama_sales,
        data_customer.alamat_customer, data_customer.email_customer, data_customer.start_date, data_customer.stop_date, data_customer.deskripsi_customer,
        data_area.nama_area, data_sales.nama_sales, data_paket.nama_paket
        
        FROM data_customer
        
        LEFT JOIN data_area ON data_customer.nama_area = data_area.nama_area
        LEFT JOIN data_sales ON data_customer.nama_sales = data_sales.nama_sales
        LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket

        WHERE stop_date IS NOT NULL
        
        GROUP BY data_customer.name_pppoe
        ORDER BY data_customer.nama_customer ASC");

        return $query->num_rows();
    }

    // Edit Data Pelanggan
    public function EditPelanggan($id_customer)
    {
        $query   = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer,
            data_customer.nama_paket, data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.nama_area, data_customer.nama_sales,
            data_customer.alamat_customer, data_customer.email_customer, data_customer.start_date, data_customer.stop_date, data_customer.deskripsi_customer,
            data_area.nama_area, data_sales.nama_sales, data_paket.nama_paket
            
            FROM data_customer
            
            LEFT JOIN data_area ON data_customer.nama_area = data_area.nama_area
            LEFT JOIN data_sales ON data_customer.nama_sales = data_sales.nama_sales
            LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket

            WHERE id_customer = '$id_customer'
            
            GROUP BY data_customer.name_pppoe
            ORDER BY data_customer.nama_customer ASC");

        return $query->result_array();
    }
}
