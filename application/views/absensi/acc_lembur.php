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
                <li class="nav-item col-sm-6 px-0">
                    <a class="nav-link text-center m-0 active" id="nav1"><b><i class="fas fa-file-contract mr-2"></i>Diajukan</b></a>
                </li>
                <li class="nav-item col-sm-6 px-0">
                    <a class="nav-link text-center m-0" id="nav2"><b><i class="fas fa-file-download mr-2"></i>List Lembur</b></a>
                </li>
            </ul>
            
            <div class="row mt-3">
                <div class="col-sm filter-1 none">
                    <div class="btn-group border-option mb-0">
                        <label class="label-filter">Periode: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-periode" id="filter-periode">
                                <?php foreach ($data_periode as $list) { ?>
                                    <option value="<?= $list->id_periode ?>"><?= $list->keterangan ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-sm filter-2">
                    <div class="btn-group border-option mb-0">
                        <label class="label-filter">Cari: </label>&nbsp;&nbsp;
                        <input type="text" class="form-control" name="filter-search" id="filter-search" placeholder="Cari">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table id="datatable-acclembur" class="table-responsive display nowrap table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:15%;">Periode</th>
                        <th style="width:40%;">Karyawan</th>
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
                        <input type="hidden" name="id_periode">
                        <input type="hidden" name="count_lembur">
                        <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Kembali</button>
                        <button class="btn btn-success btn-sm" id="simpan_lembur">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
