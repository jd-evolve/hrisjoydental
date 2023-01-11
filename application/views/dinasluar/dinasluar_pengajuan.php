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

    <div id="show-1" class="">
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
                            <label class="label-filter">Cari: </label>&nbsp;&nbsp;
                            <input type="text" class="form-control" name="filter-search" id="filter-search" placeholder="Cari">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table id="datatable-dinasluar" class="table-responsive display table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:20%;">Tujuan</th>
                            <th style="width:30%;">Nama</th>
                            <th style="width:20%;">Tanggal</th>
                            <th style="width:20%;">Keperluan</th>
                            <th style="width:10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="show-2" class="none">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <button class="btn btn-xs mr-3" id="btn-back" title="Kembali ke data dinas"><span class="fa fa-chevron-left"></span></button>
                            <h4 class="card-title">Menu Dinas Diluar</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills nav-secondary" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active show" id="menu-pengajuan" data-toggle="pill" role="tab" aria-selected="true">Data Pengajuan</a>
                            <a class="nav-link" id="menu-perjalanan" data-toggle="pill" role="tab" aria-selected="false">Laporan Hasil Perjalanan</a>
                            <a class="nav-link" id="menu-reimburse" data-toggle="pill" role="tab" aria-selected="false">Laporan Reimburse</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div id="for-menu-pengajuan">
                            <div class="text-center text-uppercase mb-3">
                                <h5><b>Pengajuan Perjalanan Dinas Luar Kota dan Luar Kantor</b></h5>
                            </div>
                            <div class="box-bg-grey">
                                <div class="table-responsive">
                                    <table class="mb-0" width="100%">
                                        <tbody class="nowraping" style="vertical-align:top">
                                            <tr>
                                                <td width="10%">Nama</td>
                                                <td width="2%">&nbsp;:&nbsp;</td>
                                                <td>
                                                    <div class="card-box ans-box form-rm">
                                                        <table id="tabel-member-dinas" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="5%" class="text-center">1.</td>
                                                                    <td>Admin</td>
                                                                    <td width="5%"><a id="del_libur" data-index="0" class="text-danger pointer"><i class="fa fa-trash"></i></a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="d-flex">
                                                        <select class="form-control form-rm" name="filter-karyawan" id="filter-karyawan">
                                                            <option value="0">Pilih Karyawan</option>
                                                            <?php foreach ($data_karyawan as $list) { ?>
                                                                <option value="<?= $list->id_account ?>"><?= $list->nama ?></option>
                                                            <?php }?>
                                                        </select>
                                                        <button class="btn btn-primary btn-xs form-rm" style="border: none !important">ADD</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><div class="separator-solid m-1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Kota Tujuan</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td><input type="text" class="form-control form-rm" name="kota_tujuan" id="kota_tujuan" placeholder="Cabang/Kota Tujuan" required></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><div class="separator-solid m-1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Lama Perjalanan</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <input type="text" class="form-control form-rm tgl" name="tgl_berangkat" id="tgl_berangkat" placeholder="dd-mm-yyyy" style="min-width:90px" required>
                                                        <span style="padding:4px">s/d</span>
                                                        <input type="text" class="form-control form-rm tgl" name="tgl_pulang" id="tgl_pulang" placeholder="dd-mm-yyyy" style="min-width:90px" required>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><div class="separator-solid m-1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Keperluan</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td><textarea name="keperluan" style="min-height:80px" rows="3" class="form-control p-1" required></textarea></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><div class="separator-solid m-1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Biaya</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>
                                                    <label class="form-check-label mr-2">
                                                        <input class="form-check-input mx-1" type="checkbox" id="biaya"><span class="form-check-sign" id="tb1">Reimburstment</span>
                                                    </label>
                                                    <label class="form-check-label mr-2">
                                                        <input class="form-check-input mx-1" type="checkbox" id="biaya"><span class="form-check-sign" id="tb1">Advance</span>
                                                    </label>
                                                    <textarea name="ket_biaya" id="ket_biaya" style="min-height:48px" rows="2" class="form-control p-1" placeholder="Keterangan..." required></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><div class="separator-solid m-1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Kendaraan</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>
                                                    <label class="form-check-label mr-2">
                                                        <input class="form-check-input mx-1" type="checkbox" id="kendaraan"><span class="form-check-sign" id="tk1">Pribadi</span>
                                                    </label>
                                                    <label class="form-check-label mr-2">
                                                        <input class="form-check-input mx-1" type="checkbox" id="kendaraan"><span class="form-check-sign" id="tk1">Operasional</span>
                                                    </label>
                                                    <label class="form-check-label mr-2">
                                                        <input class="form-check-input mx-1" type="checkbox" id="kendaraan"><span class="form-check-sign" id="tk1">Lain-lain</span>
                                                    </label>
                                                    <textarea name="ket_kendaraan" id="ket_kendaraan" style="min-height:48px" rows="2" class="form-control p-1" placeholder="Ex: km.awal & km.akhir..." required></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td><div class="separator-solid m-1"></div></td>
                                            </tr>
                                            <tr>
                                                <td>Akomodasi</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>
                                                    <label class="form-check-label mr-2">
                                                        <input class="form-check-input mx-1" type="checkbox" id="akomodasi"><span class="form-check-sign" id="ta1">Transportasi</span>
                                                    </label>
                                                    <label class="form-check-label mr-2">
                                                        <input class="form-check-input mx-1" type="checkbox" id="akomodasi"><span class="form-check-sign" id="ta1">Penginapan</span>
                                                    </label>
                                                    <textarea name="ket_akomodasi" id="ket_akomodasi" style="min-height:48px" rows="2" class="form-control p-1" placeholder="Permintaan khusus..." required></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="for-menu-perjalanan" class="none">
                            <div class="text-center text-uppercase mb-3">
                                <h5><b>Laporan Hasil Perjalanan Dinas</b></h5>
                            </div>
                        </div>
                        <div id="for-menu-reimburse" class="none">
                            <div class="text-center text-uppercase mb-3">
                                <h5><b>Laporan Reimburse Perjalanan Dinas</b></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>