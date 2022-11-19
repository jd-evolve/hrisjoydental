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
            <table id="datatable-kegiatan" class="table-responsive display nowrap table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:20%;">Tanggal</th>
                        <th style="width:55%;">Kegiatan</th>
                        <th style="width:15%;">Oleh</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-kegiatan" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-kegiatan" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-kegiatan">Kegiatan</h5>
                        <a type="button" class="close" href="">
                        <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="col-form-label">Tanggal Kegiatan : <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control tgl" name="tgl_kegiatan" id="tgl_kegiatan" placeholder="Tanggal Kegiatan" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kegiatan : <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="kegiatan" id="kegiatan" placeholder="Kegiatan" required>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" name="add_kegiatan" id="add_kegiatan" value="Tambah" style="padding:9px" size="7" readonly>
                        <input class="btn btn-primary" type="hidden" name="edit_kegiatan" id="edit_kegiatan" value="Ubah" style="padding:9px" size="7" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>