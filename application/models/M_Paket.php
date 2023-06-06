<?php

class M_Paket extends CI_Model
{
    // Menampilkan Data Paket
    public function DataPaket()
    {
        $query   = $this->db->query("SELECT id_paket, nama_paket, harga_paket, deskripsi_paket
                FROM data_paket
                ORDER BY id_paket ASC");

        return $query->result_array();
    }

    // Edit Paket
    public function EditPaket($id_paket)
    {
        $query   = $this->db->query("SELECT id_paket, nama_paket, harga_paket, deskripsi_paket
        FROM data_paket

        WHERE id_paket = '$id_paket'
        ORDER BY id_paket ASC");

        return $query->result_array();
    }
}
