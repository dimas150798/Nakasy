<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="fw-bold fs-4">Pembayaran Pelanggan</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" onclick="history.back()"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
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

                        <?php foreach ($DataPelanggan as $data) : ?>
                            <form method="POST" action="<?php echo base_url('admin/BelumLunas/C_PayBelumLunas/PaymentSave') ?>">

                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" class="form-control fw-bold" name="id_customer" value="<?php echo $data['id_customer'] ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold" name="id_pppoe" value="<?php echo $data['id_pppoe'] ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold" name="id_pppoe_paiton" value="<?php echo $data['id_pppoe_paiton'] ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold" name="nama_paket" value="<?php echo $data['namaPaket'] ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold" name="gross_amount" value="<?php echo $data['harga_paket'] ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold" name="order_id" value="<?php echo $this->M_BelumLunas->invoice() ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold" name="kode_mikrotik" value="<?php echo $data['kode_mikrotik'] ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold" name="kode_mikrotik_paiton" value="<?php echo $data['kode_mikrotik_paiton'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-4 mt-4">
                                        <label for="nama_customer" class="form-label fw-bold fs-5"> Nama Customer : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-person-bounding-box text-white"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="nama_customer" id="nama_customer" value="<?php echo $data['nama_customer'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mt-4">
                                        <label for="name_pppoe" class="form-label fw-bold fs-5"> Name PPPOE : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-person-bounding-box text-white"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="name_pppoe" id="name_pppoe" value="<?php echo $data['name_pppoe'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mt-4">
                                        <label for="" class="form-label fw-bold fs-5"> Paket Internet : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-wifi text-white"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="" id="" value="<?php echo $data['namaPaket'] ?> / Rp. <?php echo number_format($data['harga_paket'], 0, ',', '.') ?> + PPN" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-lg-6 mt-4">
                                        <label for="biaya_admin" class="form-label fw-bold fs-5"> Biaya Admin : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-cash"></i></span>
                                            <select id="biaya_admin" name="biaya_admin" class="form-control fw-bold" required>
                                                <option value="">--- Pilih Biaya Admin ---</optxion>
                                                <option value="0">Rp. 0</option>
                                                <option value="3000">RP. 3000</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-4">
                                        <label for="transaction_time" class="form-label fw-bold fs-5"> Tanggal : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-calendar-check-fill text-white"></i></span>
                                            <input type="datetime-local" class="form-control fw-bold" name="transaction_time" id="transaction_time" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-4">
                                        <label for="nama_admin" class="form-label fw-bold fs-5"> Pembayaran Melalui : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-person-circle text-white"></i></span>
                                            <input type="text" class="form-control fw-bold" name="nama_admin" id="nama_admin" value="" placeholder="Masukkan Pembayaran Melalui...">
                                        </div>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('nama_admin'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-4">
                                        <label for="keterangan" class="form-label fw-bold fs-5"> Keterangan : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                            <input type="text" class="form-control fw-bold" name="keterangan" id="keterangan" value="" placeholder="Masukkan keterangan...">
                                        </div>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('keterangan'); ?></small>
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