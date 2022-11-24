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

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Status: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-status" id="filter-status">
                            <option value="aktif-" selected>Aktif</option>
                            <option value="hapus-">Terhapus</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Jabatan: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-posisi" id="filter-posisi">
                            <option value="">Semua</option>
                            <?php foreach ($data_posisi as $list) { 
                                if($list->id_posisi == 2){ }
                                else if($list->id_posisi == 13){ }
                                else {
                            ?>
                                <option value="<?= $list->id_posisi.'-' ?>"><?= $list->nama_posisi ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Cari: </label>&nbsp;&nbsp;
                        <input type="text" class="form-control" name="filter-search" id="filter-search" placeholder="Cari">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="datatable-account" class="table-responsive display table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:20%;">Nama</th>
                        <th style="width:20%;">Jabatan</th>
                        <th style="width:10%;">No.Hp</th>
                        <th style="width:20%;">Email</th>
                        <th style="width:20%;">Alamat</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-account" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-account" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="text-account">Account</h5>
                        <a type="button" class="close" href="">
                        <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Kode</label>
                                            <input type="text" class="form-control" name="kode" placeholder="Kode" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>No. Induk</label>
                                            <input type="text" class="form-control" name="nomor_induk" placeholder="No. Induk" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>No. KTP</label>
                                            <input type="text" class="form-control" name="nomor_ktp" placeholder="No. KTP" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Nama Ibu</label>
                                            <input type="text" class="form-control" name="nama_ibu" placeholder="Nama Ibu" style="height:0;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label>Nama<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="nama" placeholder="Nama" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Gender<span class="text-danger">*</span></label>
                                            <select class="form-control" name="gender" id="gender" required>
                                                <option value="">Pilih Gender</option>
                                                <option value="1">L</option>
                                                <option value="0">P</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Tempat Lahir<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" style="height:0;" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Tgl Lahir<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control tgl" name="tgl_lahir" placeholder="Tgl Lahir" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>No. Hp<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nohp" name="nohp" placeholder="No. Hp" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>No. Hp Referensi</label>
                                            <input type="text" class="form-control" id="nohp2" name="nohp2" placeholder="No. Hp Referensi" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Sisa Cuti<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="sisa_cuti" placeholder="Sisa Cuti" style="height:0;" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Pendidikan Terakhir</label>
                                            <select class="form-control" name="pendidikan_terakhir" id="pendidikan_terakhir">
                                                <option value="">Pilih Level</option>
                                                <option value="SMA">SMA</option>
                                                <option value="SMK">SMK</option>
                                                <option value="D1">D1</option>
                                                <option value="D2">D2</option>
                                                <option value="D3">D3</option>
                                                <option value="D4">D4</option>
                                                <option value="S1">S1</option>
                                                <option value="Profesi">Profesi</option>
                                                <option value="S2">S2</option>
                                                <option value="Spesialis">Spesialis</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Lulus Dari</label>
                                            <input type="text" class="form-control" id="lulus_dari" name="lulus_dari" placeholder="Lulus Dari" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label>E-mail</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email" style="height:0;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Alamat Domisili<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Domisili" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Alamat KTP</label>
                                            <input type="text" class="form-control" id="alamat2" name="alamat2" placeholder="Alamat KTP" style="height:0;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Nama Bank</label>
                                            <input type="text" class="form-control" name="nama_bank" placeholder="Nama Bank" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>No. Rek</label>
                                            <input type="text" class="form-control" name="no_rek" placeholder="No. Rek" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label>Nama Rek</label>
                                            <input type="text" class="form-control" name="nama_rek" placeholder="Nama Rek" style="height:0;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Level</label>
                                            <select class="form-control" name="level" id="level">
                                                <option value="">Pilih Level</option>
                                                <option value="1">Staff</option>
                                                <option value="2">Atasan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Bagian</label>
                                            <select class="form-control" name="bagian" id="bagian">
                                                <option value="">Pilih Bagian</option>
                                                <option value="Office">Office</option>
                                                <option value="FO">FO</option>
                                                <option value="Perawat">Perawat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Jabatan<span class="text-danger">*</span></label>
                                            <select class="form-control" name="posisi" id="posisi" required>
                                                <option value="">Pilih Jabatan</option>
                                                <?php foreach ($data_posisi as $list) { ?>
                                                    <option value="<?= $list->id_posisi ?>"><?= $list->nama_posisi ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Status Karyawan<span class="text-danger">*</span></label>
                                            <select class="form-control" name="status_karyawan" id="status_karyawan" required>
                                                <option value="">Pilih Status</option>
                                                <option value="1">Tetap</option>
                                                <option value="0">Percobaan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Tgl Kerja<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control tgl" id="tgl_masuk" name="tgl_masuk" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Tgl Evaluasi</label>
                                            <input type="text" class="form-control tgl" id="tgl_evaluasi" name="tgl_evaluasi" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Tgl Keluar</label>
                                            <input type="text" class="form-control tgl" id="tgl_keluar" name="tgl_keluar" style="height:0;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Alasan Keluar</label>
                                            <input type="text" class="form-control" id="alasan_keluar" name="alasan_keluar" placeholder="Alasan Keluar" style="height:0;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Cabang<span class="text-danger">*</span></label>
                                            <select class="form-control" name="cabang" id="cabang" required>
                                                <option value="">Pilih Cabang</option>
                                                <?php foreach ($data_cabang as $list) { ?>
                                                    <option value="<?= $list->id_cabang ?>"><?= $list->nama_cabang ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" name="add_account" id="add_account" value="Tambah" style="padding:9px" size="7" readonly>
                        <input class="btn btn-primary" type="hidden" name="edit_account" id="edit_account" value="Ubah" style="padding:9px" size="7" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal-lihat" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-lihat" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-lihat">Data Account</h5>
                        <a type="button" class="close" href="">
                        <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive nowraping">
                                        <table class="table tabped">
                                            <tbody>
                                                <tr>
                                                    <td style="width:18%;"><b>Kode</b></td>
                                                    <td style="width:2%;"><b>&nbsp:&nbsp</b></td>
                                                    <td style="width:80%;"><span id="show-kode"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. Induk</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-nomor_induk"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. KTP</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-nomor_ktp"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama Ibu</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-nama_ibu"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-nama"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Gender</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-gender"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tempat Lahir</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-tempat_lahir"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tgl. Lahir</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-tgl_lahir"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. Hp</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-telp"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Telp Referensi</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-telp2"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Email</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-email"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Alamat Domisili</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-alamat"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Alamat KTP</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-alamat2"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Pendidikan Terakhir</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-pendidikan_terakhir"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Lulus Dari</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-lulus_dari"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama Bank</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-nama_bank"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama Rek</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-nama_rek"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. Rek</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-no_rek"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Sisa Cuti</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-sisa_cuti"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Status Karyawan</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-status_karyawan"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Level</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-level"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Bagian</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-bagian"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Jabatan</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-posisi"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tgl. Masuk</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-tgl_masuk"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tgl. Evaluasi</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-tgl_evaluasi"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tgl. Keluar</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-tgl_keluar"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Alasan Keluar</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-alasan_keluar"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Masa Kerja</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-masa_kerja"></span></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Cabang</b></td>
                                                    <td><b>&nbsp:&nbsp</b></td>
                                                    <td><span id="show-cabang_klinik"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>