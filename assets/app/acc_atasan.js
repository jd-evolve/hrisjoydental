(function ($) {
    $('#nav1').on("click", function(){
        $('#nav1').addClass('active');
        $('#nav2').removeClass('active');
        $('#nav3').removeClass('active');
        $('#show-nav1').removeClass('none');
        $('#show-nav2').addClass('none');
        $('#show-nav3').addClass('none');
        table_accatasan('0');
    });
    $('#nav2').on("click", function(){
        $('#nav1').removeClass('active');
        $('#nav2').addClass('active');
        $('#nav3').removeClass('active');
        $('#show-nav1').addClass('none');
        $('#show-nav2').removeClass('none');
        $('#show-nav3').addClass('none');
        table_accatasan('z');
    });
    $('#nav3').on("click", function(){
        $('#nav1').removeClass('active');
        $('#nav2').removeClass('active');
        $('#nav3').addClass('active');
        $('#show-nav1').addClass('none');
        $('#show-nav2').addClass('none');
        $('#show-nav3').removeClass('none');
        table_accatasan('3');
    });

    table_accatasan('0');
    function table_accatasan(status){
        var table_accatasan = $("#datatable-accatasan").DataTable({
            ajax: {
                url: "ijincuti/read_accatasan",
                type: "POST",
                data: {
                    status: status
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
                emptyTable: "Belum ada daftar pengajuan!",
                infoEmpty: "Tidak ada data untuk ditampilkan!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: ""
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [ ],
            columns: [
                { data: "No" },
                { data: "Tanggal" },
                { data: "IjinCuti" },
                { data: "Karyawan" },
                { data: "Bagian" },
                { data: "Status" , render : function ( data, type, row, meta ) {
                    var stts = "";
                    if(data == 0){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Diajukan</span>';
                    }else if(data == 1 || data == 2){
                        stts = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Disetujui</span>';
                    }else if(data == 3){
                        stts = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">Ditolak</span>';
                    }
                    return type === 'display' ? stts : data;
                }},
                { data: "Aksi" , render : function ( data, type, row, meta ) {
                    return type === 'display'  ?
                    '<button type="button" data-id="'+data+'" id="show-detail" class="btn btn-icon btn-round btn-secondary btn-sm" title="Lihat ijin/cuti.">'+
                        '<i class="fa fa-eye"></i>'+
                    '</button>':
                    data;
                }},
            ],
        });
        
        $('#filter-search').keyup(function(){
            var src = $('input[name="filter-search"]').val().toLowerCase();
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (~data[2].toLowerCase().indexOf(src))
                    return true;
                if (~data[3].toLowerCase().indexOf(src))
                    return true;
                if (~data[4].toLowerCase().indexOf(src))
                    return true;
                return false;
            })
            table_accatasan.draw(); 
            $.fn.dataTable.ext.search.pop();
        });
        
        $('body').on('click','#show-detail', function(){
            $("#modal-showform").modal();
            let id_ijincuti_list = $(this).data('id');
            $('input[name="id_ijincuti_list"]').val(id_ijincuti_list);
            show_form(id_ijincuti_list);
        });

        function show_form(id_ijincuti_list){
            if(status != 0){
                $("#show-button").addClass('none');
            }else{
                $("#show-button").removeClass('none');
            }
            $.ajax({
                url: 'ijincuti/detail_ijincuti',
                method: "POST",
                dataType: "json",
                data: {
                    id_ijincuti_list: id_ijincuti_list
                },
                success: function (data) {
                    $("#show-ket_ijincuti").html(data.ijincuti);
                    $("#show-tgl_create").html(data.tgl_create);

                    var stts = "";
                    if(data.status == 0 || data.status == 1){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Diajukan</span>';
                    }else if(data.status == 2){
                        stts = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Disetujui</span>';
                    }else if(data.status == 3){
                        stts = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">Ditolak</span>';
                    }
                    document.getElementById("text-showform").innerHTML = 'Status : '+stts;
                    $("#show-tgl_create").html(data.tgl_input);
                    $("#show-keperluan").html(data.keperluan);
                    $("#show-tgl_awal").html(data.tgl_awal);
                    $("#show-tgl_akhir").html(data.tgl_akhir);
                    $("#show-total_hari").html(data.total_hari);
                    $("#show-total_menit").html(data.total_menit);

                    $("#show-karyawan").html(data.karyawan);
                    $("#show-jabatan").html(data.jabatan);
                    $("#show-bagian").html(data.bagian);
        
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
        }
        
        $('body').on('click','#btn-file' ,function(e){
            e.preventDefault();
            var imgLink = $(this).data('file');
            $('.mask').html('<div class="img-box"><img src="assets/img/ijincuti/'+ imgLink +'"><a class="close">&times;</a>');
            $('.mask').attr('style','display: block !important;');
            $('body').on('click','.close', function(){
                $('.mask').attr('style','');
            });
        });

        $('body').on('click','#btn-setujui' ,function(e){
            e.preventDefault();
            swal({
                title: "Apakah anda yakin?",
                text: "Pastikan form pengajuan telah sesuai dengan ketentuan!",
                type: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: "Kembali",
                        className: "btn btn-danger",
                    },
                    confirm: {
                        text: "Setujui",
                        className: "btn btn-success",
                    },
                },
            }).then((Delete) => {
                if (Delete) {
                    $.ajax({
                        url: "ijincuti/accatasan_ijincuti",
                        method: "POST",
                        dataType: "json",
                        data: {
                            id_ijincuti_list: $('input[name="id_ijincuti_list"]').val()
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
        });

        $('body').on('click','#btn-tolak' ,function(e){
            e.preventDefault();
            $("#modal-showform").modal('hide');
            $("#modal-batal").modal('show');
            $("#alasan-batal").val('');
        });

        $("body").on("click", "#lanjutkan", function(e){
            e.preventDefault();
            if($("#form-alasan-batal").valid()){
                $("#modal-batal").modal('hide');
                var alasan_ditolak = document.getElementById("alasan-batal").value;
                var id_ijincuti_list =  $('input[name="id_ijincuti_list"]').val();
                $.ajax({
                    url: 'ijincuti/tolakatasan_ijincuti',
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_ijincuti_list: id_ijincuti_list,
                        alasan_ditolak: alasan_ditolak
                    },
                    success: function (json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message);
                    },
                });
            }
        });

        $("body").on("click", "#kembali", function(e){
            e.preventDefault();
            $("#modal-showform").modal('show');
            $("#modal-batal").modal('hide');
            var id_ijincuti_list =  $('input[name="id_ijincuti_list"]').val();
            show_form(id_ijincuti_list);
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
                table_accatasan.ajax.reload();
                $("#modal-showform").modal('hide');
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
    }

})(jQuery);
