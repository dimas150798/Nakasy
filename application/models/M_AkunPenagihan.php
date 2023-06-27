<?php

class M_AkunPenagihan extends CI_Model
{

    // Menampilkan Data Penagih
    public function DataPenagih()
    {
        $query   = $this->db->query("SELECT id_penagih, email_login, area_1, area_2, area_3, area_4, area_5
            FROM data_penagih

            ORDER BY email_login ASC");

        return $query->result_array();
    }

    // Menampilkan Data Login User
    public function DataLoginUser()
    {
        $query   = $this->db->query("SELECT data_login.id_login, data_login.email_login, data_login.password_login, 
                data_login.id_akses, data_akses.nama_akses
                FROM data_login
    
                LEFT JOIN data_akses ON data_login.id_akses = data_akses.id_akses

                WHERE data_login.id_akses = 3
                ORDER BY data_login.id_login ASC");

        return $query->result_array();
    }

    // Edit Data Login
    public function EditLogin($id_login)
    {
        $query   = $this->db->query("SELECT data_login.id_login, data_login.email_login, data_login.password_login, 
        data_login.id_akses, data_akses.nama_akses
        FROM data_login

        LEFT JOIN data_akses ON data_login.id_akses = data_akses.id_akses

        WHERE id_login = '$id_login'
        ORDER BY data_login.id_login ASC");

        return $query->result_array();
    }

    // Check akses login
    public function CheckLogin($email_login, $password_login)
    {
        $this->db->select('data_login.email_login, data_login.password_login, data_login.id_akses');
        $this->db->join('data_akses', 'data_login.id_akses=data_akses.id_akses', 'left');
        $this->db->where('data_login.email_login', $email_login);
        $this->db->where('data_login.password_login', $password_login);

        $this->db->limit(1);
        $result = $this->db->get('data_login');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
