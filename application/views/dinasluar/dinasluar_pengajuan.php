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
            <table id="datatable-dinasluar" class="table-responsive display table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:20%;">Tujuan</th>
                        <th style="width:30%;">Nama</th>
                        <th style="width:20%;">Tanggal</th>
                        <th style="width:20%;">Keperluan</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>