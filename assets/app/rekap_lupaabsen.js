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
        rekaplupaabsen();
    });

    $('select[name="filter-periode"]').change(function() {
        rekaplupaabsen();
    });

    rekaplupaabsen();
    function rekaplupaabsen(){
        var periode = $('select[name="filter-periode"]').val();
        var karyawan = $('select[name="filter-karyawan"]').val();
        var id_karyawan = karyawan == "" ? null : karyawan;

        var table_rekaplupaabsen = $("#datatable-rekaplupaabsen").DataTable({
            ajax: {
                url: "rekapdata/read_rekaplupaabsen",
                type: "POST",
                data: {
                    periode: periode,
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
                emptyTable: "Belum ada daftar rekap lupa absen!",
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
                { data: "Lupa" },
            ],
        });
    }
})(jQuery);
