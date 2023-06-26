<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Edit Paket</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('admin/DataPaket/C_DataPaket') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Paket
                </div>
                <div class="card-body">
                    <div class="container">
                        <?php foreach ($DataPaket as $data) : ?>
                            <form method="POST" action="<?php echo base_url('admin/DataPaket/C_EditPaket/EditPaketSave') ?>">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id_paket" value=" <?php echo $data['id_paket'] ?>" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 mt-3">
                                        <label for="nama_paket" class="form-label" style="font-weight: bold;"> Nama Paket : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_paket" value="<?php echo $data['nama_paket'] ?>" placeholder="Masukkan nama paket..." readonly>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('nama_paket'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="harga_paket" class="form-label" style="font-weight: bold;"> Harga Paket : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="harga_paket" value="<?php echo $data['harga_paket'] ?>" placeholder="Masukkan harga paket...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('harga_paket'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="deskripsi_paket" class="form-label" style="font-weight: bold;"> Deskripsi Paket : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="deskripsi_paket" value="<?php echo $data['deskripsi_paket'] ?>" placeholder="Masukkan deskripsi...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('deskripsi_paket'); ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success mt-2 justify-content-end"><i class="bi bi-plus-circle"></i> Simpan</button>
                                    </div>
                                </div>

                            </form>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>

    </main>