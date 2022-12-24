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
                <div class="col-sm-4">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Periode: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-periode" id="filter-periode">
                                <?php foreach ($data_periode as $list) { ?>
                                    <option value="<?= $list->id_periode ?>"><?= $list->keterangan ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Status: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-status" id="filter-status">
                            <option value="1">Diajukan</option>
                            <option value="x" selected>Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
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
            <table id="datatable-rekaplembur" class="table-responsive display table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:15%;">Periode</th>
                        <th style="width:20%;">Atasan</th>
                        <th style="width:20%;">Karyawan</th>
                        <th style="width:15%;">Bagian</th>
                        <th style="width:10%;">Total</th>
                        <th style="width:10%;">Status</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    
    <div class="modal fade" id="modal-showlembur" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-showlembur" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Lembur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <div class="box-bg-grey mb-3">
                                        <table class="mb-0">
                                            <tbody class="nowraping">
                                                <tr>
                                                    <td width="10%">Nama</td>
                                                    <td width="2%">&nbsp;:&nbsp;</td>
                                                    <td id="show-nama"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jabatan</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td id="show-jabatan"></td>
                                                </tr>
                                                <tr>
                                                    <td>Bagian</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td id="show-bagian"></td>
                                                </tr>
                                                <tr>
                                                    <td>Periode</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td id="show-periode"></td>
                                                </tr>
                                                <tr>
                                                    <td>Atasan</td>
                                                    <td>&nbsp;:&nbsp;</td>
                                                    <td id="show-atasan"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="tabel-listlembur" class="table table-scanlog table-bordered table-bordered-bd-gray mb-0">
                                            <thead>
                                                <tr style="background: #f7f8fa">
                                                    <th style="width:2%;">No</th>
                                                    <th style="width:10%;">Tanggal</th>
                                                    <th style="width:10%;">Mulai</th>
                                                    <th style="width:10%;">Selesai</th>
                                                    <th style="width:5%;">Jumlah</th>
                                                    <th style="width:15%;">Kategori</th>
                                                    <th style="width:24%;">Keterangan</th>
                                                    <th style="width:24%;">Persetujuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data dari js -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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