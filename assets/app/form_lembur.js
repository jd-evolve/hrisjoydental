(function($) {
    $("#persetujuan").click(function() {
        $('.notif').addClass('none');
    });
    $('#setuju_sop').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
    $('#nav1').on("click", function(){
        $('#nav1').addClass('active');
        $('#nav2').removeClass('active');
        $('#show-nav1').removeClass('none');
        $('#show-nav2').addClass('none');
    });
    $('#nav2').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });

    $('select[name="filter-periode"]').change(function() {
        tableLembur();
    });

    tableLembur();
    function tableLembur(){
        var periode = $('select[name="filter-periode"]').val();
        var table_lembur = $("#datatable-lembur").DataTable({
            ajax: {
                url: "absensi/read_lembur",
                type: "POST",
                data: {
                    id_periode: periode
                },
            },
            order: [],
            ordering: false,
            bDestroy: true,
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
                emptyTable: "Belum ada daftar lembur!",
                infoEmpty: "Tidak ada data untuk ditampilkan!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: ""
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [ ],
            columns: [
                { data: "No" },
                { data: "Tanggal" },
                { data: "Waktu" },
                { data: "Jumlah" },
                { data: "Kategori" , render : function ( data, type, row, meta ) {
                    var html = "";
                    if(data == 1){
                        html = '<span class="btn btn-secondary fw-bold btn-xs py-0 px-1">diluar jam kerja</span>';
                    }else if(data == 2){
                        html = '<span class="btn btn-info fw-bold btn-xs py-0 px-1">range jam kerja</span>';
                    }
                    return type === 'display' ? html : data;
                }},
                { data: "Keterangan" },
                { data: "Status" , render : function ( data, type, row, meta ) {
                    var html = "";
                    if(data == 1){
                        html = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Diajukan</span>';
                    }else if(data == 2){
                        html = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Disetujui</span>';
                    }else if(data == 3){
                        html = '<span class="btn btn-danger fw-bold btn-xs py-0 px-1">Ditolak</span>';
                    }
                    return type === 'display' ? html : data;
                }},
                { data: "Aksi" , render : function ( data, type, row, meta ) {
                    var edit,show = '';
                    if(row['st_periode'] == 0){
                        edit=''; show='none';
                    }else {
                        edit='none'; show='';
                    }

                    var dt = 'data-id="'+data+'" data-sts="'+row['Status']+'" data-als="'+row['Alasan']+'" data-tgl="'+row['Tanggal']+'" data-kat="'+row['Kategori']+'" data-mli="'+row['Mulai']+'" data-sli="'+row['Selesai']+'" data-jml="'+row['Jumlah']+'" data-ket="'+row['Keterangan']+'" data-ketp="'+row['Ket_periode']+'"';
                    return type === 'display' ?
                    '<div style="text-align:center;">'+
                        '<a class="btn btn-default btn-sm btn-link p-1 '+edit+'" id="edit-form" '+dt+'><span class="btn-label just-icon"><i class="fas fa-edit"></i> </span></a>'+
                        '<a class="btn btn-default btn-sm btn-link p-1 '+show+'" id="show-form" '+dt+'><span class="btn-label just-icon"><i class="fas fa-eye"></i> </span></a>'+
                    '</div>':
                    data;
                }}
            ],
            rowCallback:function(row,data,index){
                $('td', row).eq(1).addClass('text-center');
                $('td', row).eq(2).addClass('text-center');
                $('td', row).eq(3).addClass('text-center');
                $('td', row).eq(7).addClass('nowraping');
            },
        });

        Inputmask("datetime", {
            inputFormat: "HH:MM",
            placeholder: "_",
            leapday: "-02-29",
            alias: "tt.mm.jjjj",
            max: "24",
        }).mask('.waktu');

        Inputmask("datetime", {
            inputFormat: "dd-mm-yyyy",
            placeholder: "_",
            leapday: "-02-29",
            alias: "tt.mm.jjjj"
        }).mask('.tgl');
            
        $('#jam_mulai').keyup(function(){
            range_jam();
        });
        $('#jam_selesai').keyup(function(){
            range_jam();
        });

        function range_jam(){
            var jam_mulai = $('#jam_mulai').val();
            var jam_selesai = $('#jam_selesai').val();
            if(jam_mulai.search("_") == -1 && jam_mulai != '' && jam_selesai.search("_") == -1 && jam_selesai != ''){
                var diff = Math.abs(new Date('1/1/1 '+jam_mulai) - new Date('1/1/1 '+jam_selesai));
                var minutes = Math.floor((diff/1000)/60);
                $('#jumlah').val(minutes);
            }else{
                $('#jumlah').val('');
            }
        }

        $("#tambah_lembur").on("click", function () {
            $("#modal-lembur").modal();
            document.getElementById("text-lembur").innerHTML = "Tambah Form Lembur";
            $('#periode').val($('#ket_periode').val());
            $('#kategori').val('').prop("disabled", false);
            $('#tgl_lembur').val('').prop("readonly", false);
            $('#jam_mulai').val('').prop("readonly", false);
            $('#jam_selesai').val('').prop("readonly", false);
            $('#keterangan').val('').prop("readonly", false);
            $('#jumlah').val('');
            $('.alasan-ditolak').addClass("none");
            $('input[name="id_lembur"]').val('');
            $('input[name="edit_lembur"]').attr("type", "hidden");
            $('input[name="add_lembur"]').attr("type", "submit");
        });

        $("input#add_lembur").on("click", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-lembur").reportValidity();
            let awal = new Date($('#periode_awal').val()).getTime();
            let akhir = new Date($('#periode_akhir').val()).getTime();
            const dt = $('#tgl_lembur').val().split("-");
            let date = new Date(dt[2]+'-'+dt[1]+'-'+dt[0]).getTime();
            if (validasi) {
                if(date >= awal && date <= akhir){
                    var mulai = $('#jam_mulai').val();
                    var selesai = $('#jam_selesai').val();
                    if(mulai.search("_") == -1 && selesai.search("_") == -1){
                        var formData = new FormData(document.querySelector("#form-lembur"));
                        $.ajax({
                            url: "absensi/add_lembur",
                            method: "POST",
                            data: formData,
                            dataType: "json",
                            processData: false,
                            contentType: false,
                            success: function (json) {
                                let result = json.result;
                                let message = json.message;
                                notif(result, message);
                                $("#modal-lembur").modal('hide');
                            },
                        });
                    }else{
                        notif('error', 'Format jam tidak sesuai!');
                    }
                }else{
                    let tgl1 = new Date($('#periode_awal').val()).toLocaleDateString("es-CL");
                    let tgl2 = new Date($('#periode_akhir').val()).toLocaleDateString("es-CL");
                    swal("Faild", "Tanggal tidak boleh, kurang dari "+tgl1+" dan lebih dari "+tgl2+"!", {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: "btn btn-danger",
                            },
                        },
                    });
                }
            }
        });
        
        $("body").on("click", "#edit-form", function (e) {
            e.preventDefault();
            $("#modal-lembur").modal();
            document.getElementById("text-lembur").innerHTML = "Edit Form Lembur";
            $('#periode').val($(this).data('ketp'));
            $('#kategori').val($(this).data('kat')).prop("disabled", false);
            $('#tgl_lembur').val($(this).data('tgl')).prop("readonly", false);
            $('#jam_mulai').val($(this).data('mli')).prop("readonly", false);
            $('#jam_selesai').val($(this).data('sli')).prop("readonly", false);
            $('#keterangan').val($(this).data('ket')).prop("readonly", false);
            $('#jumlah').val($(this).data('jml'));
            $('.alasan-ditolak').addClass("none");
            $('input[name="id_lembur"]').val($(this).data('id'));
            $('input[name="edit_lembur"]').attr("type", "submit");
            $('input[name="add_lembur"]').attr("type", "hidden");
        });

        $("input#edit_lembur").on("click", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-lembur").reportValidity();
            let awal = new Date($('#periode_awal').val()).getTime();
            let akhir = new Date($('#periode_akhir').val()).getTime();
            const dt = $('#tgl_lembur').val().split("-");
            let date = new Date(dt[2]+'-'+dt[1]+'-'+dt[0]).getTime();
            if (validasi) {
                if(date >= awal && date <= akhir){
                    var formData = new FormData(document.querySelector("#form-lembur"));
                    $.ajax({
                        url: "absensi/edit_lembur",
                        method: "POST",
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        success: function (json) {
                            let result = json.result;
                            let message = json.message;
                            notif(result, message);
                            $("#modal-lembur").modal('hide');
                        },
                    });
                }else{
                    let tgl1 = new Date($('#periode_awal').val()).toLocaleDateString("es-CL");
                    let tgl2 = new Date($('#periode_akhir').val()).toLocaleDateString("es-CL");
                    swal("Faild", "Tanggal tidak boleh, kurang dari "+tgl1+" dan lebih dari "+tgl2+"!", {
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: "btn btn-danger",
                            },
                        },
                    });
                }
            }
        });
        
        $("body").on("click", "#show-form", function (e) {
            e.preventDefault();
            $("#modal-lembur").modal();
            document.getElementById("text-lembur").innerHTML = "Show Form Lembur";
            $('#periode').val($(this).data('ketp'));
            $('#kategori').val($(this).data('kat')).prop("disabled", true);
            $('#tgl_lembur').val($(this).data('tgl')).prop("readonly", true);
            $('#jam_mulai').val($(this).data('mli')).prop("readonly", true);
            $('#jam_selesai').val($(this).data('sli')).prop("readonly", true);
            $('#keterangan').val($(this).data('ket')).prop("readonly", true);
            $('#jumlah').val($(this).data('jml'));
            if($(this).data('sts') == 3){
                $('.alasan-ditolak').removeClass("none");
                $('#show-alasan_ditolak').html($(this).data('als'));
            }else{
                $('.alasan-ditolak').addClass("none");
                $('#show-alasan_ditolak').html("-");
            }
            $('input[name="id_lembur"]').val($(this).data('id'));
            $('input[name="edit_lembur"]').attr("type", "hidden");
            $('input[name="add_lembur"]').attr("type", "hidden");
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
                table_lembur.ajax.reload();
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