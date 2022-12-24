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
            <table id="datatable-jadwalkerja" class="table-responsive display nowrap table table-striped table-hover" >
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:30%;">Nama</th>
                        <th style="width:65%;">Keterangan</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-jadwalkerja" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-jadwalkerja" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="text-jadwalkerja">Jadwal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <div class="box-bg-grey mb-3">
                                        <div class="table-responsive">
                                            <table class="mb-0" width="100%">
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
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-scanlog table-bordered table-bordered-bd-gray mb-0">
                                            <thead>
                                                <tr style="background: #e8ebf1" class="text-center">
                                                    <th style="width:10%;">Hari</th>
                                                    <th style="width:5%;">Libur</th>
                                                    <th style="width:17%;">Jk-1</th>
                                                    <th style="width:17%;">Jk-2</th>
                                                    <th style="width:17%;">Jk-3</th>
                                                    <th style="width:17%;">Jk-4</th>
                                                    <th style="width:17%;">Jk-5</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; for($i=1; $i<=7; $i++){ ?>
                                                <tr>
                                                    <td><?= $hari[$i==7?0:$i] ?></td>
                                                    <td class="text-center"><input class="form-check-input ml-0 check-lbr" data-idh="<?= $i==7?0:$i ?>" type="checkbox" name="lbr-<?= $i==7?0:$i ?>" id="lbr-<?=$i==7?0:$i ?>"></td>
                                                    <?php for($x=1; $x<=5; $x++){ ?>
                                                    <td>
                                                        <select class="form-control form-rm min-rm slct-jk" data-idh="<?= $i==7?0:$i ?>" name="jk<?= $i==7?0:$i ?>-<?= $x ?>" id="jk<?= $i==7?0:$i ?>-<?= $x ?>">
                                                            <option value="" selected></option>
                                                            <?php foreach ($data_jamkerja as $list) { ?>
                                                            <option value="<?= $list->id_jam_kerja ?>"><?= $list->nama_jam_kerja ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_jadwal_kerja">
                        <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal" aria-label="Close">Kembali</button>
                        <input class="btn btn-success btn-sm" type="submit" name="add-edit" id="add-edit" value="Tambah" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>