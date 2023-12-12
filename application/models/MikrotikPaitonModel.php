<?php

ini_set('display_errors', 1);
error_reporting(E_ALL && ~E_NOTICE);

class MikrotikPaitonModel extends CI_Model
{
    public function index()
    {
        $response = [];

        // Connect to MikroTik API
        $api = connectPaiton();
        $pppSecret = $api->comm('/ppp/secret/print');
        $api->disconnect();

        $paket = array(
            '2M' => '2M', 'EXPIRED' => 'EXPIRED', 'INET-4M' => 'INET-4M', 'INET-10M' => 'INET-10M',
            'INET-20M' => 'INET-20M', 'INET-30M' => 'INET-30M', 'INET-100M' => 'INET-100M',
            'INET-300M' => 'INET-300M', 'profile1' => 'profile1', 'profile20' => 'profile20'
        );

        // Fetch data from the database
        $getData = $this->db->query("SELECT id_customer, nama_customer, name_pppoe, password_pppoe, id_pppoe, id_pppoe_paiton, kode_mikrotik, kode_mikrotik_paiton, disabled, disabled_paiton
        FROM data_customer")->result_array();

        // Use prepared statements for more efficiency
        $insertData = [];
        $updateData = [];
        $updateDataMikrotik = [];

        foreach ($pppSecret as $keySecret => $valueSecret) {
            $status = false;

            foreach ($getData as $key => $value) {
                if ($valueSecret['name'] == $value['name_pppoe']) {
                    $status = true;

                    if ($value['kode_mikrotik'] == NULL) {
                        $updateData[] = [
                            'id_customer'   => $value['id_customer'],
                            'id_pppoe_paiton'      => $valueSecret['.id'],
                            'disabled_paiton'      => $valueSecret['disabled'],
                            'kode_mikrotik_paiton' => 'Paiton'
                        ];

                        $response[$keySecret] = [
                            'id_customer'   => $value['id_customer'],
                            'kode_customer' => $value['kode_customer'],
                            'nama_customer' => $value['nama_customer'],
                            'nama_paket'    => $paket[$valueSecret['profile']],
                        ];
                    }

                    if ($value['kode_mikrotik'] != NULL) {
                        $updateData[] = [
                            'id_customer'   => $value['id_customer'],
                            'id_pppoe_paiton'      => $valueSecret['.id'],
                            'disabled_paiton'      => $valueSecret['disabled'],
                            'kode_mikrotik_paiton' => 'Paiton'
                        ];

                        $response[$keySecret] = [
                            'id_customer'   => $value['id_customer'],
                            'kode_customer' => $value['kode_customer'],
                            'nama_customer' => $value['nama_customer'],
                            'nama_paket'    => $paket[$valueSecret['profile']],
                        ];
                    }
                }
            }

            if ($status == false) {
                $insertData[] = [
                    'kode_customer'     => '0',
                    'phone_customer'    => '0',
                    'nama_customer'     => $valueSecret['name'],
                    'nama_paket'        => $paket[$valueSecret['profile']],
                    'name_pppoe'        => $valueSecret['name'],
                    'password_pppoe'    => $valueSecret['password'],
                    'id_pppoe_paiton'          => $valueSecret['.id'],
                    'alamat_customer'   => '0',
                    'email_customer'    => '0',
                    'disabled_paiton'          => $valueSecret['disabled'],
                    'kode_mikrotik_paiton'     => 'Paiton',
                    'created_at'        => date('Y-m-d H:i:s', time()),
                    'updated_at'        => date('Y-m-d H:i:s', time()),
                ];
            }
        }

        if (!empty($updateData)) {
            $this->db->update_batch("data_customer", $updateData, 'id_customer');
        }

        if (!empty($insertData)) {
            $this->db->insert_batch("data_customer", $insertData);
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
        $this->db->select('ip_mikrotik, username_mikrotik, password_mikrotik', 'status_mikrotik', 'daerah_mikrotik');
        $this->db->where('status_mikrotik', 'enable');
        $this->db->where('daerah_mikrotik', 'Paiton');

        $this->db->limit(1);
        $result = $this->db->get('data_mikrotik');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Terminasi Dari Atas
    public function Terminasi_Paiton_ASC($bulan, $tahun, $tanggalAkhir)
    {
        $getData = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
        data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
        DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales, data_customer.disabled, 
        data_customer.kode_mikrotik,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
        data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_paket.nama_paket as namaPaket, data_paket.harga_paket, data_customer.disabled_paiton, data_customer.kode_mikrotik_paiton, data_customer.id_pppoe_paiton

        FROM data_customer
        LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket
        LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
        data_pembayaran.transaction_time IS NULL AND data_customer.stop_date IS NULL AND
        data_customer.disabled_paiton = 'false' AND data_customer.kode_mikrotik_paiton = 'Paiton'

        GROUP BY data_customer.name_pppoe
        ORDER BY data_customer.nama_customer ASC
        ")->result_array();

        foreach ($getData as $data) {
            date_default_timezone_set("Asia/Jakarta");
            $day = date("d");

            if ($day == '12') {
                if ($data['transaction_time'] == null && $data['status_code'] == null) {
                    // disable secret dan active otomatis 
                    $api = connectPaiton();
                    $api->comm('/ppp/secret/set', [
                        ".id" => $data['id_pppoe_paiton'],
                        "disabled" => 'true',
                    ]);

                    // disable active otomatis
                    $ambilid = $api->comm("/ppp/active/print", ["?name" => $data['name_pppoe']]);
                    $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
                    $api->disconnect();
                }
            } else {
                echo "Belum tanggal 11";
            }
        }
    }

    // Terminasi Dari Atas
    public function Terminasi_Paiton_DESC($bulan, $tahun, $tanggalAkhir)
    {
        $getData = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
            data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
            DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales, data_customer.disabled, 
            data_customer.kode_mikrotik,
            data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
            data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
            data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
            data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket, data_customer.disabled_paiton, data_customer.kode_mikrotik_paiton, data_customer.id_pppoe_paiton
    
            FROM data_customer
            LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket
            LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
            AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
    
            WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
            data_pembayaran.transaction_time IS NULL AND data_customer.stop_date IS NULL AND
            data_customer.disabled_paiton = 'false' AND data_customer.kode_mikrotik_paiton = 'Paiton'
    
            GROUP BY data_customer.name_pppoe
            ORDER BY data_customer.nama_customer DESC
            ")->result_array();

        foreach ($getData as $data) {
            date_default_timezone_set("Asia/Jakarta");
            $day = date("d");

            if ($day == '12') {
                if ($data['transaction_time'] == null && $data['status_code'] == null) {
                    // disable secret dan active otomatis 
                    $api = connectPaiton();
                    $api->comm('/ppp/secret/set', [
                        ".id" => $data['id_pppoe_paiton'],
                        "disabled" => 'true',
                    ]);

                    // disable active otomatis
                    $ambilid = $api->comm("/ppp/active/print", ["?name" => $data['name_pppoe']]);
                    $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
                    $api->disconnect();
                }
            } else {
                echo "Belum tanggal 11";
            }
        }
    }

    // Terminasi Dari Atas
    public function Terminasi_PaitonAll_DESC($bulan, $tahun, $tanggalAkhir)
    {
        $getData = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
                data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
                DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales, data_customer.disabled, 
                data_customer.kode_mikrotik,
                data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
                data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
                data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
                data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket
        
                FROM data_customer
                LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket
                LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
                AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
        
                WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
                data_pembayaran.transaction_time IS NULL AND data_customer.stop_date IS NULL AND data_customer.kode_mikrotik = 'Kraksaan'
        
                GROUP BY data_customer.name_pppoe
                ORDER BY data_customer.nama_customer DESC
                ")->result_array();

        foreach ($getData as $data) {
            date_default_timezone_set("Asia/Jakarta");
            $day = date("d");

            if ($day == '12') {
                if ($data['transaction_time'] == null && $data['status_code'] == null) {
                    // disable secret dan active otomatis 
                    $api = connectPaiton();
                    $api->comm('/ppp/secret/set', [
                        ".id" => $data['id_pppoe'],
                        "disabled" => 'true',
                    ]);

                    // disable active otomatis
                    $ambilid = $api->comm("/ppp/active/print", ["?name" => $data['name_pppoe']]);
                    $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
                    $api->disconnect();
                }
            } else {
                echo "Belum tanggal 11";
            }
        }
    }

    public function Terminasi_PaitonAll_ASC($bulan, $tahun, $tanggalAkhir)
    {
        $getData = $this->db->query("SELECT data_customer.id_customer, data_customer.kode_customer, data_customer.phone_customer, data_customer.nama_customer, data_customer.nama_paket, 
                data_customer.name_pppoe, data_customer.password_pppoe, data_customer.id_pppoe, data_customer.alamat_customer, data_customer.email_customer, 
                DAY(data_customer.start_date) as tanggal, data_customer.stop_date, data_customer.nama_area, data_customer.deskripsi_customer, data_customer.nama_sales, data_customer.disabled, 
                data_customer.kode_mikrotik,
                data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
                data_pembayaran.nama_admin, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
                data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
                data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_paket.nama_paket as namaPaket, data_paket.harga_paket
        
                FROM data_customer
                LEFT JOIN data_paket ON data_customer.nama_paket = data_paket.nama_paket
                LEFT JOIN data_pembayaran ON data_customer.name_pppoe = data_pembayaran.name_pppoe
                AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
        
                WHERE data_customer.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
                data_pembayaran.transaction_time IS NULL AND data_customer.stop_date IS NULL AND data_customer.kode_mikrotik = 'Kraksaan'
        
                GROUP BY data_customer.name_pppoe
                ORDER BY data_customer.nama_customer ASC
                ")->result_array();

        foreach ($getData as $data) {
            date_default_timezone_set("Asia/Jakarta");
            $day = date("d");

            if ($day == '12') {
                if ($data['transaction_time'] == null && $data['status_code'] == null) {
                    // disable secret dan active otomatis 
                    $api = connectPaiton();
                    $api->comm('/ppp/secret/set', [
                        ".id" => $data['id_pppoe'],
                        "disabled" => 'true',
                    ]);

                    // disable active otomatis
                    $ambilid = $api->comm("/ppp/active/print", ["?name" => $data['name_pppoe']]);
                    $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
                    $api->disconnect();
                }
            } else {
                echo "Belum tanggal 11";
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
        data_customer.stop_date IS NULL AND data_customer.disabled = 'true' AND 
        data_pembayaran.transaction_time IS NOT NULL

        GROUP BY data_customer.name_pppoe
        ORDER BY data_customer.nama_customer ASC
        ")->result_array();

        foreach ($getData as $data) {
            date_default_timezone_set("Asia/Jakarta");
            $currentDate = date('d');

            if ($currentDate == '11') {
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
}
