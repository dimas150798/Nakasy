<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas">Upload Pelanggan</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-warning text-white" href="<?php echo base_url() ?>assets/export/DataPelanggan.xlsx"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/file-earmark-excel-fill.svg" alt="Bootstrap" ...> Template Excel
                    </a>
                    <a class="btn bg-danger text-white" href="<?php echo base_url('admin/DataPelanggan/C_DataPelanggan') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Pelanggan
                </div>
                <div class="card-body">
                    <div class="container">

                        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/DataPelanggan/C_ImportExcel/ImportExcel') ?>">

                            <div class="row mt-2 justify-content-center">
                                <div class="col-sm-5">
                                    <label for="nama_customer" class="form-label" style="font-weight: bold;"> Import File : <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="upload_excel" id="nama_customer" value="" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-success mt-2 justify-content-end"><i class="bi bi-plus-circle"></i> Simpan</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </main>