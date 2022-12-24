(function ($) {
    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

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
        aLengthMenu: [[5],[5]],
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
            { data: "Ket" },
            { data: "Status" , render : function ( data, type, row, meta ) {
                var stts = "";
                if(data == 0){
                    stts = '<div style="text-align:center;"><span class="btn btn-primary fw-bold btn-xs py-0 px-1">Process</span></div>';
                }else if(data == 1){
                    stts = '<div style="text-align:center;"><span class="btn btn-warning fw-bold btn-xs py-0 px-1">Waiting</span></div>';
                }else if(data == 2){
                    stts = '<div style="text-align:center;"><span class="btn btn-success fw-bold btn-xs py-0 px-1">Done</span></div>';
                }
                return type === 'display' ? stts : data;
            }},
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                var edit,stop,upld,show = '';
                if(row['Status'] == 0){
                    edit=''; stop=''; upld='none'; show='none';
                }else if(row['Status'] == 1){
                    edit='none'; stop='none'; upld=''; show='none';
                }else if(row['Status'] == 2){
                    edit='none'; stop='none'; upld='none'; show='';
                }
                var dt = 'data-id="'+data+'" data-awal="'+row['Awal']+'" data-akhir="'+row['Akhir']+'" data-shift="'+row['Shift']+'" data-ket="'+row['Ket']+'"';
                return type === 'display'  ?
                '<div style="text-align:center;">'+
                    '<a class="btn btn-warning btn-sm btn-link p-1 '+edit+'" id="periode-edit" '+dt+'><span class="btn-label just-icon"><i class="fas fa-edit"></i> </span></a>'+
                    '<a class="btn btn-danger btn-sm btn-link p-1 '+stop+'" id="periode-stop" '+dt+'><span class="btn-label just-icon"><i class="fas fa-stop-circle"></i> </span></a>'+
                    '<a class="btn btn-secondary btn-sm btn-link p-1 '+upld+'" id="periode-upload" '+dt+'><span class="btn-label just-icon"><i class="fas fa-upload"></i> </span></a>'+
                    '<a class="btn btn-default btn-sm btn-link p-1 '+show+'" id="periode-show" '+dt+'><span class="btn-label just-icon"><i class="fas fa-folder-open"></i> </span></a>'+
                '</div>':
                data;
            }},
        ],
    });

    $('input[name="tgl_akhir"]').keyup(function(){
        var val = $(this).val();
        get_keterangan(val,'input');
    });

    $('input[name="edit_tgl_akhir"]').keyup(function(){
        var val = $(this).val();
        get_keterangan(val,'edit');
    });

    function get_keterangan(val,cek){
        var tgl = val;
        let m = tgl.substring(3,5);
        let y = tgl.substring(6,10);
        if(tgl.search("_") == -1 && tgl != ''){
            const Month = ["Null","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            var ket = Month[parseInt(m)]+' '+y;
            if(cek == 'edit'){
                $('input[name="edit_keterangan"]').val(ket);
            }else{
                $('input[name="keterangan"]').val(ket);
            }
        }else{
            if(cek == 'edit'){
                $('input[name="edit_keterangan"]').val('');
            }else{
                $('input[name="keterangan"]').val('');
            }
        }
    }

    $('#reset-periode').on('click', function(){
        $('input[name="tgl_awal"]').val('');
        $('input[name="tgl_akhir"]').val('');
        $('input[name="total_hari"]').val('');
        $('input[name="keterangan"]').val('');
    });

    $('#add-periode').on('click', function(){
        var tgl_awal = $('input[name="tgl_awal"]').val();
        var tgl_akhir = $('input[name="tgl_akhir"]').val();
        var total_hari = $('input[name="total_hari"]').val();
        var keterangan = $('input[name="keterangan"]').val();
        if(tgl_awal.search("_") == -1 && tgl_akhir.search("_") == -1 && total_hari != '' && tgl_awal != '' && tgl_akhir != ''){
            let formData = new FormData(); 
            formData.append('tgl_awal', tgl_awal);
            formData.append('tgl_akhir', tgl_akhir);
            formData.append('total_hari', total_hari);
            formData.append('keterangan', keterangan);
            $.ajax({
                url: "absensi/add_periode",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    if (result!="error") {
                        $('input[name="tgl_awal"]').val('');
                        $('input[name="tgl_akhir"]').val('');
                        $('input[name="total_hari"]').val('');
                        $('input[name="keterangan"]').val('');
                        table_periode.ajax.reload();
                    }
                    notif(result, message);
                },
            });
        }else{
            notif('error', 'Data Periode tidak lengkap atau tidak sesuai!');
        }
    });

    $("body").on("click", "#periode-stop", function (e) {
        e.preventDefault();
        let id_periode = $(this).data('id');
        let keterangan = $(this).data('ket');
        swal({
            title: "Hentikan Periode",
            type: "warning",
            text: ' ',
            buttons: {
                cancel: {
                    visible: true,
                    text: "Kembali",
                    className: "btn btn-danger",
                },
                confirm: {
                    text: "Lanjutkan",
                    className: "btn btn-success",
                },
            },
        }).then((Delete) => {
            if (Delete) {
                $.ajax({
                    url: 'absensi/stop_periode',
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_periode: id_periode
                    },
                    success: function (json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message);
                    },
                });
            } else {
                swal.close();
            }
        });
        $('.swal-text').html('<div class="style1"> Apakah anda yakin ingin menghentikan dan melanjutkan proses data pada periode <b>'+keterangan+'</b>? </div>');
        $('.style1').attr('style','width:100% !important; padding:15px; border-radius:4px; font-size:13px; background-color:#d9e2f7;');
        $('.style2').attr('style','width:100% !important; padding:15px; border-radius:4px; font-weight:600;');
    });
    
    $("body").on("click", "#periode-edit", function (e) {
        e.preventDefault();
        $("#modal-editperiode").modal();
        $('input[name="edit_tgl_awal"]').val($(this).data('awal'));
        $('input[name="edit_tgl_akhir"]').val($(this).data('akhir'));
        $('input[name="edit_total_hari"]').val($(this).data('shift'));
        $('input[name="edit_keterangan"]').val($(this).data('ket'));
        $('input[name="id_periode"]').val($(this).data('id'));
    });
    
    $("body").on("click", "#edit-periode", function (e) {
        e.preventDefault();
        var id_periode = $('input[name="id_periode"]').val();
        var tgl_awal = $('input[name="edit_tgl_awal"]').val();
        var tgl_akhir = $('input[name="edit_tgl_akhir"]').val();
        var total_hari = $('input[name="edit_total_hari"]').val();
        var keterangan = $('input[name="edit_keterangan"]').val();
        if(tgl_awal.search("_") == -1 && tgl_akhir.search("_") == -1 && total_hari != '' && tgl_awal != '' && tgl_akhir != ''){
            let formData = new FormData(); 
            formData.append('id_periode', id_periode);
            formData.append('tgl_awal', tgl_awal);
            formData.append('tgl_akhir', tgl_akhir);
            formData.append('total_hari', total_hari);
            formData.append('keterangan', keterangan);
            $.ajax({
                url: "absensi/edit_periode",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    if(result=='success'){ 
                        $("#modal-editperiode").modal('hide');
                    }
                },
            });
        }else{
            notif('error', 'Data Periode tidak lengkap atau tidak sesuai!');
        }
    });
    
    const arrHlibur = [];
    $("body").on("click", "#periode-upload", function (e) {
        e.preventDefault();
        var id_periode = $(this).data('id');
        $.ajax({
            url: 'absensi/cek_lembur',
            method: "POST",
            dataType: "json",
            data: {
                id_periode: id_periode
            },
            success: function (cek_acc) {
                if(parseInt(cek_acc) < 1 ){
                    $("#modal-scanlog").modal();
                    $('input[name="tgl_libur"]').val('');
                    $('input[name="ket_libur"]').val('');
                    $("#file_scanlog").val('');
                    $('input[name="id_periode_x"]').val(id_periode);
                    arrHlibur.splice(0, arrHlibur.length);
                    listHlibur();
                }else{
                    swal({
                        title: "ACC Form Lembur",
                        type: "warning",
                        text: ' ',
                        buttons: {
                            cancel: {
                                visible: true,
                                text: "Kembali",
                                className: "btn btn-danger",
                            },
                            confirm: {
                                text: "Lanjutkan",
                                className: "btn btn-success",
                            },
                        },
                    }).then((Delete) => {
                        var base_url = $('input[name="base_url"]').val();
                        document.location.href = base_url + 'rekap-lembur';
                    });
                    $('.swal-text').html('<div class="style1"> Masih terdapat pengajuan form lembur yang belum di ACC oleh atasannya! Lanjutkan untuk lihat pengajuan form lembur? </div>');
                    $('.style1').attr('style','width:100% !important; padding:15px; border-radius:4px; font-size:13px; background-color:#d9e2f7;');
                    $('.style2').attr('style','width:100% !important; padding:15px; border-radius:4px; font-weight:600;');
                }
            },
        });
    });
    
    $('#add-harilibur').on('click', function(e){
        e.preventDefault();
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
        swal({
            title: "Simpan Scanlog",
            type: "warning",
            text: ' ',
            buttons: {
                cancel: {
                    visible: true,
                    text: "Kembali",
                    className: "btn btn-danger",
                },
                confirm: {
                    text: "Lanjutkan",
                    className: "btn btn-success",
                },
            },
        }).then((Delete) => {
            if (Delete) {
                $('.load-spin').removeClass('none');
                $('#button-footer').addClass('none');
                let formData = new FormData(); 
                formData.append('id_periode', $('input[name="id_periode_x"]').val());
                formData.append("hari_libur", JSON.stringify(arrHlibur));
                formData.append("file_scanlog", $('#file_scanlog')[0].files[0]);
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
                        $('.load-spin').addClass('none');
                        $('#button-footer').removeClass('none');
                        if (result != "error") {
                            swal("Success", message, {
                                icon: "success",
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            }).then(function(isConfirm){
                                window.location.reload();
                            });
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
                    },
                });
            } else {
                swal.close();
            }
        });
        $('.swal-text').html('<div class="style1"> Apakah anda yakin ingin upload data scanlog yang sudah benar? Setalah di upload pengajuan form lembur periode ini akan dihentikan! </div>');
        $('.style1').attr('style','width:100% !important; padding:15px; border-radius:4px; font-size:13px; background-color:#d9e2f7;');
        $('.style2').attr('style','width:100% !important; padding:15px; border-radius:4px; font-weight:600;');
    });
    
    $("body").on("click", "#periode-show", function (e) {
        e.preventDefault();
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
        });
        
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
                }else{
                    notif('error', 'Format jam tidak sesuai!');
                }
            }
        });
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
            }
            table_periode.ajax.reload();
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