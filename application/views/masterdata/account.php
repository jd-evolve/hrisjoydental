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

    <div class="modal fade" id="modal-account" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-account" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="text-account">Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="box-bg-grey mb-3">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td style="width:10%;"><b>Kode</b></td>
                                                    <td style="width:2%;"><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="kode" placeholder="Kode"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. Induk</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="nomor_induk" placeholder="No. Induk"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. KTP</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="nomor_ktp" placeholder="No. KTP"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama Ibu</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="nama_ibu" placeholder="Nama Ibu"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="nama" placeholder="Nama" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Gender</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td>
                                                        <select class="form-control form-rm" name="gender" id="gender" style="padding: 0.4rem 0.5rem !important;" required>
                                                            <option value="">Pilih Gender</option>
                                                            <option value="1">L</option>
                                                            <option value="0">P</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tempat Lahir</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="tempat_lahir" placeholder="Tempat Lahir" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tgl. Lahir</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm tgl" name="tgl_lahir" placeholder="Tgl Lahir" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. Hp</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" id="nohp" name="nohp" placeholder="No. Hp" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Telp Referensi</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" id="nohp2" name="nohp2" placeholder="No. Hp Referensi"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Email</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="email" class="form-control form-rm" name="email" placeholder="Email"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Alamat Domisili</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" id="alamat" name="alamat" placeholder="Alamat Domisili" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Alamat KTP</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" id="alamat2" name="alamat2" placeholder="Alamat KTP"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Pendidikan Terakhir</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td>
                                                        <select class="form-control form-rm" name="pendidikan_terakhir" id="pendidikan_terakhir" style="padding: 0.4rem 0.5rem !important;">
                                                            <option value="">Pilih Pendidikan</option>
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
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Lulus Dari</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" id="lulus_dari" name="lulus_dari" placeholder="Lulus Dari"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama Bank</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="nama_bank" placeholder="Nama Bank"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Nama Rek</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="nama_rek" placeholder="Nama Rek"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>No. Rek</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="no_rek" placeholder="No. Rek"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Sisa Cuti</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="sisa_cuti" placeholder="Sisa Cuti" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Status Karyawan</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td>
                                                        <select class="form-control form-rm" name="status_karyawan" id="status_karyawan" style="padding: 0.4rem 0.5rem !important;" required>
                                                            <option value="">Pilih Status</option>
                                                            <option value="1">Tetap</option>
                                                            <option value="0">Percobaan</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Level</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td>
                                                        <select class="form-control form-rm" name="level" id="level" style="padding: 0.4rem 0.5rem !important;">
                                                            <option value="">Pilih Level</option>
                                                            <option value="1">Staff</option>
                                                            <option value="2">Atasan</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Bagian</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td>
                                                        <select class="form-control form-rm" name="bagian" id="bagian" style="padding: 0.4rem 0.5rem !important;">
                                                            <option value="">Pilih Bagian</option>
                                                            <option value="Office">Office</option>
                                                            <option value="FO">FO</option>
                                                            <option value="Perawat">Perawat</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Jabatan</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td>
                                                        <select class="form-control form-rm" name="posisi" id="posisi" style="padding: 0.4rem 0.5rem !important;" required>
                                                            <option value="">Pilih Jabatan</option>
                                                            <?php foreach ($data_posisi as $list) { ?>
                                                                <option value="<?= $list->id_posisi ?>"><?= $list->nama_posisi ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Jadwal Kerja</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td>
                                                        <select class="form-control form-rm" name="jadwal_kerja" id="jadwal_kerja" style="padding: 0.4rem 0.5rem !important;" required>
                                                            <option value="">Pilih Jadwal Kerja</option>
                                                            <?php foreach ($data_jadwal_kerja as $list) { ?>
                                                                <option value="<?= $list->id_jadwal_kerja ?>"><?= $list->nama_jadwal_kerja ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tgl. Masuk</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm tgl" id="tgl_masuk" name="tgl_masuk" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tgl. Evaluasi</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm tgl" id="tgl_evaluasi" name="tgl_evaluasi"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tgl. Keluar</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm tgl" id="tgl_keluar" name="tgl_keluar"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Alasan Keluar</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" id="alasan_keluar" name="alasan_keluar" placeholder="Alasan Keluar"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Cabang</b> <span class="text-danger">*</span></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td>
                                                        <select class="form-control form-rm" name="cabang" id="cabang" style="padding: 0.4rem 0.5rem !important;" required>
                                                            <option value="">Pilih Cabang</option>
                                                            <?php foreach ($data_cabang as $list) { ?>
                                                                <option value="<?= $list->id_cabang ?>"><?= $list->nama_cabang ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_account">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Batal</button>
                        <input class="btn btn-success btn-sm" type="submit" name="add_account" id="add_account" value="Tambah" readonly>
                        <input class="btn btn-success btn-sm" type="hidden" name="edit_account" id="edit_account" value="Ubah" readonly>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <div class="box-bg-grey mb-3">
                                        <div class="table-responsive nowraping">
                                            <table class="mb-0" width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:10%;"><b>Kode</b></td>
                                                        <td style="width:2%;"><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-kode"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>No. Induk</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-nomor_induk"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>No. KTP</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-nomor_ktp"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nama Ibu</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-nama_ibu"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nama</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-nama"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Gender</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-gender"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Tempat Lahir</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-tempat_lahir"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Tgl. Lahir</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-tgl_lahir"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>No. Hp</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-telp"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Telp Referensi</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-telp2"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Email</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-email"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Alamat Domisili</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-alamat"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Alamat KTP</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-alamat2"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Pendidikan Terakhir</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-pendidikan_terakhir"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Lulus Dari</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-lulus_dari"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nama Bank</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-nama_bank"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nama Rek</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-nama_rek"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>No. Rek</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-no_rek"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Sisa Cuti</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-sisa_cuti"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Status Karyawan</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-status_karyawan"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Level</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-level"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Bagian</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-bagian"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Jabatan</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-posisi"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Jadwal Kerja</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-jadwal_kerja"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><div class="separator-solid" style="border-color: #a9a9a9"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Tgl. Masuk</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-tgl_masuk"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Tgl. Evaluasi</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-tgl_evaluasi"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Tgl. Keluar</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-tgl_keluar"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Alasan Keluar</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-alasan_keluar"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Masa Kerja</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
                                                        <td><span id="show-masa_kerja"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Cabang</b></td>
                                                        <td><b>&nbsp;:&nbsp;</b></td>
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
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal-salary" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-salary" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="text-salary">Account Salary</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="box-bg-grey mb-3">
                                    <div class="table-responsive">
                                        <table class="mb-0" width="100%">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td style="width:10%;"><b>Gaji Tetap</b> (n)</td>
                                                    <td style="width:2%;"><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="gaji_tetap" id="gaji_tetap" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Insentif</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="insentif" id="insentif" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Uang Makan</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="uang_makan" id="uang_makan" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Uang Transport</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="uang_transport" id="uang_transport" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Uang Masuk Hari Libur</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="uang_hlibur" id="uang_hlibur" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Uang Lembur</b> (n/173)</td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="uang_lembur" id="uang_lembur" placeholder="0" data-type="currency" required readonly style="background: #fff !important;"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Uang Per Shift</b> (n/25)</td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="uang_shift" id="uang_shift" placeholder="0" data-type="currency" required readonly style="background: #fff !important;"></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tunjangan Jabatan</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="tunjangan_jabatan" id="tunjangan_jabatan" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tunjangan STR</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="tunjangan_str" id="tunjangan_str" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>BPJS Kesehatan</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="bpjs_kesehatan" id="bpjs_kesehatan" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                                <tr>
                                                    <td><b>BPJS TK</b></td>
                                                    <td><b>&nbsp;:&nbsp;</b></td>
                                                    <td><input type="text" class="form-control form-rm" name="bpjs_tk" id="bpjs_tk" placeholder="0" data-type="currency" required></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_account">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Batal</button>
                        <input class="btn btn-success btn-sm" type="submit" name="edit_salary" id="edit_salary" value="Ubah" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>