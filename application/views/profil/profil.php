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
            <form id="ubah_profil" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card">
                    <div class="card-list p-3">
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Profil Saya</div>
                                <div class="card-category mt-0">Pastikan data yang anda lengkapi benar dan masih aktif</div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Kode</label>
                                            <input type="text" class="form-control" name="kode" placeholder="kode" value="<?= $account['kode']; ?>" style="background: transparent !important;opacity: 1 !important;" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?= $account['nama']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $account['email']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" value="<?= $account['tempat_lahir']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Tgl. Lahir</label>
                                            <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Tgl. Lahir" value="<?= date_format(date_create($account['tgl_lahir']),"d-m-Y"); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender">
                                                <option value="1" <?= $account['gender'] == 1 ? 'selected' : '' ?>>Laki-Laki</option>
                                                <option value="0" <?= $account['gender'] == 0 ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>No. Hp</label>
                                            <input type="text" class="form-control" name="telp" placeholder="telp" value="<?= $account['telp']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group form-group-default">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control" name="alamat" placeholder="Alamat" value="<?= $account['alamat']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Nama Bank</label>
                                            <input type="text" class="form-control" name="nama_bank" placeholder="Nama Bank" value="<?= $account['nama_bank']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Nama Rek</label>
                                            <input type="text" class="form-control" name="nama_rek" placeholder="Nama Rek" value="<?= $account['nama_rek']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>No. Rek</label>
                                            <input type="text" class="form-control" name="no_rek" placeholder="No. Rek" value="<?= $account['no_rek']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-right p-3">
                        <input type="submit" id="edit_profile" class="btn btn-secondary" value="Simpan">
                    </div>
                </div>
            </form>
            
            <form id="form_edit_password" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card">
                    <div class="card-list p-3">
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Ubah Password</div>
                                <div class="card-category mt-0">Anda dapat mengubah kata sandi sesuai keinginan Anda</div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Password Baru</label>
                                            <input type="password" class="form-control" name="new_password1" placeholder="Password Baru">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Ulangi Password</label>
                                            <input type="password" class="form-control" name="new_password2" placeholder="Ulangi Password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action text-right p-3">
                        <button class="btn btn-secondary" id="simpan_password">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="mx-auto d-block">
                        <?php
                            if($account['foto'] == NULL || $account['foto'] == ''){ $photo = 'profile.jpg'; }
                            else{ $photo = $account['foto']; }
                        ?>
                        <img class="rounded-circle mx-auto d-block" src="<?= base_url() ?>assets/img/photo/<?= $photo; ?>" id="imgx" alt="Photo profile" width="180" height="180">
                    </div>
                    <hr>
                    <div class="card-text">
                        <form id="form_photo" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="input-group">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="profile_image">Pilih foto...</label>
                                    <input type="file" accept=".jpg, .jpeg, .png" class="custom-file-input" id="profile_image" name="profile_image" 
                                        onchange="imgx.src=window.URL.createObjectURL(this.files[0])"style="display:none" required>
                                </div>
                                <div class="input-group-append" style="margin-left:-75px">
                                    <button class="btn btn-secondary" id="ganti_foto" style="padding:0 8px 0 8px; height:calc(2.25rem + 2px)">Ubah Foto</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
