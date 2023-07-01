<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Tambah Akun</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" onclick="history.back()"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Akun
                </div>
                <div class="card-body">
                    <div class="container">

                        <form method="POST" action="<?php echo base_url('superadmin/AkunUser/C_TambahAkunUser/TambahAkunSave') ?>">
                            <!-- Nama Akun  -->
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <label for="email_login" class="form-label" style="font-weight: bold;"> Nama Akun : <span class="text-danger">*</span></label>
                                    <select id="email_login" name="email_login" class="form-control" required>
                                        <option value="">Pilih Akun :</option>
                                        <?php foreach ($DataAkun as $dataAkun) : ?>
                                            <option value="<?php echo $dataAkun['email_login']; ?>">
                                                <?php echo $dataAkun['email_login']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_akses'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <!-- Nama Area -->
                            <div class="row mt-3">
                                <div class="col-sm-3">
                                    <label for="area_1" class="form-label" style="font-weight: bold;"> Area 1 : <span class="text-danger">*</span></label>
                                    <select id="area_1" name="area_1" class="form-control" required>
                                        <option value="">Pilih Area :</option>
                                        <?php foreach ($DataArea as $dataArea) : ?>
                                            <option value="<?php echo $dataArea['nama_area']; ?>">
                                                <?php echo $dataArea['nama_area']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_akses'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="area_2" class="form-label" style="font-weight: bold;"> Area 2 : <span class="text-danger">*</span></label>
                                    <select id="area_2" name="area_2" class="form-control">
                                        <option value="">Pilih Area :</option>
                                        <?php foreach ($DataArea as $dataArea) : ?>
                                            <option value="<?php echo $dataArea['nama_area']; ?>">
                                                <?php echo $dataArea['nama_area']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_akses'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="area_3" class="form-label" style="font-weight: bold;"> Area 3 : <span class="text-danger">*</span></label>
                                    <select id="area_3" name="area_3" class="form-control">
                                        <option value="">Pilih Area :</option>
                                        <?php foreach ($DataArea as $dataArea) : ?>
                                            <option value="<?php echo $dataArea['nama_area']; ?>">
                                                <?php echo $dataArea['nama_area']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_akses'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="area_4" class="form-label" style="font-weight: bold;"> Area 4 : <span class="text-danger">*</span></label>
                                    <select id="area_4" name="area_4" class="form-control">
                                        <option value="">Pilih Area :</option>
                                        <?php foreach ($DataArea as $dataArea) : ?>
                                            <option value="<?php echo $dataArea['nama_area']; ?>">
                                                <?php echo $dataArea['nama_area']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_akses'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="area_5" class="form-label" style="font-weight: bold;"> Area 5 : <span class="text-danger">*</span></label>
                                    <select id="area_5" name="area_5" class="form-control">
                                        <option value="">Pilih Area :</option>
                                        <?php foreach ($DataArea as $dataArea) : ?>
                                            <option value="<?php echo $dataArea['nama_area']; ?>">
                                                <?php echo $dataArea['nama_area']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_akses'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success mt-2 justify-content-end"><i class="bi bi-plus-circle"></i> Simpan</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </main>