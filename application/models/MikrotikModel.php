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
            '2M' => '2M', 'EXPIRED' => 'EXPIRED', 'INET-4M' => 'INET-4M', 'INET-10M' => 'INET-10M',
            'INET-20M' => 'INET-20M', 'INET-30M' => 'INET-30M', 'INET-100M' => 'INET-100M',
            'INET-300M' => 'INET-300M', 'profile1' => 'profile1', 'profile20' => 'profile20'
        );

        $getData = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.nama_customer, 
            data_customer.nama_paket, data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer,
            data_customer.email_customer, data_customer.start_date, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer,
            data_customer.nama_sales, data_area.nama_area, data_paket.nama_paket, data_paket.harga_paket, data_sales.nama_sales
                    
            FROM data_customer
        
            LEFT JOIN data_area ON data_area.nama_area = data_customer.nama_area
            LEFT JOIN data_paket ON data_paket.nama_paket = data_customer.nama_paket
            LEFT JOIN data_sales ON data_sales.nama_sales = data_customer.nama_sales
            ORDER BY data_customer.id_customer")->result_array();

        // Iterate through $pppSecret
        foreach ($pppSecret as $keySecret => $valueSecret) {
            $status = false;

            // Search for a matching PPPoE secret in $getData
            foreach ($getData as $key => $value) {
                if ($valueSecret['name'] == $value['name_pppoe']) {
                    $status = true;

                    // Update existing data_customer record
                    $this->db->where('id_customer', $value['id_customer']);
                    $this->db->update("data_customer", [
                        'id_pppoe' => $valueSecret['.id'],
                        'disabled' => $valueSecret['disabled']
                    ]);

                    // Add data to $response array
                    $response[$keySecret] = [
                        'id_customer'       => $value['id_customer'],
                        'kode_customer'     => $value['kode_customer'],
                        'nama_customer'     => $value['nama_customer'],
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
                        'nama_sales'        => $value['nama_sales'],
                        'created_at'        => $value['created_at'],
                        'updated_at'        => $value['updated_at'],
                    ];

                    break; // Exit the inner loop since we found a match
                }
            }

            // If no match was found, insert a new data_customer record
            if (!$status) {
                $insertData = [
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
                    "deskripsi_customer" => $valueSecret['comment'],
                ];

                // Insert new data_customer record
                $this->db->insert("data_customer", $insertData);

                // Add data to $response array
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
                    "deskripsi_customer" => $valueSecret['comment'],
                ];
            }
        }
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

    public function TerminasiAuto($bulan, $tahun, $tanggalAkhir)
    {
        $getData = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
        data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
        DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales, data_customer.disabled,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
        data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
        data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket

        FROM data_customer
        LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
        data_pembayaran.transaction_time IS NULL AND data_customer.stop_date IS NULL AND
        data_customer.disabled = 'false'

        GROUP BY data_customer.name_pppoe
        ORDER BY data_customer.nama_customer ASC
        ")->result_array();

        foreach ($getData as $data) {
            date_default_timezone_set("Asia/Jakarta");
            $day = date("d");

            if ($data['transaction_time'] == null && $data['status_code'] == null) {
                // disable secret dan active otomatis 
                $api = connect();
                $api->comm('/ppp/secret/set', [
                    ".id" => $data['id_pppoe'],
                    "disabled" => 'true',
                ]);

                // disable active otomatis
                $ambilid = $api->comm("/ppp/active/print", ["?name" => $data['name_pppoe']]);
                $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
                $api->disconnect();
            }
        }
    }

    public function EnableAuto()
    {
        $getData = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
        data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
        DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales, data_customer.disabled,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
        data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
        data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket

        FROM data_customer
        LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
        AND MONTH(data_pembayaran.transaction_time) = '10' AND YEAR(data_pembayaran.transaction_time) = '2023'

        WHERE data_customer.start_date BETWEEN '2020-10-01' AND '2023-10-31' AND 
        data_customer.stop_date IS NULL

        GROUP BY data_customer.name_pppoe
        ORDER BY data_customer.nama_customer ASC
        ")->result_array();

        foreach ($getData as $data) {
            date_default_timezone_set("Asia/Jakarta");

            if ($data['transaction_time'] == null && $data['status_code'] == null) {
                // disable secret dan active otomatis 
                $api = connect();
                $api->comm('/ppp/secret/set', [
                    ".id" => $data['id_pppoe'],
                    "disabled" => 'false',
                ]);
            }
        }
    }
}
