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

    <input type="hidden" id="id_ijincuti" value="<?= $id_ijincuti ?>">

    <div class="row">
        <div class="col-md-9 ml-auto mr-auto">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-center">Pengajuan <?= $title ?></div>
                    <div class="card-category text-center">Baca persyaratan standar operasional prosedur</div>

                    <ul class="nav nav-pills nav-primary my-4">
                        <li class="nav-item col-sm-4 px-0">
                            <a class="nav-link text-center m-0 active" id="nav1"><b><i class="fas fa-feather-alt mr-2"></i>SOP</b></a>
                        </li>
                        <li class="nav-item col-sm-4 px-0">
                            <a class="nav-link text-center m-0" id="nav2"><b><i class="fas fa-file-invoice mr-2"></i>Pengajuan</b></a>
                        </li>
                        <li class="nav-item col-sm-4 px-0">
                            <a class="nav-link text-center m-0" id="nav3"><b><i class="fas fa-magic mr-2"></i>Status</b></a>
                        </li>
                    </ul>

                    <div class="" id="show-nav1">
                        <h4><b>Persyaratan :</b></h4>
                        <ol class="ml-0" type="1"><?= $persyaratan ?></ol>
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="persetujuan" style="left:20px !important;">
                            <span class="card-category mt-0 ml-4 mb-1">Saya menyetujui persyaratan diatas.</span>
                        </label>
                        <small class="form-text text-danger mt-0 notif none">Check persetujuan untuk melanjutkan.</small>

                        <div class="text-right">
                            <button class="btn btn-warning btn-sm" type="button" id="setuju_sop">Next</button>
                        </div>
                    </div>

                    <div class="none" id="show-nav2">
                        <form id="form-ijincuti" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                            <table class="table-ijin-cuti">
                                <tr>
                                    <td colspan="2" class="surat">
                                        <p class="font-18px mt-2"><b>FORM <span class="text-uppercase"><?= $title ?></span></b></p>
                                        <p class="mb-0" align="left">Yogyakarta,<?= date("d F Y") ?></p>
                                        <p class="mb-0" align="left">Periode : <u><?= $on_periode ? $on_periode['keterangan'] : 'Belum Tersedia' ?></u></p>
                                        <input type="hidden" name="id_periode" value="<?= $on_periode ? $on_periode['id_periode']:'' ?>">
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
                                                    <td><textarea name="keperluan" style="min-height:80px;" rows="3" class="form-control p-1" required></textarea></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">File<span class="text-danger">*</span></td>
                                                    <td> : </td>
                                                    <td><input type="file" accept=".jpg, .jpeg, .png" class="form-control-file" name="file_ijincuti"></td>
                                                </tr>
                                            </table>
                                            <p class="mb-0 mt-3">Dengan ini mengajukan permintaan ijin/cuti, 
                                                
                                                <span class="ml-3">
                                                    <label class="checkbox-inline mr-1"><input type="radio" name="pilih_ijincuti" value="1" require checked> Per Shift </label>
                                                    <label class="checkbox-inline mr-1"><input type="radio" name="pilih_ijincuti" value="0" required> Per Jam </label>
                                                </span>
                                            </p>
                                            <table class="mb-0" width="100%">
                                                <tbody id="per_shift">
                                                    <tr valign="top">
                                                        <td width="20%">Dari</td>
                                                        <td> : </td>
                                                        <td><input type="text" name="tgl_awal" id="tgl_awal" class="input-line bg-transparent p-0 width-full tgl" placeholder="dd-mm-yyyy" required></td>
                                                    </tr>
                                                    <tr valign="top">
                                                        <td width="20%">Sampai</td>
                                                        <td> : </td>
                                                        <td><input type="text" name="tgl_akhir" id="tgl_akhir" class="input-line bg-transparent p-0 width-full tgl" placeholder="dd-mm-yyyy" required></td>
                                                    </tr>
                                                </tbody>
                                                <tbody id="per_jam" class="none">
                                                    <tr valign="top">
                                                        <td width="20%">Tanggal</td>
                                                        <td> : </td>
                                                        <td><input type="text" id="tanggal" class="input-line bg-transparent p-0 width-full tgl" placeholder="dd-mm-yyyy"></td>
                                                    </tr>
                                                    <tr valign="top">
                                                        <td width="20%">Dari</td>
                                                        <td> : </td>
                                                        <td><input type="text" name="jam_awal" id="jam_awal" class="input-line bg-transparent p-0 width-full wkt" placeholder="00:00" required></td>
                                                    </tr>
                                                    <tr valign="top">
                                                        <td width="20%">Sampai</td>
                                                        <td> : </td>
                                                        <td><input type="text" name="jam_akhir" id="jam_akhir" class="input-line bg-transparent p-0 width-full wkt" placeholder="00:00" required></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr valign="top">
                                                        <td width="20%">Jumlah</td>
                                                        <td> : </td>
                                                        <td><span id="show-thari">0</span> Hari, <span id="show-tmenit">0</span> Menit
                                                            <input type="hidden" name="total_hari" id="total_hari" required> 
                                                            <input type="hidden" name="total_menit" id="total_menit" required> 
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <br>
                                            <p align="justify">Demikian permintaan ini saya buat dengan penuh kesadaran untuk dapat dipertimbangkan sebagaimana mestinya.</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <p class="mt-2 mb-0 text-muted"><span class="text-danger">*</span>) Batas maksimal file yang dapat di upload adalah 2,5MB dan format jpg/png. Optional.</p>
                            <?php if($on_periode){ ?>
                            <div class="text-right mt-3">
                                <button class="btn btn-success btn-sm" type="button" id="ajukan_form">Ajukan</button>
                            </div>
                            <?php } ?>
                        </form>
                    </div>

                    <div class="none" id="show-nav3">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Status: </label>&nbsp;&nbsp;
                            <select class="form-control" name="filter-status" id="filter-status">
                                <option value="x" selected>Semua</option>
                                <option value="y">Diajukan</option>
                                <option value="2">Disetujui</option>
                                <option value="3">Ditolak</option>
                            </select>
                        </div>

                        <table id="datatable-ijincuti" class="table-responsive display table table-striped table-hover mt-1">
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th style="width:10%;">Tanggal</th>
                                    <th style="width:10%;">Dipotong</th>
                                    <th style="width:60%;">Keperluan</th>
                                    <th style="width:10%;">Status</th>
                                    <th style="width:10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
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
                                        <p class="font-18px mt-2"><b>FORM <span class="text-uppercase"><?= $title ?></span></b></p>
                                        <p class="mb-0" align="left">Yogyakarta, <span id="show-tgl_create"></span></p>
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