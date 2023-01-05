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
            <table id="datatable-rekapgaji" class="table-responsive display table table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width:5%;">No</th>
                        <th style="width:30%;">Periode</th>
                        <th style="width:35%;">Karyawan</th>
                        <th style="width:15%;">Bagian</th>
                        <th style="width:15%;">Total</th>
                        <th style="width:10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-showform" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form id="form-showform" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Slip Gaji </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-group">
                            <div id="slip-gaji">
                                <style type="text/css">
                                    .table-slip-gaji {
                                        width: 100% !important;
                                        border-collapse: collapse;
                                        table-layout: fixed;
                                        vertical-align: top;
                                        color: #000;
                                    }
                                    .table-slip-gaji > tbody > tr > td,
                                    .table-slip-gaji > tbody > tr > th {
                                        border: 2px solid #000 !important;
                                        padding: 2px;
                                    }
                                    .tb-td {
                                        padding: 35px !important;
                                        line-height: 1.5;
                                    }
                                    .w100 {
                                        width: 100%;
                                    }
                                    .align-top {
                                        vertical-align: top;
                                    }
                                    .right-text {
                                        text-align: right;
                                    }
                                    .left-text {
                                        text-align: left;
                                    }
                                    .border-bottom {
                                        border-bottom: 2px solid #000 !important;
                                    }
                                    .border-top-bottom {
                                        border-top: 1.5px solid #000 !important;
                                        border-bottom: 1.5px solid #000 !important;
                                    }
                                    .border-top-bottom-double {
                                        border-top: 1.5px solid #000 !important;
                                        border-bottom: 3px double #000 !important;
                                    }
                                    .p4 {
                                        padding: 4px;
                                    }
                                </style>
                                <table class="table-slip-gaji">
                                    <tr>
                                        <td class="tb-td">
                                            <table class="w100">
                                                <tr class="border-bottom">
                                                    <td colspan="2" style="width:49%;" class="left-text">
                                                        <b>KLINIK GIGI JOYDENTAL</b>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td colspan="2" style="width:49%;" class="right-text">
                                                        <b>SLIP GAJI</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td>&nbsp;</td>
                                                    <td colspan="2" class="right-text">
                                                        <b><span id="list-periode"></span></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <table class="w100">
                                                            <tr>
                                                                <td style="width:18%;">NIP</td>
                                                                <td style="width:7%;">&nbsp;:&nbsp;</td>
                                                                <td id="list-nik"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nama</td>
                                                                <td>&nbsp;:&nbsp;</td>
                                                                <td id="list-nama"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Email</td>
                                                                <td>&nbsp;:&nbsp;</td>
                                                                <td id="list-email"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td colspan="2">
                                                        <table class="w100">
                                                            <tr>
                                                                <td style="width:18%;">Jabatan</td>
                                                                <td style="width:7%;">&nbsp;:&nbsp;</td>
                                                                <td id="list-jabatan"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade</td>
                                                                <td>&nbsp;:&nbsp;</td>
                                                                <td id="list-grade"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Cabang</td>
                                                                <td>&nbsp;:&nbsp;</td>
                                                                <td id="list-cabang"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><div class="p4"></div></td>
                                                </tr>
                                                <tr class="border-top-bottom">
                                                    <td colspan="2"><b>P E N E R I M A A N</b></td>
                                                    <td>&nbsp;</td>
                                                    <td colspan="2"><b>P O T O N G A N</b></td>
                                                </tr>
                                                <tr>
                                                    <td> 
                                                        Gaji Tetap <br>
                                                        Uang Makan <br>
                                                        Uang Transport <br>
                                                        Uang Lembur <br>
                                                        Insentif <br>
                                                        Tunjangan <br>
                                                        &emsp;- Jabatan <br>
                                                        &emsp;- SIP <br>
                                                        &emsp;- PPh 21 <br>
                                                        Dinas Luar <br>
                                                        Masuk Hari Libur <br>
                                                        Tambahan Shift <br>
                                                        Bonus/THR <br>
                                                        Lainnya
                                                    </td>
                                                    <td class="right-text"> 
                                                        <span id="pen-gaji_tetap"></span> <br>
                                                        <span id="pen-uang_makan"></span> <br>
                                                        <span id="pen-uang_transport"></span> <br>
                                                        <span id="pen-uang_lembur"></span> <br>
                                                        <span id="pen-insentif"></span> <br>
                                                        <br>
                                                        <span id="pen-tunjangan_jabatan"></span> <br>
                                                        <span id="pen-tunjangan_str"></span> <br>
                                                        <span id="pen-tunjangan_pph21"></span> <br>
                                                        <span id="pen-dinas_luar"></span> <br>
                                                        <span id="pen-masuk_hari_libur"></span> <br>
                                                        <span id="pen-tambahan_shift"></span> <br>
                                                        <span id="pen-bonus_thr"></span> <br>
                                                        <span id="pen-lainnya_terima"></span> <br>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td class="align-top"> 
                                                        Keterlambatan <br>
                                                        BPJS <br>
                                                        &emsp;- Kesehatan <br>
                                                        &emsp;- Tenaga Kerja <br>
                                                        Cicilan Pinjaman <br>
                                                        Biaya Transfer <br>
                                                        PPh 21 <br>
                                                        Lainnya
                                                     </td>
                                                    <td class="right-text align-top"> 
                                                        <span id="pot-keterlambatan"></span> <br>
                                                        <br>
                                                        <span id="pot-bpjs_kesehatan"></span> <br>
                                                        <span id="pot-bpjs_tk"></span> <br>
                                                        <span id="pot-cicilan"></span> <br>
                                                        <span id="pot-biaya_transfer"></span> <br>
                                                        <span id="pot-pajak_pph21"></span> <br>
                                                        <span id="pot-lainnya_potong"></span> <br>
                                                    </td>
                                                </tr>
                                                <tr class="border-top-bottom-double">
                                                    <td><b>Total Penerimaan</b></td>
                                                    <td class="right-text"><b> <span id="total-penerimaan"></span> </b></td>
                                                    <td>&nbsp;</td>
                                                    <td><b>Total Potongan</b></td>
                                                    <td class="right-text"><b> <span id="total-potongan"></span> </b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><div class="p4"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Take Home Pay</b></td>
                                                    <td class="right-text"><b> <span id="total-gaji"></span> </b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5"><div class="p4"></div></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                        Ditransfer Ke : &emsp;
                                                        <span id="nama_bank"></span> &emsp; 
                                                        <span id="no_rek"></span> &emsp; 
                                                        <span id="nama_rek"></span> &emsp;
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Kembali</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>