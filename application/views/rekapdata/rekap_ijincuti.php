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
                <div class="col-sm-6">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Periode: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-periode" id="filter-periode">
                                <?php foreach ($data_periode as $list) { ?>
                                    <option value="<?= $list->id_periode ?>"><?= $list->keterangan ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Ijin/Cuti: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-ijincuti" id="filter-ijincuti">
                            <option value="">Semua Ijin/Cuti</option>
                            <?php foreach ($data_ijincuti as $list) { ?>
                                <option value="<?= $list->id_ijincuti ?>"><?= $list->nama_ijincuti ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Status: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-status" id="filter-status">
                            <option value="1">Diajukan</option>
                            <option value="2" selected>Disetujui</option>
                            <option value="3">Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Karyawan: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-karyawan" id="filter-karyawan">
                            <option value="">Semua Karyawan</option>
                            <?php foreach ($data_karyawan as $list) { ?>
                                <option value="<?= $list->id_account ?>"><?= $list->nama ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="datatable-rekapijincuti" class="table-responsive display table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:10%;">Periode</th>
                        <th style="width:20%;">Atasan</th>
                        <th style="width:20%;">Karyawan</th>
                        <th style="width:10%;">Ijin/Cuti</th>
                        <th style="width:10%;">Awal</th>
                        <th style="width:10%;">Akhir</th>
                        <th style="width:5%;">Potong</th>
                        <th style="width:5%;">Status</th>
                        <th style="width:5%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-showform" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-showform" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-showform">Status : </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <table class="table-ijin-cuti">
                                <tr>
                                    <td colspan="2" class="surat">
                                        <p class="font-18px mt-2"><b><span id="show-ket_ijincuti">FORM IJIN/CUTI</span></b></p>
                                        <p class="mb-0" align="left">Yogyakarta, <span id="show-tgl_create"></span>
                                        <div class="text-left">
                                            <p class="mb-0 mt-3">Yang bertanda tangan di bawah ini : </p>
                                            <table class="mb-0" width="100%">
                                                <tr valign="top">
                                                    <td width="20%">Nama</td>
                                                    <td> : </td>
                                                    <td><?= $account['nama'] ?></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">Jabatan</td>
                                                    <td> : </td>
                                                    <td><?= $posisi['nama_posisi'] ?></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">Bagian</td>
                                                    <td> : </td>
                                                    <td><?= $account['bagian'] ?></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">Keperluan</td>
                                                    <td> : </td>
                                                    <td id="show-keperluan"></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">File</td>
                                                    <td> : </td>
                                                    <td id="show-file"></td>
                                                </tr>
                                            </table>
                                            <p class="mb-0 mt-3" align="justify">
                                                Dengan ini mengajukan permintaan ijin/cuti, 
                                                terhitung mulai dari tanggal <b><span id="show-tgl_awal"></span></b> 
                                                sampai dengan tanggal <b><span id="show-tgl_akhir"></span></b>
                                                dengan jumlah <b><span id="show-total_hari"></span> hari</b> 
                                                dan <b><span id="show-total_menit"></span> jam</b>.
                                            </p>
                                            <br>
                                            <p class="" align="justify">Demikian permintaan ini saya buat dengan penuh kesadaran untuk dapat dipertimbangkan sebagaimana mestinya.</p>
                                            
                                            <div class="row text-center mt-0 mb-2">
                                                <div class="col-md mb-2">
                                                    <span>Pemohon</span><br>
                                                    <span class="btn btn-info fw-bold btn-xs py-0 px-1">Mengajukan</span><br>
                                                    <span><?= $account['nama'] ?></span>
                                                </div>
                                                <div class="col-md mb-2">
                                                    <span>Atasan</span><br>
                                                    <div id="cek-atasan"></div>
                                                </div>
                                                <div class="col-md mb-2">
                                                    <span>Personalia</span><br>
                                                    <div id="cek-personalia"></div>
                                                </div>
                                            </div>
                                            
                                            <h5 class="modal-title mb-2 alasan-ditolak">Alasan ditolak : <b><span id="show-alasan_ditolak"></span></b></h5>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Kembali</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>