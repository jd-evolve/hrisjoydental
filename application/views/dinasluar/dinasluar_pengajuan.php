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

    <div id="show-1" class="">
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

    <div id="show-2" class="none">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <button class="btn btn-xs mr-3" id="btn-back" title="Kembali ke data dinas"><span class="fa fa-chevron-left"></span></button>
                            <h4 class="card-title">Menu Dinas Diluar</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills nav-secondary" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active show" id="menu-pengajuan" data-toggle="pill" role="tab" aria-selected="true">Data Pengajuan</a>
                            <a class="nav-link" id="menu-akomodasi" data-toggle="pill" role="tab" aria-selected="false">Permohonan Akomodasi</a>
                            <a class="nav-link" id="menu-perjalanan" data-toggle="pill" role="tab" aria-selected="false">Laporan Perjalanan</a>
                            <a class="nav-link" id="menu-reimburse" data-toggle="pill" role="tab" aria-selected="false">Laporan Reimburse</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        okokok
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>