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
                <div class="col-sm-6">
                    <div class="btn-group border-option my-1">
                        <label class="label-filter">Periode: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-periode" id="filter-periode">
                                <?php foreach ($data_periode as $list) { ?>
                                    <option value="<?= $list->id_periode ?>"><?= $list->keterangan ?></option>
                                <?php }?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
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
            <table id="datatable-rekaplupaabsen" class="table-responsive display table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:30%;">Periode</th>
                        <th style="width:45%;">Karyawan</th>
                        <th style="width:15%;">Bagian</th>
                        <th style="width:10%; white-space:nowrap;">Lupa Absen</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>