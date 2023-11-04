<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas">Tambah Pelanggan</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
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

                        <form method="POST" action="<?php echo base_url('admin/DataPelanggan/C_TambahPelanggan/TambahPelangganSave') ?>">

                            <div class="row">
                                <input type="hidden" class="form-control" name="order_id" id="order_id" value="<?php echo $this->M_BelumLunas->invoice() ?>" readonly>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 mt-3">
                                    <label for="nama_customer" class="form-label" style="font-weight: bold;"> Nama : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_customer" id="nama_customer" value="" placeholder="Masukkan nama pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('nama_customer'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="start_date" class="form-label" style="font-weight: bold;"> Tanggal Registrasi : <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('start_date'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="kode_customer" class="form-label" style="font-weight: bold;"> Kode Pelanggan : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kode_customer" id="kode_customer" value="" placeholder="Masukkan kode pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('kode_customer'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 mt-3">
                                    <label for="name_pppoe" class="form-label" style="font-weight: bold;"> Name PPPOE : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_pppoe" id="name_pppoe" value="" placeholder="Masukkan nama pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('name_pppoe'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="password_pppoe" class="form-label" style="font-weight: bold;"> Password PPPOE : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="password_pppoe" id="password_pppoe" value="" placeholder="Masukkan nama pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('password_pppoe'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="phone_customer" class="form-label" style="font-weight: bold;"> No. Telephone : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone_customer" id="phone_customer" value="" placeholder="Masukkan nama pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('phone_customer'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 mt-3">
                                    <label for="nama_paket" class="form-label" style="font-weight: bold;"> Paket : <span class="text-danger">*</span></label>
                                    <select id="nama_paket" name="nama_paket" class="form-control" required>
                                        <option value="">Pilih Paket :</option>
                                        <?php foreach ($DataPaket as $dataPaket) : ?>
                                            <option value="<?php echo $dataPaket['nama_paket']; ?>">
                                                <?php echo $dataPaket['nama_paket']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('nama_paket'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="nama_area" class="form-label" style="font-weight: bold;"> Kode DP dan Area : <span class="text-danger">*</span></label>
                                    <select id="nama_area" name="nama_area" class="form-control" required>
                                        <option value="">Pilih Area :</option>
                                        <?php foreach ($DataArea as $dataArea) : ?>
                                            <option value="<?php echo $dataArea['nama_area']; ?>">
                                                <?php echo $dataArea['nama_area']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_area'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="nama_sales" class="form-label" style="font-weight: bold;"> Sales : <span class="text-danger">*</span></label>
                                    <select id="nama_sales" name="nama_sales" class="form-control" required>
                                        <option value="">Pilih Sales :</option>
                                        <?php foreach ($DataSales as $dataSales) : ?>
                                            <option value="<?php echo $dataSales['nama_sales']; ?>">
                                                <?php echo $dataSales['nama_sales']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_sales'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mt-3">
                                    <label for="email_customer" class="form-label" style="font-weight: bold;"> Email : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email_customer" id="email_customer" value="" placeholder="Masukkan email pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('email_customer'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label for="" class="form-label" style="font-weight: bold;"> Area Mikrotik : <span class="text-danger">*</span></label>
                                    <select id="nama_DaerahMikrotik" name="nama_DaerahMikrotik" class="form-control" required>
                                        <option value="">Pilih Sales :</option>
                                        <?php foreach ($DaerahMikrotik as $daerahMikrotik) : ?>
                                            <option value="<?php echo $daerahMikrotik['nama_DaerahMikrotik']; ?>">
                                                <?php echo $daerahMikrotik['nama_DaerahMikrotik']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_sales'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mt-3">
                                    <label for="alamat_customer" class="form-label" style="font-weight: bold;">Alamat : <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="alamat_customer" id="alamat_customer" cols="10" rows="4"></textarea>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('alamat_customer'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label for="deskripsi_customer" class="form-label" style="font-weight: bold;">Keterangan : <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="deskripsi_customer" id="deskripsi_customer" cols="10" rows="4"></textarea>
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