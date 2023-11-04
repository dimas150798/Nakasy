<?php

class M_DaerahMikrotik extends CI_Model
{

    public function DaerahMikrotik()
    {
        $query   = $this->db->query("SELECT id_mikrotik, nama_DaerahMikrotik
            
            FROM daerah_mikrotik
   
            ORDER BY nama_DaerahMikrotik ASC");

        return $query->result_array();
    }
}
