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
                        <label class="label-filter">Posisi: </label>&nbsp;&nbsp;
                        <select class="form-control" name="filter-posisi" id="filter-posisi">
                            <option value="">Semua</option>
                            <?php foreach ($data_posisi as $list) { 
                                if($list->id_posisi == 2){ }
                                else if($list->id_posisi == 13){ }
                                else {
                            ?>
                                <option value="<?= $list->id_posisi.'-' ?>"><?= $list->nama_posisi ?></option>
                            <?php } } ?>
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
            <table id="datatable-member" class="table-responsive display table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:20%;">Nama</th>
                        <th style="width:20%;">Posisi</th>
                        <th style="width:10%;">No.Hp</th>
                        <th style="width:20%;">Email</th>
                        <th style="width:20%;">Alamat</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-member" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-member" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="text-member">Member</h5>
                        <a type="button" class="close" href="">
                        <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Kode</label>
                                            <input type="text" class="form-control" name="kode" placeholder="Kode" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>No. Induk</label>
                                            <input type="text" class="form-control" name="nomor_induk" placeholder="No. Induk" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="nama" placeholder="Nama" style="height:0;" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Gender</label>
                                            <select class="form-control" name="gender" id="gender" required>
                                                <option value="">Pilih Gender</option>
                                                <option value="1">L</option>
                                                <option value="0">P</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Tgl Lahir</label>
                                            <input type="text" class="form-control tgl" name="tgl_lahir" placeholder="Tgl Lahir" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>No. Hp</label>
                                            <input type="text" class="form-control" id="nohp" name="nohp" placeholder="No. Hp" style="height:0;" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>E-mail</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group form-group-default">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" style="height:0;" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Nama Bank</label>
                                            <input type="text" class="form-control" name="nama_bank" placeholder="Nama Bank" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>No. Rek</label>
                                            <input type="text" class="form-control" name="no_rek" placeholder="No. Rek" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label>Nama Rek</label>
                                            <input type="text" class="form-control" name="nama_rek" placeholder="Nama Rek" style="height:0;" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <div class="form-group form-group-default">
                                            <label>Sisa Cuti</label>
                                            <input type="text" class="form-control" name="sisa_cuti" placeholder="Sisa Cuti" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Tgl Masuk</label>
                                            <input type="text" class="form-control tgl" id="tgl_masuk" name="tgl_masuk" style="height:0;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default">
                                            <label>Posisi</label>
                                            <select class="form-control" name="posisi" id="posisi" required>
                                                <option value="">Pilih Posisi</option>
                                                <?php foreach ($data_posisi as $list) { ?>
                                                    <option value="<?= $list->id_posisi ?>"><?= $list->nama_posisi ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Kota Klinik</label>
                                            <select class="form-control" name="kota" id="kota" required>
                                                <option value="">Pilih Kota</option>
                                                <?php foreach ($data_kota as $list) { ?>
                                                    <option value="<?= $list->id_kota ?>"><?= $list->nama_kota ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    </div>
                    <div class="modal-footer">
                        <input class="btn btn-primary" type="submit" name="add_member" id="add_member" value="Tambah" style="padding:9px" size="7" readonly>
                        <input class="btn btn-primary" type="hidden" name="edit_member" id="edit_member" value="Ubah" style="padding:9px" size="7" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>