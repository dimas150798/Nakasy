<?php
$months = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}
?>

<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas">Data Pelanggan</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn buttonmenuatas" href="<?php echo base_url('admin/DataPelanggan/C_TambahPelanggan') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/plus-circle.svg" alt="Bootstrap" ...> Tambah Pelanggan
                    </a>
                    <a class="btn buttonmenuatas" href="<?php echo base_url('admin/DataPelanggan/C_ImportExcel') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/file-earmark-excel-fill.svg" alt="Bootstrap" ...> Import Excel
                    </a>
                    <a class="btn buttonmenuatas" href="<?php echo base_url('admin/DataPelanggan/C_ExportExcel') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/file-earmark-excel-fill.svg" alt="Bootstrap" ...> Export Excel
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 mt-3">
                    <div class="textPencarian">
                        <div class="row">
                            <div class="col-6">
                                <p class="dataPencarian">Total Customer</p>
                            </div>
                            <div class="col-6">
                                <p class="dataPencarian">:
                                    <?php echo $JumlahPelanggan; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h5 class="text-center font-weight-light mt-2 mb-2">
                        <?php echo $this->session->flashdata('pesan'); ?>
                    </h5>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header">

                            <h3><i class="fas fa-table me-1"></i>
                                Data Pelanggan
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Customer</th>
                                        <th>Name PPPOE</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Nama Paket</th>
                                        <th class="text-center">Date Registrasi</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </main>