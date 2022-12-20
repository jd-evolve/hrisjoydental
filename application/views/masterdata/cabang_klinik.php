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
            <table id="datatable-cabang" class="table-responsive display table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:10%;">Kode</th>
                        <th style="width:20%;">Nama</th>
                        <th style="width:20%;">PT</th>
                        <th style="width:30%;">Alamat</th>
                        <th style="width:10%;">SN</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-cabang" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <form id="form-cabang" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-cabang">Cabang</h5>
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
                                            <table class="mb-0" width="100%">
                                                <tbody class="nowraping">
                                                    <tr>
                                                        <td width="10%">Kode Cabang <span class="text-danger">*</span></td>
                                                        <td width="2%">&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="kode_cabang" id="kode_cabang" placeholder="Kode Cabang" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Cabang <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="nama_cabang" id="nama_cabang" placeholder="Nama Cabang" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama PT <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="nama_pt" id="nama_pt" placeholder="Nama PT" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat Cabang <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><textarea class="form-control" name="alamat_cabang" id="alamat_cabang" placeholder="Alamat Cabang" style="padding: 0.25rem 0.5rem; min-height: 92px;" required></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>SN Mesin <span class="text-danger">*</span></td>
                                                        <td>&nbsp;:&nbsp;</td>
                                                        <td><input type="text" class="form-control form-rm" name="sn_mesin" id="sn_mesin" placeholder="SN Mesin" required></td>
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
                        <input type="hidden" name="id_cabang">
                        <input class="btn btn-primary" type="submit" name="add_cabang" id="add_cabang" value="Tambah" style="padding:9px" size="7" readonly>
                        <input class="btn btn-primary" type="hidden" name="edit_cabang" id="edit_cabang" value="Ubah" style="padding:9px" size="7" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>