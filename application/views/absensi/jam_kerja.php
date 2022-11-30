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
                        <label class="label-filter">Cari: </label>&nbsp;&nbsp;
                        <input type="text" class="form-control" name="filter-search" id="filter-search" placeholder="Cari">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="datatable-jamkerja" class="table-responsive display nowrap table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:25%;">Nama</th>
                        <th style="width:15%;">Masuk</th>
                        <th style="width:15%;">Pulang</th>
                        <th style="width:15%;">Dihitung</th>
                        <th style="width:25%;">Keterangan</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-jamkerja" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-jamkerja" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-jamkerja">Jam Kerja</h5>
                        <a type="button" class="close" href="">
                        <span aria-hidden="true">&times;</span>
                        </a>
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
                                                        <td><input type="text" class="form-control form-rm" name="nama" id="nama" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keterangan</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="keterangan" id="keterangan"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="separator-solid" style="border-color: #a9a9a9"></div>
                                            <table class="mb-0">
                                                <tbody class="nowraping">
                                                    <tr>
                                                        <td width="10%">Masuk</td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td width="10%"><input type="text" class="form-control form-jm waktu" name="masuk" id="masuk" required></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pulang</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-jm waktu" name="pulang" id="pulang" required></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Dihitung</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="number" min="0" class="form-control form-jm" name="dihitung" id="dihitung" required></td>
                                                        <td>&nbsp;hari</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="separator-solid" style="border-color: #a9a9a9"></div>
                                            <table class="mb-0">
                                                <tbody class="nowraping">
                                                    <tr>
                                                        <td width="10%">Durasi sebelum masuk</td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td width="10%"><input type="number" min="0" class="form-control form-jm" name="sb_jm" id="sb_jm" required></td>
                                                        <td>&nbsp;menit</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Durasi setelah masuk</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="number" min="0" class="form-control form-jm" name="st_jm" id="st_jm" required></td>
                                                        <td>&nbsp;menit</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Durasi sebelum pulang</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="number" min="0" class="form-control form-jm" name="sb_jp" id="sb_jp" required></td>
                                                        <td>&nbsp;menit</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Durasi setelah pulang</td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="number" min="0" class="form-control form-jm" name="st_jp" id="st_jp" required></td>
                                                        <td>&nbsp;menit</td>
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
                        <input class="btn btn-primary" type="submit" name="add_jamkerja" id="add_jamkerja" value="Tambah" style="padding:9px" size="7" readonly>
                        <input class="btn btn-primary" type="hidden" name="edit_jamkerja" id="edit_jamkerja" value="Ubah" style="padding:9px" size="7" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>