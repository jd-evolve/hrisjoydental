(function ($) {
    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    const arrHlibur = [];
    $('#add-harilibur').on('click', function(){
        var tgl_libur = $('input[name="tgl_libur"]').val();
        var ket_libur = $('input[name="ket_libur"]').val();
        if(tgl_libur.search("_") == -1 && tgl_libur != ''){
            var cek = true;
            var hlibur = {
                'tgl_libur':tgl_libur,
                'ket_libur':ket_libur
            };
            for(var i=0; i<arrHlibur.length; i++){
                if(arrHlibur[i].tgl_libur == tgl_libur){
                    cek = false;
                }
            }
            if(cek){
                arrHlibur.push(hlibur);
                $('input[name="tgl_libur"]').val('');
                $('input[name="ket_libur"]').val('');
            }else{
                notif('error', 'Tanggal hari libur sudah tersedia!');
            }
            listHlibur();
        }else{
            notif('error', 'Tanggal hari libur tidak sesuai!');
        }
    });
    
    $('body').on('click','#del_libur',function(){
        let index = $(this).data('index');
        arrHlibur.splice(index,1);
        listHlibur();
    });

    function listHlibur(){
        var html = "";
        if(arrHlibur.length > 0){
            for(var i=0; i<arrHlibur.length; i++) {
                let tgl_libur = arrHlibur[i].tgl_libur;
                let ket_libur = arrHlibur[i].ket_libur;
                
                html += '<tr>' +
                            '<th class="text-center">'+(i+1)+'</th>'+
                            '<td>'+tgl_libur+'</td>' +
                            '<td>'+ket_libur+'</td>'+
                            '<td class="text-center"><a id="del_libur" data-index="'+i+'" class="text-danger pointer"><i class="fa fa-trash"></i></a></td>'+
                        '</tr>';
            }
        }else{
            html = '<tr><td class="text-center" colspan="4">Belum ada libur di lain hari minggu</td></tr>';
        }
        $("#tabel-harilibur tbody").html(html);
    };

    $('#simpan-scanlog').on('click', function(){
        $('.load-spin').removeClass('none');
        $('#button-footer').addClass('none');
        var tgl_awal = $('input[name="tgl_awal"]').val();
        var tgl_akhir = $('input[name="tgl_akhir"]').val();
        var total_hari = $('input[name="total_hari"]').val();
        if(tgl_awal.search("_") == -1 && tgl_akhir.search("_") == -1 && total_hari != '' && tgl_awal != '' && tgl_akhir != ''){
            let formData = new FormData(); 
            formData.append('tgl_awal', tgl_awal);
            formData.append('tgl_akhir', tgl_akhir);
            formData.append('total_hari', total_hari);
            formData.append("file_scanlog", $('#file_scanlog')[0].files[0]);
            formData.append("hari_libur", JSON.stringify(arrHlibur));
            $.ajax({
                url: "absensi/add_scanlog",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    if (result=="error") { count=0; }
                    notif(result, message, 1);
                },
            });
        }else{
            notif('error', 'Data Periode tidak lengkap atau tidak sesuai!');
        }
    });

    read_scanlog();
    function read_scanlog(){
        var table_periode = $("#datatable-periode").DataTable({
            ajax: {
                url: "absensi/read_periode",
                type: "GET",
            },
            order: [],
            ordering: false,
            bDestroy: true,
            bAutoWidth: false,
            deferRender: true,
            aLengthMenu: [
                [10, 30, 50, -1],
                [10, 30, 50, "All"],
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
                emptyTable: "Belum ada daftar data scanlog!",
                infoEmpty: "Tidak ada data!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: ""
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [ ],
            columns: [
                { data: "No" },
                { data: "Awal" },
                { data: "Akhir" },
                { data: "Shift" },
                { data: "Aksi" , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                    '<a class="btn btn-default btn-sm btn-link" id="show-data" data-id="'+data+'">'
                        +'<span class="btn-label just-icon"><i class="fas fa-eye"></i> </span>'
                    +'</a>' : data;
                }},
            ],
        });

        $('body').on('click','#show-data', function(){
            $('#show-1').addClass('none');
            $('#show-2').removeClass('none');
            let id_periode = $(this).data('id');
            data_scanlog(id_periode);
        });

        $("body").on("click", "#btn-back", function () {
            $('#show-1').removeClass('none');
            $('#show-2').addClass('none');
            window.location.reload();
        });

        function data_scanlog(id_periode){
            $.ajax({
                url: 'absensi/detail_scanlog',
                method: "POST",
                dataType: "json",
                data: {
                    id_periode: id_periode
                },
                success: function (json) {
                    $("#show-awal").html(json.periode_awal);
                    $("#show-akhir").html(json.periode_akhir);
                    $("#show-shift").html(json.jumlah_shift);
                    $("#show-karyawan").html(json.karyawan);
                    DataHariLibur(json.dataLibur);
                },
            });
            
            function DataHariLibur(dataLibur){
                $("#tabel-hlibur tbody").html("");
                var html = "";
                for (var i=0; i<dataLibur.length; i++) {
                    html += '<tr>' +
                            '<td class="text-center">'+dataLibur[i].no+'</td>'+
                            '<td>'+dataLibur[i].tanggal+'</td>' +
                            '<td>'+dataLibur[i].keterangan+'</td>'+
                        '</tr>';
                }
                if (dataLibur == 0) {
                    $("#tabel-hlibur tbody").html(
                        '<tr><td class="text-center" colspan="4">Belum ada libur di lain hari minggu</td></tr>'
                    );
                } else {
                    $("#tabel-hlibur tbody").html(html);
                }
            }

            $('select[name="filter-karyawan"]').change(function() {
                var karyawan = $('select[name="filter-karyawan"]').val();
                var id_karyawan = karyawan == "" ? null : karyawan;
                dataLogScan(id_periode,id_karyawan);
            });

            function dataLogScan(id_periode,id_karyawan){
                $.ajax({
                    url: 'absensi/scanlog_karyawan',
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_periode: id_periode,
                        id_karyawan: id_karyawan
                    },
                    success: function (data) {
                        var html = "";
                        if(data.length > 0){
                            for(var i=0; i<data.length; i++) {
                                if(data.length == (i+1)){
                                    html += '<tr style="background: #f7f8fa">' +
                                                '<th colspan="4" class="text-right"> Total Rekap : </th>'+
                                                '<th>'+data[i].lembur+'</th>' +
                                                '<th>'+data[i].terlambat+'</th>' +
                                                '<th>'+data[i].shift+'</th>' +
                                                '<th>'+data[i].libur+'</th>' +
                                                '<th colspan="2"></th>' +
                                            '</tr>';
                                }else{
                                    html += '<tr>' +
                                                '<td>'+(i+1)+'</td>'+
                                                '<td>'+data[i].tanggal+'</td>' +
                                                '<td>'+data[i].jam_masuk+'</td>' +
                                                '<td>'+data[i].jam_pulang+'</td>' +
                                                '<td>'+data[i].lembur+'</td>' +
                                                '<td>'+data[i].terlambat+'</td>' +
                                                '<td>'+data[i].shift+'</td>' +
                                                '<td>'+data[i].libur+'</td>' +
                                                '<td>'+data[i].keterangan+'</td>' +
                                                '<td class="text-center"><a id="edit_scan" '+
                                                    'data-id="'+data[i].id_scanlog+'" '+
                                                    'data-tg="'+data[i].tanggal+'" '+
                                                    'data-jm="'+data[i].jam_masuk+'" '+
                                                    'data-jp="'+data[i].jam_pulang+'" '+
                                                    'data-lm="'+data[i].lembur+'" '+
                                                    'data-tr="'+data[i].terlambat+'" '+
                                                    'data-sf="'+data[i].shift+'" '+
                                                    'data-kt="'+data[i].keterangan+'" '+
                                                'class="text-warning pointer"><i class="fa fa-edit"></i></a></td>'+
                                            '</tr>';
                                }
                            }
                        }else{
                            html = '<tr><td colspan="10" style="margin:2px; width:100%; font-size:14px; height:40px; background-color:#f4f4f4;"><center>Data tidak ditemukan!</center></td></tr>';
                        }
                        $("#table-scanlog tbody").html(html);
                    },
                });
            };
            
            $('body').on('click','#edit_scan',function(){
                $("#tgl-scn").html('');
                $('input[name="masuk"]').val('');
                $('input[name="pulang"]').val('');
                $('input[name="lbr"]').val('');
                $('input[name="tlt"]').val('');
                $('input[name="sft"]').val('');
                $('input[name="ket"]').val('');
                $("#modal-editscanlog").modal();
                Inputmask("datetime", {
                    inputFormat: "HH:MM:ss",
                    placeholder: "_",
                    leapday: "-02-29",
                    alias: "tt.mm.jjjj",
                    max: "24",
                }).mask('.waktu');
                let id_scan = $(this).data('id');
                let tanggal = $(this).data('tg');
                let jam_masuk = $(this).data('jm');
                let jam_pulang = $(this).data('jp');
                let lembur = $(this).data('lm');
                let terlambat = $(this).data('tr');
                let shift = $(this).data('sf');
                let keterangan = $(this).data('kt');
                $("#tgl-scn").html(tanggal);
                $('input[name="masuk"]').val(jam_masuk);
                $('input[name="pulang"]').val(jam_pulang);
                $('input[name="lbr"]').val(lembur);
                $('input[name="tlt"]').val(terlambat);
                $('input[name="sft"]').val(shift);
                $('input[name="ket"]').val(keterangan);
                $('input[name="id_scanlog"]').val(id_scan);

                var lp = true;
                $('body').on('click','#edit_scanlog',function(e){
                    e.preventDefault();
                    let validasi = document.getElementById("form-editscanlog").reportValidity();
                    if (validasi) {
                        var id_scanlog = $('input[name="id_scanlog"]').val();
                        var masuk = $('input[name="masuk"]').val();
                        var pulang = $('input[name="pulang"]').val();
                        var lbr = $('input[name="lbr"]').val();
                        var tlt = $('input[name="tlt"]').val();
                        var sft = $('input[name="sft"]').val();
                        var ket = $('input[name="ket"]').val();
                        if(masuk.search("_") == -1 && pulang.search("_") == -1){
                            if(lp){
                                lp=false;
                                $.ajax({
                                    url: "absensi/edit_scanlog",
                                    method: "POST",
                                    dataType: "json",
                                    data: {
                                        id_scanlog: id_scanlog,
                                        masuk: masuk,
                                        pulang: pulang,
                                        lbr: lbr,
                                        tlt: tlt,
                                        sft: sft,
                                        ket: ket,
                                    },
                                    success: function (json) {
                                        $("#modal-editscanlog").modal('hide');
                                        let result = json.result;
                                        let message = json.message;
                                        notif(result, message);
                                        var karyawan = $('select[name="filter-karyawan"]').val();
                                        var id_karyawan = karyawan == "" ? null : karyawan;
                                        dataLogScan(id_periode,id_karyawan);
                                    },
                                });
                            }
                        }else{
                            notif('error', 'Format jam tidak sesuai!');
                        }
                    }else{
                        return false;
                    }
                });
            });

        }
    }

    $("#filter-karyawan").select2({width: '100%'});
    $(".select2-selection--single").css({
        "height":"calc(2.25rem + 2px)", 
        "padding":"0.3rem 0.4rem", 
        "line-height":"1.5", 
        "max-width":"230px",
        "border": "transparent",
        "background-color":"transparent"
    });

    function notif(result, message, reload = null) {
        if (result == "success") {
            swal("Success", message, {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
            if(reload == 1){
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }else{
                setTimeout(() => {
                    swal.close();
                }, 1000);
            }
        } else {
            swal("Faild", message, {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                    },
                },
            });
        }
    }
})(jQuery);