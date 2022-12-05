<div class="page-inner">
    <div class="row mt-2">
        <div class="col-md">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="d-flex">
                                        <?php
                                            if($account['foto'] == NULL || $account['foto'] == ''){ $photo = 'profile.jpg'; }
                                            else{ $photo = $account['foto']; }
                                        ?>
                                        <div class="avatar avatar-lg">
                                            <img src="<?= base_url() ?>assets/img/photo/<?= $photo; ?>" alt="..." class="avatar-img rounded-circle" style="width:4rem !important; height:4rem !important;">
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="mt-3 mb-0 fw-bold"><?= $account['nama'] ?></h4>
                                            <p class="mb-0 text-grey"><?= $posisi['nama_posisi'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" style="min-width: 110px !important; margin-top:16px">
                                    <a href="<?= base_url('profil') ?>" class="btn btn-info btn-border btn-round btn-sm btn-block">Edit Profile</a>
                                </div>
                            </div>
                            <div class="card-footer mt-3 p-0 pt-2" style="line-height:20px;">
                                <small class="text-grey"><i class="flaticon-chat-5 mr-1"></i><?= $account['telp'] ?></small><br>
                                <small class="text-grey"><i class="flaticon-envelope-1 mr-1"></i><?= $account['email'] ?></small><br>
                                <small class="text-grey"><i class="flaticon-credit-card mr-1"></i><?= $account['nama_bank'] ?> | <?= $account['nama_rek'] ?> | <?= $account['no_rek'] ?></small><br>
                                <small class="text-grey"><i class="flaticon-home mr-1"></i><?= $account['alamat'] ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-dark bg-secondary-gradient shadow text-white" style="min-height:190px;">
                        <div class="card-body bubble-shadow">
                            <h5>Klinik Gigi Joy Dental <?= $cabang['nama_cabang'] ?></h5>
                            <h2 class="py-4 mb-0"><?= $account['nomor_induk'] ?></h2>
                            <div class="row">
                                <div class="col-8 pr-0">
                                    <div class="text-small fw-bold op-8">Mulai Kerja : <?= date_format(date_create($account['tgl_kerja']),"d F Y") ?></div>
                                    <?php $masa_kerja = date_diff(date_create($account['tgl_kerja']),date_create(date("Y-m-d"))); ?>
                                    <h3 class="fw-bold mb-0 mt-1"><?= ($masa_kerja->y).' Thn, '.($masa_kerja->m).' Bln' ?></h3>
                                </div>
                                <div class="col-4 pl-0 text-right">
                                    <div class="text-small text-uppercase fw-bold op-8 mt-2">Status</div>
                                    <h3 class="fw-bold"><?= $account['status'] == 1 ? 'Aktif' : 'Evaluasi' ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-info bg-info-gradient shadow">
                        <div class="card-body">
                            <h4 class="mb-1 fw-bold">Sisa Cuti</h4>
                            <div id="task-complete" class="chart-circle mt-3" style="margin-bottom: 12.5px;">
                                <div class="circles-wrp" style="position: relative; display: inline-block;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100">
                                        <path fill="transparent" stroke="#36a3f7" stroke-width="5" d="M 49.99032552282448 2.500000985215891 A 47.5 47.5 0 1 1 49.9340234529416 2.5000458200722235 Z" class="circles-maxValueStroke"></path>
                                        <path fill="transparent" stroke="#fff" stroke-width="5" d="M 49.99032552282448 2.500000985215891 A 47.5 47.5 0 1 1 4.81379135029583 35.355664990673006 " class="circles-valueStroke"></path>
                                    </svg>
                                    <div class="circles-text" style="position: absolute; top: 0px; left: 0px; text-align: center; width: 100%; font-size: 35px; height: 100px; line-height: 100px;">
                                        <?= floatval($account['sisa_cuti']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="btn-group border-option form-filter" style="margin-bottom: 30px !important;">
                        <label class="label-filter">Periode: </label>&nbsp;&nbsp;
                        <input type="hidden" name="start-date" value="">
                        <input type="hidden" name="end-date" value="">
                        <div class="btn-block">
                            <div style="width:100%">
                                <input type="text" class="form-control input-full pointer" id="bulan1" name="bulan1" style="background: white !important; opacity: 1 !important" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-info mr-3">
                                <i class="fa fa-magic"></i>
                            </span>
                            <div>
                                <h5 class="mb-1"><b>Izin Kerja</b></h5>
                                <small class="text-muted"><span class="fw-bold">12</span> izin kerja</small>
                            </div>
                        </div>
                    </div>
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-warning mr-3">
                                <i class="fa fa-magic"></i>
                            </span>
                            <div>
                                <h5 class="mb-1"><b>Cuti Kerja</b></h5>
                                <small class="text-muted"><span class="fw-bold">12</span> cuti kerja</small>
                            </div>
                        </div>
                    </div>
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-danger mr-3">
                                <i class="fa fa-magic"></i>
                            </span>
                            <div>
                                <h5 class="mb-1"><b>Ijin Sakit</b></h5>
                                <small class="text-muted"><span class="fw-bold">12</span> ijin sakit</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title fw-mediumbold">Online Account</div>
                            <div class="tableBodyScroll mb-3" style="height: 267.8px;">
                                <div class="card-list">
                                    <?php foreach ($account_online as $list) { ?>
                                        <div class="item-list py-2">
                                            <div class="avatar avatar-online">
                                                <img src="<?= base_url().'assets/img/photo/'.$list->foto ?>" alt="..." class="avatar-img rounded-circle">
                                            </div>
                                            <div class="info-user mx-3">
                                                <div class="fw-bold mb-1"><?= $list->nama ?></div>
                                                <div class="status"><?= $list->email ?></div>
                                            </div>
                                            <div class="d-flex ml-auto align-items-center">
                                                <p class="text-info fw-bold"><?= $list->kode_cabang ?></p>
                                            </div>
                                        </div>
                                        <div class="separator-dashed m-0"></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div id="calendar" class="text-center"></div>
                    <div class="card-title fw-mediumbold mt-2">Kegiatan</div>
                    
                    <div class="tableBodyScroll" style="height: 150px;">
                        <ol class="activity-feed" id="list_kegiatan">
                        </ol>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="min-height: 244px;">
                    <p class="card-category text-warning mb-1 mt-0">Warning!</p>
                    <h3 class="card-title">Hubungi Personalia!</h3>
                    <p class="card-text">Anda dapat menghubungi bagian personalia untuk melakukan konfirmasi atau mengubah data pribadi anda.</p>
                    <a href="#" class="btn btn-success btn-rounded btn-sm"><span class="btn-label"><i class="fab fa-whatsapp mr-1"></i></span>Whatsapp</a>
                </div>
            </div>
        </div>
    </div>
</div>