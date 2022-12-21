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
                    <div class="card-title text-center">Pengajuan From Lembur</div>
                    <div class="card-category text-center">Baca persyaratan standar operasional prosedur</div>

                    <ul class="nav nav-pills nav-primary my-4">
                        <li class="nav-item col-sm-6 px-0">
                            <a class="nav-link text-center m-0 active" id="nav1"><b><i class="fas fa-feather-alt mr-2"></i>SOP</b></a>
                        </li>
                        <li class="nav-item col-sm-6 px-0">
                            <a class="nav-link text-center m-0" id="nav2"><b><i class="fas fa-file-invoice mr-2"></i>Pengajuan</b></a>
                        </li>
                    </ul>

                    <div class="" id="show-nav1">
                        <h4><b>Persyaratan :</b></h4>
                        <ol class="ml-0" type="1">
                            <li>Sebelum mengisi form lembur pastikan data periode sudah tersedia.</li>
                            <li>Lembur di bedakan menjadi 2 kategori, yaitu <b>range jam kerja</b> dan <b>diluar jam kerja</b>.</li>
                            <li><b>Range Jam Kerja</b> adalah lembur dimana waktu masih berada dalam jangkauan waktu jam kerja.</li>
                            <li><b>Diluar Jam Kerja</b> adalah lembur dimana waktu tidak berada dalam jangkauan waktu jam kerja.</li>
                            <li>Perbedaan antara 2 kategori form lembur berpengaruh terhadap selisih form lembur dengan lembur di mesin.</li>
                            <li>Jika selisih antara lembur mesin dan pengajuan form lembur minus maka yang di akumulasi adalah lembur mesin.</li>
                            <li>Jika selisih antara lembur mesin dan pengajuan form lembur plus maka yang di akumulasi adalah lembur form.</li>
                            <li>Rumus untuk menentukan selisih jam kerja (Sx).</li>
                            <li><i>Sx = (lembur mesin + diluar jam kerja) - (range jam kerja + dilular jam kerja)</i></li>
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
                        <table width="100%">
                            <tr>
                                <td width="100%">
                                    <div class="btn-group border-option mb-0">
                                        <label class="label-filter">Periode: </label>&nbsp;&nbsp;
                                        <select class="form-control" name="filter-periode" id="filter-periode">
                                                <?php foreach ($data_periode as $list) { ?>
                                                    <option value="<?= $list->id_periode ?>"><?= $list->keterangan ?></option>
                                                <?php }?>
                                        </select>
                                    </div>
                                </td>
                                <?php if($on_periode){ ?>
                                <td>&nbsp;&nbsp;</td>
                                <td>
                                    <button class="btn btn-default" id="tambah_lembur" style="padding:10px 18px;">
                                        <span class="btn-label mr-2"><i class="fa fa-plus"></i></span>Tambah
                                    </button>
                                </td>
                                <?php } ?>
                            </tr>
                        </table>

                        <table id="datatable-lembur" class="mt-2 table-responsive display table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th style="width:10%;">Tanggal</th>
                                    <th style="width:10%;">Waktu</th>
                                    <th style="width:10%;">Menit</th>
                                    <th style="width:10%;">Kategori</th>
                                    <th style="width:40%;">Keterangan</th>
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

    <div class="modal fade" id="modal-lembur" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-lembur" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-lembur">Lembur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <div class="box-bg-grey">
                                        <div class="table-responsive">
                                            <table class="mb-0">
                                                <tbody class="nowraping">
                                                    <tr>
                                                        <td width="10%">Nama</td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td><?= $account['nama'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jabatan</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><?= $posisi['nama_posisi'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bagian</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><?= $account['bagian'] ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="separator-solid" style="border-color: #a9a9a9"></div>
                                            <table class="mb-0">
                                                <tbody class="nowraping">
                                                    <tr>
                                                        <td width="10%">Periode</td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <input type="hidden" id="periode_awal" value="<?= $on_periode ? $on_periode['periode_awal']:'' ?>">
                                                            <input type="hidden" id="periode_akhir" value="<?= $on_periode ? $on_periode['periode_akhir']:'' ?>">
                                                            <input type="hidden" id="ket_periode" value="<?= $on_periode ? $on_periode['keterangan']:'' ?>">
                                                            <input type="hidden" name="id_periode" value="<?= $on_periode ? $on_periode['id_periode']:'' ?>">
                                                            <input type="text" class="form-control form-jm" name="periode" id="periode" value="<?= $on_periode ? $on_periode['keterangan']:'' ?>" placeholder="Belum tersedia" style="width: 149px !important; background: #fff !important;" readonly>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-jm tgl" name="tgl_lembur" id="tgl_lembur" placeholder="__-__-____" style="width: 149px !important; background: #fff !important;" required></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kategori</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <select class="form-control form-rm" name="kategori" id="kategori" style="padding: 0.4rem 0.5rem !important; width: 149px; background: #fff !important;" required>
                                                                <option value="">Pilih Kategori</option>
                                                                <option value="1">diluar jam kerja</option>
                                                                <option value="2">range jam kerja</option>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Waktu</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <input type="text" class="form-control form-jm waktu" name="jam_mulai" id="jam_mulai" placeholder="__:__" style="width: 50px !important; background: #fff !important;" required> 
                                                                <span class="mt-1">&nbsp;sampai&nbsp;</span>
                                                                <input type="text" class="form-control form-jm waktu" name="jam_selesai" id="jam_selesai" placeholder="__:__" style="width: 50px !important; background: #fff !important;" required>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <input type="text" min="0" class="form-control form-jm text-right" name="jumlah" id="jumlah" style="width: 111px !important; background: #fff !important;" required readonly>
                                                                <span class="mt-1">&nbsp;menit&nbsp;</span>
                                                            </div>
                                                        <td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keterangan</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><textarea class="form-control" name="keterangan" id="keterangan" style="padding: 0.25rem 0.5rem; min-height: 92px; height: 17px; background: #fff !important;" required></textarea></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                        <h5 class="modal-title mt-2 alasan-ditolak none"><u>Alasan ditolak </u> : <b><span id="show-alasan_ditolak">-</span></b></h5>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_lembur">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Batal</button>
                        <input class="btn btn-success btn-sm" type="submit" name="add_lembur" id="add_lembur" value="Tambah" readonly>
                        <input class="btn btn-success btn-sm" type="hidden" name="edit_lembur" id="edit_lembur" value="Ubah" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>