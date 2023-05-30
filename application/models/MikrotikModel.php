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
            'HOME 5' => 1, 'HOME 10 A' => 2, 'HOME 10 B' => 2,
            'HOME 20 A' => 3, 'HOME 20 B' => 3, 'HOME 30 A' => 4,
            'HOME 30 B' => 4, 'HOME 50 A' => 5, 'HOME 50 B' => 5,
            'HOME 100' => 6, 'HOME TV 25' => 8, 'HOME TV 70' => 9,
            'HOME 2' => 10
        );

        $getData = $this->db->query("
            SELECT 
            data_customer.*,
            data_area.nama_area as area_name, 
            data_paket.id_paket as id_paket, 
            data_paket.harga_paket as paket_price, 
            data_sales.nama_sales as sales_name
            FROM data_customer
            left join data_area on data_area.id_area = data_customer.id_area
            left join data_paket on data_paket.id_paket = data_customer.id_paket
            left join data_sales on data_sales.id_sales = data_customer.id_sales
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
                        'id_paket'          => $paket[(string)$valueSecret['profile']],
                        'name_pppoe'        => $valueSecret['name'],
                        'password_pppoe'    => $valueSecret['password'],
                        'id_pppoe'          => $valueSecret['.id'],
                        'alamat_customer'   => $value['alamat_customer'],
                        'email_customer'    => $value['email_customer'],
                        'start_date'        => $value['start_date'],
                        'stop_date'         => $value['stop_date'],
                        'id_area'           => $value['id_area'],
                        'deskripsi_customer' => $value['deskripsi_customer'],
                        'id_sales'          => $value['id_sales'],
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
                    "id_paket"          => $paket[(string)$valueSecret['profile']],
                    'name_pppoe'        => $valueSecret['name'],
                    'password_pppoe'    => $valueSecret['password'],
                    'id_pppoe'          => $valueSecret['.id'],
                    'alamat_customer'   => '0',
                    'email_customer'    => '0',
                    "start_date"        => NULL,
                    "stop_date"         => NULL,
                    "id_area"           => 0,
                    "deskripsi_customer" => '0',
                    "id_sales"          => 0,
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
                    'id_paket'          => $paket[(string)$valueSecret['profile']],
                    'name_pppoe'        => $valueSecret['name'],
                    'password_pppoe'    => $valueSecret['password'],
                    'id_pppoe'          => $valueSecret['.id'],
                    'alamat_customer'   => '0',
                    'email_customer'    => '0',
                    'start_date'        => NULL,
                    'stop_date'         => null,
                    'id_area'           => '0',
                    'deskripsi_customer' => '0',
                    'id_sales'          => '0',
                    'created_at'        => date('Y-m-d H:i:s', time()),
                    'updated_at'        => date('Y-m-d H:i:s', time()),
                    'disabled'          => $valueSecret['disabled'],
                ];
            }
        }

        return $response;
    }
}
