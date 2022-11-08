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
    
    <div id="show-level">
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
                <table id="datatable-level" class="table-responsive display nowrap table table-striped table-hover" >
                    <thead>
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:40%;">Nama Posisi</th>
                            <th style="width:55%;">Keterangan</th>
                            <th style="width:10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="none" id="aksi-level">
        <div class="card">
            <div class="card-body">
                <form id="form-level" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="table-responsive">
                        <div>
                            <input type="hidden" name="numb">
                            <input type="hidden" name="id_posisi">
                            <table class="table table-bordered table-hover cusped">
                                <tbody class="nowraping">
                                    <tr>
                                        <td style="width:20%;">Nama Posisi</td>
                                        <td><input type="text" class="form-control input-full" name="nama_posisi" placeholder="Nama Posisi" required></td>
                                    </tr>
                                    <tr>
                                        <td style="width:20%;">Keterangan</td>
                                        <td><input type="text" class="form-control input-full" name="keterangan" placeholder="Keteranga" required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                <form id="form-level-list" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-bordered table-hover cusped" id="table-level-member">
                                <tbody class="nowraping">
                                    <tr class="text-center">
                                        <th colspan="2">
                                            <span class="mt-2 fa-stack fa-lg">
                                                <i class="fa fa-spinner fa-spin fa-stack-2x fa-fw"></i>
                                            </span>
                                            <p class="mt-3 mb-2">Data sedang diproses.</p>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-action text-right p-3">
                <button class="btn btn-secondary" type="submit" id="simpan_level">
                    <span class="btn-label mr-2"><i id="spin" class="fa fa-plus"></i></span>Simpan Data
                </button>
                <button class="btn btn-secondary" type="button" id="update_level">
                    <span class="btn-label mr-2"><i id="spin" class="fa fa-plus"></i></span>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

</div>
