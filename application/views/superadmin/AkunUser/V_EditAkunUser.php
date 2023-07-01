<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Edit Akun</b>
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
                        <?php foreach ($DataAkun as $data) : ?>
                            <form method="POST" action="<?php echo base_url('superadmin/AkunUser/C_EditAkunUser/EditAkunSave') ?>">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id_penagih" id="id_penagih" value="<?php echo $data['id_penagih'] ?>" readonly>
                                </div>
                                <!-- Email Login -->
                                <div class="row mt-3">
                                    <div class="col-sm-12">
                                        <label for="email_login" class="form-label" style="font-weight: bold;"> Email_login : <span class="text-danger">*</span></label>
                                        <select name="email_login" id="email_login" class="form-control" required>
                                            <?php foreach ($DataLogin as $dataLogin) : ?>
                                                <option value="">Pilih Paket :</option>
                                                <option value="<?php echo $dataLogin['email_login'] ?>" <?= $data['email_login'] == $dataLogin['email_login'] ? "selected" : null ?>><?php echo $dataLogin['email_login'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Email Login -->

                                <!-- Nama Area -->
                                <div class="row mt-3">
                                    <div class="col-sm-3">
                                        <label for="area_1" class="form-label" style="font-weight: bold;"> Area 1 : <span class="text-danger">*</span></label>
                                        <select id="area_1" name="area_1" class="form-control" required>
                                            <option value="">Pilih Area :</option>
                                            <?php foreach ($DataArea as $dataArea) : ?>
                                                <option value="">Pilih Area :</option>
                                                <option value="<?php echo $dataArea['nama_area'] ?>" <?= $data['area_1'] == $dataArea['nama_area'] ? "selected" : null ?>><?php echo $dataArea['nama_area'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="area_2" class="form-label" style="font-weight: bold;"> Area 2 : <span class="text-danger">*</span></label>
                                        <select id="area_2" name="area_2" class="form-control">
                                            <option value="">Pilih Area :</option>
                                            <?php foreach ($DataArea as $dataArea) : ?>
                                                <option value="">Pilih Area :</option>
                                                <option value="<?php echo $dataArea['nama_area'] ?>" <?= $data['area_2'] == $dataArea['nama_area'] ? "selected" : null ?>><?php echo $dataArea['nama_area'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="area_3" class="form-label" style="font-weight: bold;"> Area 3 : <span class="text-danger">*</span></label>
                                        <select id="area_3" name="area_3" class="form-control">
                                            <option value="">Pilih Area :</option>
                                            <?php foreach ($DataArea as $dataArea) : ?>
                                                <option value="">Pilih Area :</option>
                                                <option value="<?php echo $dataArea['nama_area'] ?>" <?= $data['area_3'] == $dataArea['nama_area'] ? "selected" : null ?>><?php echo $dataArea['nama_area'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="area_4" class="form-label" style="font-weight: bold;"> Area 4 : <span class="text-danger">*</span></label>
                                        <select id="area_4" name="area_4" class="form-control">
                                            <option value="">Pilih Area :</option>
                                            <?php foreach ($DataArea as $dataArea) : ?>
                                                <option value="">Pilih Area :</option>
                                                <option value="<?php echo $dataArea['nama_area'] ?>" <?= $data['area_4'] == $dataArea['nama_area'] ? "selected" : null ?>><?php echo $dataArea['nama_area'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="area_5" class="form-label" style="font-weight: bold;"> Area 5 : <span class="text-danger">*</span></label>
                                        <select id="area_5" name="area_5" class="form-control">
                                            <option value="">Pilih Area :</option>
                                            <?php foreach ($DataArea as $dataArea) : ?>
                                                <option value="">Pilih Area :</option>
                                                <option value="<?php echo $dataArea['nama_area'] ?>" <?= $data['area_5'] == $dataArea['nama_area'] ? "selected" : null ?>><?php echo $dataArea['nama_area'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Nama Area -->

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