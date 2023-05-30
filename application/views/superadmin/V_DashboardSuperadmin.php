<div id="layoutSidenav_content">
    <main>
        <div id="preloader">
            <div id="ctn-preloader" class="ctn-preloader">
                <div class="animation-preloader">
                    <div class="txt-loading">
                        <div class="lingkaran">
                            <img src="<?php echo base_url(); ?>assets/img/GIFloading.gif" alt="">
                        </div>

                        <span data-text-preloader="#" class="letters-loading">
                            #
                        </span>
                        <span data-text-preloader="I" class="letters-loading">
                            I
                        </span>
                        <span data-text-preloader="N" class="letters-loading">
                            N
                        </span>
                        <span data-text-preloader="F" class="letters-loading">
                            F
                        </span>
                        <span data-text-preloader="L" class="letters-loading">
                            L
                        </span>
                        <span data-text-preloader="Y" class="letters-loading">
                            Y
                        </span>
                        <span data-text-preloader="A" class="letters-loading">
                            A
                        </span>
                        <span data-text-preloader="J" class="letters-loading">
                            J
                        </span>
                        <span data-text-preloader="A" class="letters-loading">
                            A
                        </span>
                    </div>
                </div>
                <div class="loader-section section-left"></div>
                <div class="loader-section section-right"></div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <!-- customer new -->
                <div class="col-xl-3 col-sm-6 mt-3">
                    <div class="card bg-primary text-white mb-4">
                        <div class="row">
                            <div class="col-10">
                                <div class="card-body">Customer New</div>
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column">
                                <div class="card-body"><i class="fa fa-user fa-1x" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo base_url('admin/DataPelanggan/DataPelanggan') ?>">
                                <!-- <h3><?php echo $registrasiNew ?></h3> -->
                            </a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <!-- customer aktif -->
                <div class="col-xl-3 col-sm-6 mt-3">
                    <div class="card bg-success text-white mb-4">
                        <div class="row">
                            <div class="col-10">
                                <div class="card-body">Customer Aktif</div>
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column">
                                <div class="card-body"><i class="fa fa-user fa-1x" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo base_url('admin/DataPelanggan/DataPelanggan') ?>">
                                <!-- <h3><?php echo $customerKBS ?></h3> -->
                            </a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <!-- customer lunas -->
                <div class="col-xl-3 col-sm-6 mt-3">
                    <div class="card bg-info text-white mb-4">
                        <div class="row">
                            <div class="col-10">
                                <div class="card-body">Customer Lunas</div>
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column">
                                <div class="card-body"><i class="fa fa-user fa-1x" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo base_url('admin/DataPelanggan/DataPelangganSudahBayar') ?>">
                                <!-- <h3><?php echo $sudahBayar ?></h3> -->
                            </a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <!-- customer jatuh tempo -->
                <div class="col-xl-3 col-sm-6 mt-3">
                    <div class="card bg-danger text-white mb-4">
                        <div class="row">
                            <div class="col-10">
                                <div class="card-body">Customer Jatuh Tempo</div>
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column">
                                <div class="card-body"><i class="fa fa-user fa-1x" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo base_url('admin/DataPelanggan/ExpiredPelanggan') ?>">
                                <!-- <h3><?php echo $jatuhTempo ?></h3> -->
                            </a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </main>