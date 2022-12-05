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
            
            <form id="form_edit_password" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card">
                    <div class="card-list p-3">
                        <div class="item-list py-2">
                            <div class="info-user">
                                <div class="card-title">Ubah Password</div>
                                <div class="card-category mt-0">Anda dapat mengubah kata sandi sesuai keinginan Anda</div>
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="form-group form-group-default">
                                            <label>Password Baru</label>
                                            <input type="password" class="form-control" name="new_password1" placeholder="Password Baru">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group form-group-default">
                                            <label>Ulangi Password</label>
                                            <input type="password" class="form-control" name="new_password2" placeholder="Ulangi Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-secondary" id="simpan_password" style="padding:0 8px 0 8px; height:calc(2.25rem + 2px)">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Profil Saya</div>
                    <div class="card-category mt-0">Pastikan data yang anda lengkapi benar dan masih aktif</div>
                    <div class="box-bg-grey mb-3 mt-3">
                        <div class="table-responsive nowraping">
                            <table class="mb-0" width="100%">
                                <tbody>
                                    <tr>
                                        <td style="width:10%;"><b>Kode</b></td>
                                        <td style="width:2%;"><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['kode']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No. Induk</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['nomor_induk']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No. KTP</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['no_ktp']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Nama Ibu</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['nama_ibu']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                    </tr>
                                    <tr>
                                        <td><b>Nama</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Gender</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['gender']==1? 'Laki-laki':'Perempuan'; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Tempat Lahir</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['tempat_lahir']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Tgl. Lahir</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= date_format(date_create($account['tgl_lahir']),"d-m-Y"); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No. Hp</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['telp']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Telp Referensi</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['telp_referensi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Alamat Domisili</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['alamat']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Alamat KTP</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['alamat_ktp']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Pendidikan Terakhir</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['pendidikan_terakhir']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Lulus Dari</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['lulus_dari']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                    </tr>
                                    <tr>
                                        <td><b>Nama Bank</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['nama_bank']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Nama Rek</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['nama_rek']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No. Rek</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account['no_rek']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                    </tr>
                                    <tr>
                                        <td><b>Sisa Cuti</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= floatval($account['sisa_cuti']); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Tgl. Masuk</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= date_format(date_create($account['tgl_kerja']),"d-m-Y"); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Tgl. Evaluasi</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= date_format(date_create($account['tgl_evaluasi']),"d-m-Y"); ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Masa Kerja</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td>
                                            <?php $masa_kerja = date_diff(date_create($account['tgl_kerja']),date_create(date("Y-m-d"))); ?>
                                            <?= ($masa_kerja->y).' Thn, '.($masa_kerja->m).' Bln' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Cabang</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td><?= $account_cabang['nama_cabang']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
