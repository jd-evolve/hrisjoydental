(function ($) {
    $("#filter-karyawan").select2({width: '100%'});
    $(".select2-selection--single").css({
        "height":"calc(2.25rem + 2px)", 
        "padding":"0.3rem 0.4rem", 
        "line-height":"1.5", 
        "max-width":"230px",
        "border": "transparent",
        "background-color":"transparent"
    });
    
    $('select[name="filter-karyawan"]').change(function() {
        rekapketerlambatan();
    });

    $('select[name="filter-periode"]').change(function() {
        rekapketerlambatan();
    });

    $('select[name="filter-status"]').change(function() {
        rekapketerlambatan();
    });

    rekapketerlambatan();
    function rekapketerlambatan(){
        var periode = $('select[name="filter-periode"]').val();
        var status = $('select[name="filter-status"]').val();
        var karyawan = $('select[name="filter-karyawan"]').val();
        var id_karyawan = karyawan == "" ? null : karyawan;

        var table_rekapketerlambatan = $("#datatable-rekapketerlambatan").DataTable({
            ajax: {
                url: "rekapdata/read_rekapketerlambatan",
                type: "POST",
                data: {
                    periode: periode,
                    status: status,
                    id_karyawan: id_karyawan,
                },
            },
            order: [],
            ordering: false,
            bDestroy: true,
            processing: true,
            bAutoWidth: false,
            deferRender: true,
            aLengthMenu: [
                [20, 40, 60, -1],
                [20, 40, 60, "All"],
            ],
            columnDefs: [
                {
                    "targets": '_all',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        let style = 'padding-bottom: 8px !important; padding-top: 8px !important;'
                        $(td).attr('style', style);
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                emptyTable: "Belum ada daftar rekap keterlambatan!",
                infoEmpty: "Tidak ada data untuk ditampilkan!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: ""
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [ ],
            columns: [
                { data: "No" },
                { data: "Periode" },
                { data: "Karyawan" },
                { data: "Bagian" },
                { data: "Total" },
                { data: "Terlambat" },
                { data: "Status" , render : function ( data, type, row, meta ) {
                    var stts = "";
                    if(data == 1){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Keterlambatan Biasa</span>';
                    }else if(data == 2){
                        stts = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">8x Keterlambatan</span>';
                    }else if(data == 3){
                        stts = '<span class="btn btn-default fw-bold btn-xs py-0 px-1">Berturut 5x Terlambat</span>';
                    }
                    return type === 'display' ? stts : data;
                }},
            ],
        });
    }
})(jQuery);
