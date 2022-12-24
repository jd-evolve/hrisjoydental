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
            <ul class="nav nav-pills nav-primary">
                <li class="nav-item col-sm-4 px-0">
                    <a class="nav-link text-center m-0 active" id="nav1"><b><i class="fas fa-file-contract mr-2"></i>Diajukan</b></a>
                </li>
                <li class="nav-item col-sm-4 px-0">
                    <a class="nav-link text-center m-0" id="nav2"><b><i class="fas fa-file-download mr-2"></i>Disetujui</b></a>
                </li>
                <li class="nav-item col-sm-4 px-0">
                    <a class="nav-link text-center m-0" id="nav3"><b><i class="fas fa-file-excel mr-2"></i>Ditolak</b></a>
                </li>
            </ul>
            
            <div class="btn-group border-option mt-3 mb-0">
                <label class="label-filter">Cari: </label>&nbsp;&nbsp;
                <input type="text" class="form-control" name="filter-search" id="filter-search" placeholder="Cari">
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table id="datatable-accatasan" class="table-responsive display nowrap table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:10%;">Pengajuan</th>
                        <th style="width:15%;">Ijin/Cuti</th>
                        <th style="width:40%;">Karyawan</th>
                        <th style="width:15%;">Bagian</th>
                        <th style="width:10%;">Status</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <input type="hidden" name="id_ijincuti_list">
    
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
                                                    <td id="show-karyawan"></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">Jabatan</td>
                                                    <td> : </td>
                                                    <td id="show-jabatan"></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="20%">Bagian</td>
                                                    <td> : </td>
                                                    <td id="show-bagian"></td>
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
                                                dan <b><span id="show-total_jam"></span> jam</b>.
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
                        <div id="show-button">
                            <button type="button" class="btn btn-danger btn-sm" id="btn-tolak">Tolak</button>
                            <button type="button" class="btn btn-success btn-sm" id="btn-setujui">Setujui</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="modal fade" id="modal-batal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="form-alasan-batal" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="modal-body text-center">
                        <h5 class="modal-title py-3" style="color:rgba(0,0,0,.65);font-weight:600;font-size:27px;line-height:normal;">Batalkan Pengajuan</h5>
                        <div class="" style="width:100% !important; padding:15px; border-radius:4px; font-size:13px; background-color:#f1d9f7; border-color:#ebbcf1;">
                            <span>Apakah anda yakin ingin membatalkan pengajuan ijin/cuti?</span><br>
                            <textarea id="alasan-batal" style="min-height:100px;" class="form-control mt-2" placeholder="Alasan di batalkan . . ." required></textarea>
                        </div>
                        <div class="py-3">
                            <button type="button" class="btn btn-danger btn-sm" id="kembali">Kembali</button>
                            <button type="submit" class="btn btn-success btn-sm" id="lanjutkan">Lanjutkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>