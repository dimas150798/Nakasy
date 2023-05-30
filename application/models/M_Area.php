<?php

class M_Area extends CI_Model
{
    // Menampilkan Data Area
    public function DataArea()
    {
        $query   = $this->db->query("SELECT id_area, nama_area
                FROM data_area
                ORDER BY nama_area ASC");

        return $query->result_array();
    }
    public function EditArea($id_area)
    {
        $query   = $this->db->query("SELECT id_area, nama_area
        FROM data_area
        WHERE id_area = '$id_area'
        ORDER BY nama_area ASC");

        return $query->result_array();
    }
}
