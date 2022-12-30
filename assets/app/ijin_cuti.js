(function($) {
    var id_ijincuti = $('#id_ijincuti').val();

    $("#persetujuan").click(function() {
        $('.notif').addClass('none');
    });
    $('#setuju_sop').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#nav3').removeClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
            $('#show-nav3').addClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
    $('#nav2').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#nav3').removeClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
            $('#show-nav3').addClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
    $('#nav1').on("click", function(){
        $('#nav1').addClass('active');
        $('#nav2').removeClass('active');
        $('#nav3').removeClass('active');
        $('#show-nav1').removeClass('none');
        $('#show-nav2').addClass('none');
        $('#show-nav3').addClass('none');
    });
    $('#nav3').on("click", function(){
        $('#nav1').removeClass('active');
        $('#nav2').removeClass('active');
        $('#nav3').addClass('active');
        $('#show-nav1').addClass('none');
        $('#show-nav2').addClass('none');
        $('#show-nav3').removeClass('none');
    });

    $('#setuju_sop').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#nav3').removeClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
            $('#show-nav3').addClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
        
    $("input[type=radio][name='pilih_ijincuti']").change(function(){
        var pilih = $('input[name="pilih_ijincuti"]:checked').val();
        if(pilih == '1'){
            $('#per_shift').removeClass('none');
            $('#per_jam').addClass('none');
            $('#tanggal').attr('required',false);
            $('#tanggal').val('');
            $('#tgl_awal').val('');
            $('#tgl_akhir').val('');
            $('#jam_awal').val('');
            $('#jam_akhir').val('');
            $('#total_hari').val('');
            $('#total_menit').val('');
            $('#show-thari').html(0);
            $('#show-tmenit').html(0);
        }else{
            $('#per_shift').addClass('none');
            $('#per_jam').removeClass('none');
            $('#tanggal').attr('required',true);
            $('#tanggal').val('');
            $('#tgl_awal').val('');
            $('#tgl_akhir').val('');
            $('#jam_awal').val('');
            $('#jam_akhir').val('');
            $('#total_hari').val('');
            $('#total_menit').val('');
            $('#show-thari').html(0);
            $('#show-tmenit').html(0);
        }
    });

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    Inputmask("datetime", {
        inputFormat: "HH:MM",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.wkt');
    
    $('#tgl_awal').keyup(function(){
        range_tanggal();
    });
    $('#tgl_akhir').keyup(function(){
        range_tanggal();
    });
    function range_tanggal(){
        var date1i = $('#tgl_awal').val();
        var date2i = $('#tgl_akhir').val();
        if(date1i.search("_") == -1 && date2i.search("_") == -1 && date1i && date2i){
            var date1x = date1i.split('-');
            var date2x = date2i.split('-');
            var date1 = date1x[2]+'-'+date1x[1]+'-'+date1x[0];
            var date2 = date2x[2]+'-'+date2x[1]+'-'+date2x[0];
            var ONE_DAY = 1000 * 60 * 60 * 24;
            var diff1 = Math.abs(new Date(date1) - new Date(date2));
            var day = Math.round((diff1/ONE_DAY)+1);
            $('#jam_awal').val('00:00');
            $('#jam_akhir').val('00:00');
            $('#total_hari').val(day);
            $('#total_menit').val(0);
            $('#show-thari').html(day);
            $('#show-tmenit').html(0);
        }else{
            $('#total_hari').val('');
            $('#total_menit').val('');
            $('#show-thari').html(0);
            $('#show-tmenit').html(0);
        }
    }

    $('#jam_awal').keyup(function(){
        range_jam();
    });
    $('#jam_akhir').keyup(function(){
        range_jam();
    });
    $('#tanggal').keyup(function(){
        $('#tgl_awal').val($(this).val());
        $('#tgl_akhir').val($(this).val());
    });
    function range_jam(){
        var date1i = $('#jam_awal').val();
        var date2i = $('#jam_akhir').val();
        if(date1i.search("_") == -1 && date2i.search("_") == -1 && date1i && date2i){
            var diff2 = Math.abs(new Date('1/1/1 '+date1i) - new Date('1/1/1 '+date2i));
            var minutes = Math.floor((diff2/1000)/60);
            $('#total_hari').val(0);
            $('#total_menit').val(minutes);
            $('#show-thari').html(0);
            $('#show-tmenit').html(minutes);
        }else{
            $('#total_hari').val('');
            $('#total_menit').val(''); 
            $('#show-thari').html(0);
            $('#show-tmenit').html(0);
        }
    }

    $('#ajukan_form').on('click',function (e) {
        e.preventDefault();
        var tgl1 = $('input[name="tgl_awal"]').val().search("_");
        var tgl2 = $('input[name="tgl_akhir"]').val().search("_");
        var jam1 = $('input[name="jam_awal"]').val().search("_");
        var jam2 = $('input[name="jam_akhir"]').val().search("_");
        if(tgl1 == -1 && tgl2 == -1 && jam1 == -1 && jam2 == -1){
            let validasi = document.getElementById("form-ijincuti").reportValidity();
            if(validasi){
                $("#ajukan_form").prop( "disabled",true);
                var formData = new FormData(document.querySelector("#form-ijincuti"));
                formData.append("id_ijincuti", id_ijincuti);
                $.ajax({
                    url: "ijincuti/add_ijincuti",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (json) {
                        let result = json.result;
                        let message = json.message;
                        if (result=="error") { $("#ajukan_form").prop( "disabled",false); }
                        notif(result, message, 1);
                    },
                });
            }else{
                $("#ajukan_form").prop( "disabled",false);
            }
        }else{
            notif('error', 'Format tanggal tidak sesuai!');
        }
    });

    $('select[name="filter-status"]').change(function() {
        var status = $('select[name="filter-status"]').val();
        table_ijin(status);
    });

    table_ijin('x');
    function table_ijin(status){
        var table_ijincuti = $("#datatable-ijincuti").DataTable({
            ajax: {
                url: "ijincuti/read_ijincuti",
                type: "POST",
                data: { 
                    id_ijincuti: id_ijincuti,
                    status: status
                },
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
                    "targets": [6,7,8,9,10,11,12,13],
                    "orderable": false,
                    "visible": false
                },
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
                emptyTable: "Belum ada daftar ijin/cuti!",
                infoEmpty: "Tidak ada data untuk ditampilkan!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: ""
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [ ],
            columns: [
                { data: "No" },
                { data: "Tanggal" },
                { data: "Cuti" },
                { data: "Keperluan" },
                { data: "Status" , render : function ( data, type, row, meta ) {
                    var stts = "";
                    if(data == 0 || data == 1){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Diajukan</span>';
                    }else if(data == 2){
                        stts = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Disetujui</span>';
                    }else if(data == 3){
                        stts = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">Ditolak</span>';
                    }
                    return type === 'display' ? stts : data;
                }},
                { data: "Aksi" , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                    '<a class="btn btn-default btn-sm btn-link" id="show-form" data-id="'+data+'">'
                        +'<span class="btn-label just-icon"><i class="fas fa-eye"></i> </span>'
                    +'</a>' : data;
                }},
                { data: "Status" },
                { data: "tgl_create" },
                { data: "tgl_awal" },
                { data: "tgl_akhir" },
                { data: "total_hari" },
                { data: "total_menit" },
                { data: "file" },
                { data: "alasan_ditolak" },
            ],
            rowCallback:function(row,data,index){
                $('td', row).eq(1).addClass('text-center');
            },
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
        
        $('body').on('click','#btn-file' ,function(e){
            e.preventDefault();
            var imgLink = $(this).data('file');
            $('.mask').html('<div class="img-box"><img src="assets/img/ijincuti/'+ imgLink +'"><a class="close">&times;</a>');
            $('.mask').attr('style','display: block !important;');
            $('body').on('click','.close', function(){
                $('.mask').attr('style','');
            });
        });
    }

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