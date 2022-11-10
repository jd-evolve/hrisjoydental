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
        <div class="col-md-9 ml-auto mr-auto">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-center">Pengajuan Ijin Pribadi</div>
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
                        <ol class="ml-0" type="1">
                            <li>Karyawan membuat surat permohonan ijin/cuti ditujukan kepada Personalia.</li>
                            <li>Karyawan mengisi formulir dalam aplikasi ini.</li>
                            <li>Karyawan menunggu pemberitahuan dari pihak Personalia bahwa proses permohonan telah selesai.</li>
                        </ol>
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
                                        <p class="font-18px mt-2"><b>FORM IJIN</b></p>
                                        <p class="mb-0" align="left">Yogyakarta,<?= date("d-m-Y") ?></p>
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
                                                    <td width="20%">Keperluan</td>
                                                    <td> : </td>
                                                    <td><textarea name="tindakan-medis" style="min-height:80px;" rows="3" class="form-control p-1" required></textarea></td>
                                                </tr>
                                            </table>
                                            <p class="mb-0 mt-3">Dengan ini mengajukan permintaan ijin, </p>
                                            <table class="mb-0" width="100%">
                                                <tr valign="top">
                                                    <td width="20%">Dari Tgl</td>
                                                    <td> : </td>
                                                    <td><input type="text" name="dari_tgl" id="dari_tgl" class="input-line bg-transparent p-0 width-full tgl-wkt" placeholder="dd-mm-yyyy 00:00" required></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">Sampai</td>
                                                    <td> : </td>
                                                    <td><input type="text" name="sampai_tgl" id="sampai_tgl" class="input-line bg-transparent p-0 width-full tgl-wkt" placeholder="dd-mm-yyyy 00:00" required></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">Jumlah</td>
                                                    <td> : </td>
                                                    <td>
                                                        <input type="number" name="hari" class="input-line bg-transparent p-0 text-right" style="width:35px;" min="0" value="0" required> Hari, 
                                                        <input type="number" name="jam" class="input-line bg-transparent p-0 text-right" style="width:35px;" min="0" value="0" required> Jam
                                                    </td>
                                                </tr>
                                            </table>
                                            <br>
                                            <p align="justify">Demikian permintaan ini saya buat dengan penuh kesadaran untuk dapat dipertimbangkan sebagaimana mestinya.</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="text-right mt-3">
                                <button class="btn btn-warning btn-sm" type="button" id="ajukan_form">Ajukan</button>
                            </div>
                        </form>
                    </div>

                    <div class="none" id="show-nav3">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Status: </label>&nbsp;&nbsp;
                            <select class="form-control" name="filter-status" id="filter-status">
                                <option value="0" selected>Diajukan</option>
                                <option value="1">Disetujui</option>
                                <option value="2">Ditolak</option>
                            </select>
                        </div>

                        <table id="datatable-kota" class="table-responsive display nowrap table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th style="width:10%;">Tanggal</th>
                                    <th style="width:70%;">Keperluan</th>
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

    <div class="card none">
        <div class="card-body">
        </div>
    </div>
</div>