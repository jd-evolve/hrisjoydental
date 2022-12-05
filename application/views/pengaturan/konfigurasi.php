<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title"><?= $title ?></h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="<?= base_url('dashboard') ?>">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href=""><?= $title ?></a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md">
            <form id="form-konfigurasi" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card">
                    <div class="card-list p-3">
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Setting Ijin/Cuti</div>
                                <div class="card-category">Menyesuaikan potongan cuti dari masing-masing ijin/cuti</div>
                                <div class="form-group">
                                    <label class="lbl-color">Cuti Tahunan</label>
                                    <input type="number" name="cuti_tahunan" step="0.1" min="0" class="form-control" placeholder="0" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">Cuti Menikah</label>
                                    <input type="number" name="cuti_menikah" step="0.1" min="0" class="form-control" placeholder="0" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">Cuti Melahirkan</label>
                                    <input type="number" name="cuti_melahirkan" step="0.1" min="0" class="form-control" placeholder="0" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">Ijin Pribadi</label>
                                    <input type="number" name="ijin_pribadi" step="0.1" min="0" class="form-control" placeholder="0" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">Ijin Duka</label>
                                    <input type="number" name="ijin_duka" step="0.1" min="0" class="form-control" placeholder="0" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">Ijin Dinak Keluar</label>
                                    <input type="number" name="ijin_sakit" step="0.1" min="0" class="form-control" placeholder="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Email Lupa Password</div>
                                <div class="card-category">Konfigurasi email admin untuk mengirim pesan lupa password.</div>
                                <div class="form-group">
                                    <label class="lbl-color">smtp_host</label>
                                    <input type="text" class="form-control" name="smtp_host" placeholder="smtp.domain.com" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">smtp_port</label>
                                    <input type="text" class="form-control" name="smtp_port" placeholder="465" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">smtp_user</label>
                                    <input type="text" class="form-control" name="smtp_user" placeholder="user@email" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">smtp_pass</label>
                                    <input type="text" class="form-control" name="smtp_pass" placeholder="password" required>
                                </div>
                                <div class="form-group">
                                    <label class="lbl-color">initial_name</label>
                                    <input type="text" class="form-control" name="initial_name" placeholder="username" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-right p-3">
                        <button class="btn btn-secondary btn-sm px-3" type="submit" id="simpan_konfigurasi">
                            <span class="btn-label mr-2"><i class="fa fa-plus"></i></span>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <div class="card-title fw-bold">Online Account</div>
                    <p class="card-category" style="line-height: 1.5;">Menampilkan seluruh daftar account yang sedang aktif.</p>
                    <a id="logout_all_account" class="btn btn-danger btn-sm mt-3 px-4 text-white">Keluarkan semua akun</a>
                </div>
                <div class="tableBodyScroll mb-3">
                    <div class="card-body py-0">
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