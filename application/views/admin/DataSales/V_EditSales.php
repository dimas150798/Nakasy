<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Edit Sales</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('admin/DataSales/C_DataSales') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Sales
                </div>
                <div class="card-body">
                    <div class="container">
                        <?php foreach ($DataSales as $data) : ?>
                            <form method="POST" action="<?php echo base_url('admin/DataSales/C_EditSales/EditSalesSave') ?>">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id_sales" value=" <?php echo $data['id_sales'] ?>" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 mt-3">
                                        <label for="nama_sales" class="form-label" style="font-weight: bold;"> Nama : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_sales" value="<?php echo $data['nama_sales'] ?>" placeholder="Masukkan nama...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('nama_sales'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="phone_sales" class="form-label" style="font-weight: bold;"> Telephone : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="phone_sales" id="phone_sales" value="<?php echo $data['phone_sales'] ?>" placeholder="Masukkan phone...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('phone_sales'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="id_jabatan" class="form-label" style="font-weight: bold;"> Nama Jabatan : <span class="text-danger">*</span></label>
                                        <select id="id_jabatan" name="id_jabatan" class="form-control" required>
                                            <option value="">Pilih Jabatan :</option>
                                            <?php foreach ($DataJabatan as $dataJabatan) : ?>
                                                <option value="<?php echo $dataJabatan['id_jabatan'] ?>" <?= $data['id_jabatan'] == $dataJabatan['id_jabatan'] ? "selected" : null ?>>
                                                    <?php echo $dataJabatan['nama_jabatan'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('id_jabatan'); ?></small>
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