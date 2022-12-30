<!--   Core JS Files   -->
<script src="<?= base_url() ?>assets/js/core/jquery.3.2.1.min.js"></script>
<script src="<?= base_url() ?>assets/js/core/popper.min.js"></script>
<script src="<?= base_url() ?>assets/js/core/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/moment/moment.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/chart/chart.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/datatables/datatables.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/morris/morris.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/raphael/raphael.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/select2/select2.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/datepickerange/daterangepicker.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/export_files/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/export_files/datatables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/export_files/datatables.fixedcolumns.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/export_files/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/export_files/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/export_files/img-popup.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/tabletoexcel/tableToExcel.js"></script>
<script src="<?= base_url() ?>assets/js/plugin/currency-format/currency-format.js"></script>
<script src="<?= base_url();?>assets/js/plugin/inputmask/jquery.inputmask.js"></script>
<script src="<?= base_url();?>assets/js/plugin/signature/jquery.signature.js"></script>
<script src="<?= base_url();?>assets/js/plugin/color-calender/color-calender.js"></script>
<script src="<?= base_url() ?>assets/js/ready.js?v=<?= $vrs ?>"></script>

<!-- App JS-->
<?php 
    $ijincuti = array(
        'cuti-tahunan',
        'cuti-menikah',
        'cuti-melahirkan',
        'ijin-pribadi',
        'ijin-duka',
        'ijin-sakit',
    );
    $uri_path = $this->uri->segment(1);
    $filejs = in_array($uri_path, $ijincuti) ? 'ijin_cuti' : str_replace("-","_",$uri_path);

?>
<script src="<?= base_url() ?>assets/app/<?= $filejs ?>.js?v=<?= $vrs ?>"></script> 