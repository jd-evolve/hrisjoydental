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
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Data Periode</div>
                        <div class="card-category mt-0 mb-2">Tentukan periode cut off dan total jumlah shift.</div>
                        <div class="box-bg-grey">
                            <table class="mb-0" width="100%">
                                <tbody class="nowraping">
                                    <tr valign="top">
                                        <td width="10%">Periode Awal<span class="text-danger">*</span></td>
                                        <td width="2%">&nbsp:&nbsp</td>
                                        <td width="88%"><input type="text" name="tgl_awal" class="tgl input-line bg-transparent p-0 width-full tgl-wkt" placeholder="dd-mm-yyyy" required></td>
                                    </tr>
                                    <tr valign="top">
                                        <td>Periode Akhir<span class="text-danger">*</span></td>
                                        <td>&nbsp:&nbsp</td>
                                        <td><input type="text" name="tgl_akhir" class="tgl input-line bg-transparent p-0 width-full tgl-wkt" placeholder="dd-mm-yyyy" required></td>
                                    </tr>
                                    <tr valign="top">
                                        <td>Jumlah Shift<span class="text-danger">*</span></td>
                                        <td>&nbsp:&nbsp</td>
                                        <td><input type="number" name="total_hari" class="input-line bg-transparent p-0 text-right" style="width:35px;" min="0" required> Shift</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="card-title">Hari Libur</div>
                        <div class="card-category mt-0 mb-2">Masukan hari libur selain hari minggu (optional).</div>
                        <div class="box-bg-grey">
                            <table class="mb-0" width="100%">
                                <tbody class="nowraping">
                                    <tr valign="top">
                                        <td width="10%">Tgl Hari</td>
                                        <td width="2%">&nbsp:&nbsp</td>
                                        <td width="88%"><input type="text" name="tgl_libur" class="tgl input-line bg-transparent p-0 width-full tgl-wkt" placeholder="dd-mm-yyyy"></td>
                                    </tr>
                                    <tr valign="top">
                                        <td>Keterangan</td>
                                        <td>&nbsp:&nbsp</td>
                                        <td><input type="text" name="ket_libur" class="input-line bg-transparent p-0 width-full tgl-wkt" placeholder=". . ."></td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="3"><button id="add-harilibur" class="btn btn-default btn-xs">Tambah</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="table-responsive">
                                <table id="tabel-harilibur" class="table table-scanlog table-bordered table-bordered-bd-gray mt-2 mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th class="text-center">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" colspan="4">Belum ada libur di lain hari minggu</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="separator-solid"></div>
                        <div class="card-title">Upload Scanlog</div>
                        <div class="card-category mt-0 mb-2">Upload data scanlog dengan format excel.</div>
                        <div class="box-bg-grey">
                            <b>Penting!</b>
                            <ol class="m-0 pl-4" class="s">
                                <li>Pastika file excel yang di import sesuai dengan format data yang telah ditentukan.</li>
                                <li>Data file header pada excel dimulai dari baris ke 1.</li>
                                <li>Format header : | Tanggal Scan | Tanggal | Jam | PIN | Nama | SN |</li>
                            </ol>
                            <div class="form-group">
                                <label class="control-label">File Scanlog<span class="text-danger">*</span></label>
                                <br>
                                <input type="file" name="file_scanlog" id="file_scanlog" accept=".xls, .xlsx" required="">      
                            </div> 
                        </div>
                        <div class="separator-solid"></div>
                        <div class="text-right mt-3">
                            <span class="load-spin p-4 text-secondary none"><i class="fa fa-spinner fa-spin m-1"></i>Loading. . .</span>
                            <div id="button-footer" class="">
                                <button class="btn btn-danger btn-sm" type="button" id="reset">Reset</button>
                                <button class="btn btn-success btn-sm" type="button" id="simpan-scanlog">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-periode" class="table-responsive display table table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th style="width:5%;">No</th>
                                    <th style="width:40%;">P.Awal</th>
                                    <th style="width:40%;">P.Akhir</th>
                                    <th style="width:10%;">J.Shift</th>
                                    <th style="width:5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="show-2" class="none">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <button class="btn btn-xs mr-3" id="btn-back" title="Kembali ke rekap scanlog"><span class="fa fa-chevron-left"></span></button>
                            <h4 class="card-title">Data Hasil Scanlog</h4>
                        </div>
                    </div>
                    <div class="card-body bg-green-smooth3">
                        <div class="table-responsive nowraping">
                            <table class="table tabnote mb-0">
                                <tbody>
                                    <tr>
                                        <td style="width:23%;"><b>Periode Awal</b></td>
                                        <td style="width:2%;"><b>&nbsp;:&nbsp;</b></td>
                                        <td style="width:75%;" id="show-awal"> </td>
                                    </tr>
                                    <tr>
                                        <td><b>Periode Akhir</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td id="show-akhir"> </td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Shift</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td id="show-shift"> </td>
                                    </tr>
                                    <tr>
                                        <td><b>Karyawan</b></td>
                                        <td><b>&nbsp;:&nbsp;</b></td>
                                        <td id="show-karyawan"> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tabel-harilibur" class="table table-scanlog table-bordered table-bordered-bd-gray mb-0">
                            <thead>
                                <tr style="background: #f7f8fa">
                                    <th class="text-center">No</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan Hari Libur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="4">Belum ada libur di lain hari minggu</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group border-option my-1">
                            <label class="label-filter">Karyawan: </label>&nbsp;&nbsp;
                            <select class="form-control" name="filter-karyawan" id="filter-karyawan">
                                <option value="0">Pilih Karyawan</option>
                                <?php foreach ($data_karyawan as $list) { ?>
                                    <option value="<?= $list->id_account ?>"><?= $list->nama ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-scanlog table-bordered table-bordered-bd-gray mt-2 mb-0" id="table-scanlog">
                                <thead>
                                    <tr style="background: #f7f8fa">
                                        <th style="width:5%;">No</th>
                                        <th style="width:15%;">Tanggal</th>
                                        <th style="width:10%;">Masuk</th>
                                        <th style="width:10%;">Pulang</th>
                                        <th style="width:10%;">Lbr</th>
                                        <th style="width:10%;">Tlt</th>
                                        <th style="width:10%;">Sft</th>
                                        <th style="width:10%;">Libur</th>
                                        <th style="width:20%;">Keterangan</th>
                                        <th style="width:5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="10" style="margin:2px; width:100%; font-size:14px; height:40px; background-color:#f4f4f4;"><center>Pilih karyawan untuk menampilkan data!</center></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modal-editscanlog" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <form id="form-editscanlog" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                    <input type="hidden" name="id_scanlog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data Scan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-group">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-scanlog table-bordered table-bordered-bd-gray mb-0">
                                                <thead>
                                                    <tr style="background: #f7f8fa">
                                                        <th style="width:15%;">Tanggal</th>
                                                        <th style="width:15%;">Masuk</th>
                                                        <th style="width:15%;">Pulang</th>
                                                        <th style="width:10%;">Lbr</th>
                                                        <th style="width:10%;">Tlt</th>
                                                        <th style="width:10%;">Sft</th>
                                                        <th style="width:25%;">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="tgl-scn">...</td>
                                                        <td><input type="text" class="form-control form-rm min-rm2 waktu" name="masuk" id="masuk" required></td>
                                                        <td><input type="text" class="form-control form-rm min-rm2 waktu" name="pulang" id="pulang" required></td>
                                                        <td><input type="number" class="form-control form-rm min-rm" min="0" name="lbr" id="lbr" required></td>
                                                        <td><input type="number" class="form-control form-rm min-rm" min="0" name="tlt" id="tlt" required></td>
                                                        <td><input type="number" class="form-control form-rm min-rm" min="0" name="sft" id="sft" required></td>
                                                        <td><input type="text" class="form-control form-rm" name="ket" id="ket"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="modal-footer py-2">
                            <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Batal</button>
                            <button class="btn btn-success btn-sm" id="edit_scanlog">Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>