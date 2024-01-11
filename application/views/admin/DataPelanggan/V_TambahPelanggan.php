<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="fw-bold fs-4">Tambah Pelanggan</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('admin/DataPelanggan/C_DataPelanggan') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header bg-primary fw-bold fs-5 text-white">
                    <i class="fas fa-table me-1"></i>
                    Data Pelanggan
                </div>
                <div class="card-body">
                    <div class="container">

                        <form method="POST" action="<?php echo base_url('admin/DataPelanggan/C_TambahPelanggan/TambahPelangganSave') ?>">

                            <div class="row">
                                <input type="hidden" class="form-control fw-bold" name="order_id" id="order_id" value="<?php echo $this->M_BelumLunas->invoice() ?>" readonly>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="nama_customer" class="form-label fw-bold fs-5"> Nama Pelanggan : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-person-bounding-box text-white"></i></span>
                                        <input type="text" class="form-control fw-bold" name="nama_customer" id="nama_customer" value="" placeholder="Masukkan Nama pelanggan...">
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('nama_customer'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="start_date" class="form-label fw-bold fs-5"> Tanggal Registrasi : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-calendar-check-fill text-white"></i></span>
                                        <input type="date" class="form-control fw-bold" name="start_date" id="start_date" value="">
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('start_date'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="kode_customer" class="form-label fw-bold fs-5"> Kode Pelanggan : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                        <input type="text" class="form-control fw-bold" name="kode_customer" id="kode_customer" value="" placeholder="Masukkan Kode Pelanggan...">
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('kode_customer'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="name_pppoe" class="form-label fw-bold fs-5"> Name PPPOE : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-person-bounding-box text-white"></i></span>
                                        <input type="text" class="form-control fw-bold" name="name_pppoe" id="name_pppoe" value="" placeholder="Masukkan Name PPPOE...">
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('name_pppoe'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="password_pppoe" class="form-label fw-bold fs-5"> Password PPPOE : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-eye-fill text-white"></i></span>
                                        <input type="text" class="form-control fw-bold" name="password_pppoe" id="password_pppoe" value="" placeholder="Masukkan Password PPPOE...">
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('password_pppoe'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="phone_customer" class="form-label fw-bold fs-5"> No. Telepon : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-telephone-fill text-white"></i></span>
                                        <input type="text" class="form-control fw-bold" name="phone_customer" id="phone_customer" value="" placeholder="Masukkan No Telepon...">
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('phone_customer'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="nama_paket" class="form-label fw-bold fs-5"> Paket Internet : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-wifi text-white"></i></span>
                                        <select id="nama_paket" name="nama_paket" class="form-control fw-bold" required>
                                            <option value="">Pilih Paket :</option>
                                            <?php foreach ($DataPaket as $dataPaket) : ?>
                                                <option value="<?php echo $dataPaket['nama_paket']; ?>">
                                                    <?php echo $dataPaket['nama_paket']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('nama_paket'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="nama_area" class="form-label fw-bold fs-5"> Kode Area : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                        <select id="nama_area" name="nama_area" class="form-control fw-bold" required>
                                            <option value="">Pilih Area :</option>
                                            <?php foreach ($DataArea as $dataArea) : ?>
                                                <option value="<?php echo $dataArea['nama_area']; ?>">
                                                    <?php echo $dataArea['nama_area']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_area'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4 mt-4">
                                    <label for="nama_sales" class="form-label fw-bold fs-5"> Sales : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-person-circle text-white"></i></span>
                                        <select id="nama_sales" name="nama_sales" class="form-control fw-bold" required>
                                            <option value="">Pilih Sales :</option>
                                            <?php foreach ($DataSales as $dataSales) : ?>
                                                <option value="<?php echo $dataSales['nama_sales']; ?>">
                                                    <?php echo $dataSales['nama_sales']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_sales'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-lg-6 mt-4">
                                    <label for="email_customer" class="form-label fw-bold fs-5"> Email Pelanggan : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-envelope-at-fill text-white"></i></span>
                                        <input type="text" class="form-control fw-bold" name="email_customer" id="email_customer" value="" placeholder="Masukkan Email Pelanggan...">
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('email_customer'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 mt-4">
                                    <label for="" class="form-label fw-bold fs-5"> Area Mikrotik : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                        <select id="nama_DaerahMikrotik" name="nama_DaerahMikrotik" class="form-control fw-bold" required>
                                            <option value="">Pilih Sales :</option>
                                            <?php foreach ($DaerahMikrotik as $daerahMikrotik) : ?>
                                                <option value="<?php echo $daerahMikrotik['nama_DaerahMikrotik']; ?>">
                                                    <?php echo $daerahMikrotik['nama_DaerahMikrotik']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_sales'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-lg-6 mt-4">
                                    <label for="alamat_customer" class="form-label fw-bold fs-5">Alamat Pelanggan : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-house-fill text-white"></i></span>
                                        <textarea class="form-control fw-bold" name="alamat_customer" id="alamat_customer" cols="10" rows="3" placeholder="Masukkan Alamat Pelanggan..."></textarea>
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('alamat_customer'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 mt-4">
                                    <label for="deskripsi_customer" class="form-label fw-bold fs-5">Keterangan : <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                        <textarea class="form-control fw-bold" name="deskripsi_customer" id="deskripsi_customer" cols="10" rows="3" placeholder="Masukkan Keterangan..."></textarea>
                                    </div>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('deskripsi_customer'); ?></small>
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