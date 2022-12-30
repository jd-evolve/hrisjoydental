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
        rekapijincuti();
    });

    $('select[name="filter-ijincuti"]').change(function() {
        rekapijincuti();
    });

    $('select[name="filter-periode"]').change(function() {
        rekapijincuti();
    });

    $('select[name="filter-status"]').change(function() {
        rekapijincuti();
    });

    rekapijincuti();
    function rekapijincuti(){
        var periode = $('select[name="filter-periode"]').val();
        var status = $('select[name="filter-status"]').val();
        var ijincuti = $('select[name="filter-ijincuti"]').val();
        var karyawan = $('select[name="filter-karyawan"]').val();
        var id_ijincuti = ijincuti == "" ? null : ijincuti;
        var id_karyawan = karyawan == "" ? null : karyawan;

        var table_rekapijincuti = $("#datatable-rekapijincuti").DataTable({
            ajax: {
                url: "rekapdata/read_rekapijincuti",
                type: "POST",
                data: {
                    periode: periode,
                    status: status,
                    id_ijincuti: id_ijincuti,
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
                emptyTable: "Belum ada daftar rekap ijn/cuti!",
                infoEmpty: "Tidak ada data untuk ditampilkan!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: ""
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [ ],
            columns: [
                { data: "No" },
                { data: "Periode" },
                { data: "Atasan" },
                { data: "Karyawan" },
                { data: "IjinCuti" },
                { data: "Awal" },
                { data: "Akhir" },
                { data: "Potong" },
                { data: "Status" , render : function ( data, type, row, meta ) {
                    var stts = "";
                    if(data == 0){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Diajukan Atasan</span>';
                    }else if(data == 1){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Diajukan Personalia</span>';
                    }else if(data == 2){
                        stts = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Disetujui</span>';
                    }else if(data == 3){
                        stts = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">Ditolak</span>';
                    }
                    return type === 'display' ? stts : data;
                }},
                { data: "Aksi" , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                    '<button type="button" data-id="'+data+'" id="show-form" class="btn btn-icon btn-round btn-secondary btn-sm" title="Lihat ijin/cuti dan lakukan acc atau tolak.">'+
                        '<i class="fa fa-eye"></i>'+
                    '</button>':
                    data;
                }},
            ],
        });
        
        $('body').on('click','#show-form', function(){
            $("#modal-showform").modal();
            let id_ijincuti_list = $(this).data('id');
            $.ajax({
                url: 'ijincuti/detail_ijincuti',
                method: "POST",
                dataType: "json",
                data: {
                    id_ijincuti_list: id_ijincuti_list
                },
                success: function (data) {
                    $("#show-ket_ijincuti").html(data.ijincuti);
                    var stts = "";
                    if(data.status == 0 || data.status == 1){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Diajukan</span>';
                    }else if(data.status == 2){
                        stts = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Disetujui</span>';
                    }else if(data.status == 3){
                        stts = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">Ditolak</span>';
                    }
                    document.getElementById("text-showform").innerHTML = 'Status : '+stts;
                    $("#show-tgl_create").html(data.tgl_create);
                    $("#show-keperluan").html(data.keperluan);
                    $("#show-tgl_awal").html(data.tgl_awal);
                    $("#show-tgl_akhir").html(data.tgl_akhir);
                    $("#show-total_hari").html(data.total_hari);
                    $("#show-total_menit").html(data.total_menit);
        
                    if(data.file == '-'){
                        $("#show-file").html('-');
                    }else{
                        $("#show-file").html('<a class="text-info pointer" data-file="'+data.file+'" id="btn-file">'+data.file+'</a>');
                    }
                    
                    if(data.alasan_ditolak){
                        $('.alasan-ditolak').removeClass('none');
                        $("#show-alasan_ditolak").html(data.alasan_ditolak);
                    }else{
                        $('.alasan-ditolak').addClass('none');
                    }

                    var disetujui = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Menyetujui</span>';
                    var ditolak = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">Menolak</span>';
                    var diproses = '<span class="btn btn-default fw-bold btn-xs py-0 px-1">. . . . . . .</span>';
                    if(data.status == 0){
                        $("#cek-atasan").html(diproses+'<br><span>'+data.nama_atasan+'</span>');
                        $("#cek-personalia").html(diproses+'<br><span>'+data.nama_personalia+'</span>');
                    }else if(data.status == 1){
                        $("#cek-atasan").html(disetujui+'<br><span>'+data.nama_atasan+'</span>');
                        $("#cek-personalia").html(diproses+'<br><span>'+data.nama_personalia+'</span>');
                    }else if(data.status == 2){
                        $("#cek-atasan").html(disetujui+'<br><span>'+data.nama_atasan+'</span>');
                        $("#cek-personalia").html(disetujui+'<br><span>'+data.nama_personalia+'</span>');
                    }else if(data.status == 3){
                        if(data.id_personalia != null){
                            $("#cek-atasan").html(disetujui+'<br><span>'+data.nama_atasan+'</span>');
                            $("#cek-personalia").html(ditolak+'<br><span>'+data.nama_personalia+'</span>');
                        }else{
                            $("#cek-atasan").html(ditolak+'<br><span>'+data.nama_atasan+'</span>');
                            $("#cek-personalia").html(diproses+'<br><span>'+data.nama_personalia+'</span>');
                        }
                    }

                },
            });
        });
    }
})(jQuery);
