<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Data Sales</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn buttonmenuatas" href="<?php echo base_url(); ?>admin/DataSales/C_TambahSales"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/plus-circle.svg" alt="Bootstrap" ...> Tambah Data Akses
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">

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
                                Data Sales
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="datatablesdekstop" class="table table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%">Nama</th>
                                        <th width="30%" class="text-center">Telephone</th>
                                        <th width="30%" class="text-center">Jabatan</th>
                                        <th width="5%" class="text-center">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($DataSales as $data) :
                                    ?>

                                        <tr>
                                            <td>
                                                <?php echo $no++ ?>
                                            </td>

                                            <td>
                                                <?php echo $data['nama_sales'] ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo $data['phone_sales'] ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo $data['nama_jabatan'] ?>
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                                                        Opsi
                                                    </button>
                                                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                                                        <a class="dropdown-item text-black" href="<?php echo base_url('admin/DataSales/C_EditSales/EditSales/' . $data['id_sales']) ?>"><i class="bi bi-pencil-square"></i> Edit</a>
                                                        <a onclick="return confirm('Yakin Menghapus Data')" class="dropdown-item text-black" href="<?php echo base_url('admin/DataSales/C_DeleteSales/DeleteSales/' . $data['id_sales']) ?>"><i class="bi bi-trash3-fill"></i> Hapus</a>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </main>