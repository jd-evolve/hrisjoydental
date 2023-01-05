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
        rekaplembur();
    });

    $('select[name="filter-periode"]').change(function() {
        rekaplembur();
    });

    $('select[name="filter-status"]').change(function() {
        rekaplembur();
    });

    rekaplembur();
    function rekaplembur(){
        var periode = $('select[name="filter-periode"]').val();
        var status = $('select[name="filter-status"]').val();
        var karyawan = $('select[name="filter-karyawan"]').val();
        var id_karyawan = karyawan == "" ? null : karyawan;

        var table_rekaplembur = $("#datatable-rekaplembur").DataTable({
            ajax: {
                url: "rekapdata/read_rekaplembur",
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
                emptyTable: "Belum ada daftar rekap lembur!",
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
                { data: "Bagian" },
                { data: "Total" },
                { data: "Status" , render : function ( data, type, row, meta ) {
                    var stts = "";
                    if(data == 1){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Diajukan</span>';
                    }else if(data == 2){
                        stts = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Disetujui</span>';
                    }else if(data == 3){
                        stts = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">Ditolak</span>';
                    }
                    return type === 'display' ? stts : data;
                }},
                { data: "Aksi" , render : function ( data, type, row, meta ) {
                    var dt = 'data-id="'+data+'" data-ida="'+row['id_atasan']+'" data-idk="'+row['id_karyawan']+'"';
                    var kr = 'data-nama="'+row['Karyawan']+'" data-atasan="'+row['Atasan']+'" data-jabatan="'+row['Jabatan']+'" data-bagian="'+row['Bagian']+'" data-periode="'+row['Periode']+'"';
                    return type === 'display'  ?
                    '<button type="button" '+dt+' '+kr+' id="show-lembur" class="btn btn-icon btn-round btn-secondary btn-sm" title="Lihat ijin/cuti dan lakukan acc atau tolak.">'+
                        '<i class="fa fa-eye"></i>'+
                    '</button>':
                    data;
                }},
            ],
        });
    
        $('body').on('click','#show-lembur', function(){
            $("#modal-showlembur").modal();
            let id_periode = $(this).data('id');
            let id_atasan = $(this).data('ida');
            let id_karyawan = $(this).data('idk');
            $('#show-nama').html($(this).data('nama'));
            $('#show-jabatan').html($(this).data('jabatan'));
            $('#show-bagian').html($(this).data('bagian'));
            $('#show-periode').html($(this).data('periode'));
            $('#show-atasan').html($(this).data('atasan'));

            $.ajax({
                url: "absensi/karyawan_lembur",
                method: "POST",
                dataType: "json",
                data: {
                    id_periode: id_periode,
                    id_atasan: id_atasan,
                    id_karyawan: id_karyawan,
                },
                success: function (data) {
                    var html = "";
                    $("#tabel-listlembur tbody").html(html);
                    $('#simpan_lembur').addClass('none');
                    console.log(data.length)
                    let total = 0;
                    for (var i=0; i<data.length; i++) {
                        html += 
                        '<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            '<td>'+data[i].tanggal+'</td>'+
                            '<td>'+data[i].jm_mulai+'</td>'+
                            '<td>'+data[i].jm_selesai+'</td>'+
                            '<td class="'+(data[i].status == 3 ? 'text-line-through' : '')+'">'+data[i].jumlah+'</td>'+
                            '<td class="nowraping">'+(data[i].kategori == 1 ? 'diluar jam kerja' : 'range jam kerja')+'</td>'+
                            '<td>'+data[i].keterangan+'</td>'+
                            '<td>'+
                                (data[i].status == 1 ? 'diajukan' : 
                                    (data[i].status == 2 ? 
                                        ('<span class="btn btn-success fw-bold btn-xs py-0 px-1">disetujui</span>') : 
                                        ('<span class="btn btn-danger fw-bold btn-xs py-0 px-1">ditolak</span> <br> ('+data[i].alasan+')')
                                    )
                                )+
                            '</td>'+
                        '</tr>';
                        total += data[i].status == 2 ? parseInt(data[i].jumlah) : 0;
                    }
                    html += '<tr>'+
                                '<td colspan="4" class="text-right"><b>Total Keseluruhan Lembur</b> (menit)</td>'+
                                '<td><b>'+total+'</b></td>'+
                            '</tr>';
                    $("#tabel-listlembur tbody").html(html);
                },
            });
        });

    }
})(jQuery);
