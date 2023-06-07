<?php

ini_set('display_errors', 1);
error_reporting(E_ALL && ~E_NOTICE);

class MikrotikModel extends CI_Model
{
    public function index()
    {
        $response = [];

        $api = connect();
        $pppSecret = $api->comm('/ppp/secret/print');
        $api->disconnect();

        $paket = array(
            'HOME 5 A' => 'Home 5', 'HOME 5 B' => 'Home 5', 'HOME 10 A' => 'Home 10', 'HOME 10 B' => 'Home 10',
            'HOME 20 A' => 'Home 20', 'HOME 20 B' => 'Home 20', 'HOME 30 A' => 'Home 30',
            'HOME 30 B' => 'Home 30', 'HOME 50 A' => 'Home 50', 'HOME 50 B' => 'Home 50',
            'HOME 100' => 'Home 100', 'HOME TV 25' => 'Home TV 25', 'HOME TV 70' => 'Home TV 70',
            'HOME 2' => 'Home 2'
        );

        $getData = $this->db->query("
            SELECT 
            data_customer.*,
            data_area.nama_area as area_name, 
            data_paket.id_paket as id_paket, 
            data_paket.harga_paket as paket_price, 
            data_sales.nama_sales as sales_name
            FROM data_customer
            left join data_area on data_area.nama_area = data_customer.nama_area
            left join data_paket on data_paket.nama_paket = data_customer.nama_paket
            left join data_sales on data_sales.nama_sales = data_customer.nama_sales
            order by data_customer.id_customer desc
            ")->result_array();

        foreach ($pppSecret as $keySecret => $valueSecret) {
            $status = false;

            foreach ($getData as $key => $value) {
                if ($valueSecret['name'] == $value['name_pppoe']) {
                    $status = true;

                    $this->db->update("data_customer", ['id_pppoe' => $valueSecret['.id']], ['id_customer' => $value['id_customer']]);

                    $response[$keySecret] = [
                        'id_customer'       => $value['id_customer'],
                        'kode_customer'     => $value['kode_customer'],
                        'phone_customer'    => $value['phone_customer'],
                        'latitude'          => $value['latitude'],
                        'longitude'         => $value['longitude'],
                        'nama_customer'     => $valueSecret['name'],
                        'nama_paket'        => $paket[$valueSecret['profile']],
                        'name_pppoe'        => $valueSecret['name'],
                        'password_pppoe'    => $valueSecret['password'],
                        'id_pppoe'          => $valueSecret['.id'],
                        'alamat_customer'   => $value['alamat_customer'],
                        'email_customer'    => $value['email_customer'],
                        'start_date'        => $value['start_date'],
                        'stop_date'         => $value['stop_date'],
                        'nama_area'         => $value['nama_area'],
                        'deskripsi_customer' => $value['deskripsi_customer'],
                        'nama_sales'          => $value['nama_sales'],
                        'created_at'        => $value['created_at'],
                        'updated_at'        => $value['updated_at'],
                        'disabled'          => $valueSecret['disabled'],
                    ];
                }
            }
            if ($status == false) {
                $this->db->insert("data_customer", [
                    "kode_customer"     => '0',
                    "phone_customer"    => '0',
                    "latitude"          => '0',
                    "longitude"         => '0',
                    "nama_customer"     => $valueSecret['name'],
                    "nama_paket"        => $paket[$valueSecret['profile']],
                    'name_pppoe'        => $valueSecret['name'],
                    'password_pppoe'    => $valueSecret['password'],
                    'id_pppoe'          => $valueSecret['.id'],
                    'alamat_customer'   => '0',
                    'email_customer'    => '0',
                    "start_date"        => NULL,
                    "stop_date"         => NULL,
                    "nama_area"         => 0,
                    "deskripsi_customer" => '0',
                    "nama_sales"        => 0,
                    "created_at"        => date('Y-m-d H:i:s', time()),
                    "updated_at"        => date('Y-m-d H:i:s', time()),
                ]);

                $lastPay = date("Y-m-d", strtotime("+1 months"));
                $payStatus = [];

                $response[$keySecret] = [
                    'id_customer'       => $this->db->insert_id(),
                    'kode_customer'     => '0',
                    'phone_customer'    => '0',
                    'latitude'          => '0',
                    'longitude'         => '0',
                    'nama_customer'     => $valueSecret['name'],
                    'nama_paket'        => $paket[$valueSecret['profile']],
                    'name_pppoe'        => $valueSecret['name'],
                    'password_pppoe'    => $valueSecret['password'],
                    'id_pppoe'          => $valueSecret['.id'],
                    'alamat_customer'   => '0',
                    'email_customer'    => '0',
                    'start_date'        => NULL,
                    'stop_date'         => null,
                    'nama_area'         => '0',
                    'deskripsi_customer' => '0',
                    'nama_sales'        => '0',
                    'created_at'        => date('Y-m-d H:i:s', time()),
                    'updated_at'        => date('Y-m-d H:i:s', time()),
                    'disabled'          => $valueSecret['disabled'],
                ];
            }
        }

        return $response;
    }

    // Menampilkan Data Login
    public function DataMikrotik()
    {
        $query   = $this->db->query("SELECT id_mikrotik, ip_mikrotik, username_mikrotik, password_mikrotik, status_mikrotik
                FROM data_mikrotik
    
                ORDER BY id_mikrotik DESC");

        return $query->result_array();
    }

    // Edit Mikrotik
    public function EditMikrotik($id_mikrotik)
    {
        $query   = $this->db->query("SELECT id_mikrotik, ip_mikrotik, username_mikrotik, password_mikrotik, status_mikrotik
                FROM data_mikrotik
                WHERE id_mikrotik = '$id_mikrotik'
                ORDER BY ip_mikrotik ASC");

        return $query->result_array();
    }

    // Check data mikrotik
    public function jumlahMikrotik()
    {
        $this->db->select('ip_mikrotik, username_mikrotik, password_mikrotik');

        $this->db->limit(1);
        $result = $this->db->get('data_mikrotik');

        return $result->num_rows();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Check data mikrotik
    public function jumlahMikrotikAktif()
    {
        $this->db->select('ip_mikrotik, username_mikrotik, password_mikrotik');
        $this->db->where('status_mikrotik', 'enable');
        $this->db->limit(1);
        $result = $this->db->get('data_mikrotik');

        return $result->num_rows();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Check status mikrotik
    public function CheckStatusMikrotik()
    {
        $this->db->select('ip_mikrotik, username_mikrotik, password_mikrotik', 'status_mikrotik');
        $this->db->where('status_mikrotik', 'enable');

        $this->db->limit(1);
        $result = $this->db->get('data_mikrotik');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
