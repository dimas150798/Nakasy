<?php

class M_Sales extends CI_Model
{
    // Menampilkan Data Sales
    public function DataSales()
    {
        $query   = $this->db->query("SELECT data_sales.id_sales, data_sales.nama_sales, data_sales.phone_sales, data_sales.id_jabatan, data_jabatan.nama_jabatan
                FROM data_sales
                LEFT JOIN data_jabatan ON data_sales.id_jabatan = data_jabatan.id_jabatan
                ORDER BY data_sales.nama_sales ASC");

        return $query->result_array();
    }

    public function EditSales($id_sales)
    {
        $query   = $this->db->query("SELECT data_sales.id_sales, data_sales.nama_sales, data_sales.phone_sales, data_sales.id_jabatan, data_jabatan.nama_jabatan
                    FROM data_sales
                    LEFT JOIN data_jabatan ON data_sales.id_jabatan = data_jabatan.id_jabatan

                    WHERE id_sales = '$id_sales'
                    ORDER BY data_jabatan.nama_jabatan ASC");

        return $query->result_array();
    }
}
