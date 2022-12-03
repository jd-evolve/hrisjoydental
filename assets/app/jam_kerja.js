(function ($) {
    var table_jamkerja = $("#datatable-jamkerja").DataTable({
        ajax: {
            url: "absensi/read_jamkerja",
            type: "GET",
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
                "targets": [7],
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
            emptyTable: "Belum ada daftar jam kerja!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah Jam',
                attr:  {
                    id: 'tambah_jamkerja'
                }
            },
            {
                extend: 'pageLength',
                className: "btn btn-primary btn-icon-text wid-max-select mb-1",
                text: '<i class="fa fa-angle-down mr-2" data-feather="check"></i>'
                        +' Entries',
                init:function(api,node,config){
                    $(node).removeClass('btn-primary');
                    $(node).addClass('btn-secondary text-white');
                }
            },
            {
                extend: "excel",
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-file-excel mr-2"></i> Excel',
                exportOptions: {
                    columns: [0,1,2,3,4,5],
                },
                messageTop: "List Jam Kerja",
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_jamkerja.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "Nama" },
            { data: "Masuk" },
            { data: "Pulang" },
            { data: "Dihitung" },
            { data: "Keterangan" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer jamkerja-edit" data-id="'+data+'" id="jamkerja-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer jamkerja-remove" data-id="'+data+'" id="jamkerja-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer jamkerja-restore" data-id="'+data+'" id="jamkerja-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer jamkerja-delete" data-id="'+data+'" id="jamkerja-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "Status" },
        ],
        fnDrawCallback:function(){
            $.ajax({
                url: 'absensi/level_jamkerja',
                type: 'GET',
                dataType: "json",
                success: function (json) {
                    if(json.tambah){
                        $("#tambah_jamkerja").removeClass("gone");
                    }else{
                        $("#tambah_jamkerja").addClass("gone");
                    }
                    
                    if(json.ubah){
                        $(".jamkerja-edit").removeClass("gone");
                    }else{
                        $(".jamkerja-edit").addClass("gone");
                    }
                    
                    if(json.hapus){
                        $(".jamkerja-remove").removeClass("gone");
                    }else{
                        $(".jamkerja-remove").addClass("gone");
                    }
                }
            });
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.jamkerja-edit').attr('style','');
                $('.jamkerja-restore').attr('style',style);
                $('.jamkerja-remove').attr('style','');
                $('.jamkerja-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.jamkerja-edit').attr('style',style);
                $('.jamkerja-restore').attr('style','');
                $('.jamkerja-remove').attr('style',style);
                $('.jamkerja-delete').attr('style',style);
            }
        },
    });

    saveKey();
    $('#filter-search').keyup(function(){
        saveKey();
        filter();
    });

    $('select[name="filter-status"]').change(function() {
        saveKey();
        filter();
    });

    function filter(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (~data[1].toLowerCase().indexOf(src) && 
                ~data[7].toLowerCase().indexOf(sta))
                return true;
            return false;
        })
        table_jamkerja.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-jamkerja').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-jamkerja').DataTable().search(sta).draw();
        }
    }
    
    Inputmask("datetime", {
        inputFormat: "HH:MM:ss",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj",
        max: "24",
    }).mask('.waktu');

    $("#tambah_jamkerja").on("click", function () {
        $("#modal-jamkerja").modal();
        document.getElementById("text-jamkerja").innerHTML = "Tambah Jam Kerja";
		$('input[name="nama"]').val('');
		$('input[name="keterangan"]').val('');
		$('input[name="masuk"]').val('');
		$('input[name="pulang"]').val('');
		$('input[name="dihitung"]').val('');
		$('input[name="sb_jm"]').val('');
		$('input[name="st_jm"]').val('');
		$('input[name="sb_jp"]').val('');
		$('input[name="st_jp"]').val('');
        $('input[name="edit_jamkerja"]').attr("type", "hidden");
        $('input[name="add_jamkerja"]').attr("type", "submit");
        change_time();
        var count = 0;
        $("input#add_jamkerja").on("click", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-jamkerja").reportValidity();
            if(validasi){
                var masuk = $('input[name="masuk"]').val();
                var pulang = $('input[name="pulang"]').val();
                if(masuk.search("_") == -1 && pulang.search("_") == -1){
                    count++;
                    if (count == 1) {
                        var formData = new FormData(document.querySelector("#form-jamkerja"));
                        $.ajax({
                            url: "absensi/add_jamkerja",
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
                    }
                }else{
                    notif('error', 'Format jam tidak sesuai!');
                }
            }
        });
    });
    
    $('body').on('click','#jamkerja-edit', function(){
        $("#modal-jamkerja").modal();
        let id_jam_kerja = $(this).data('id');
        document.getElementById("text-jamkerja").innerHTML = "Ubah Jam Kerja";
		var data = table_jamkerja.row($(this).parents("tr")).data();
		$('input[name="nama"]').val(data['Nama']);
		$('input[name="keterangan"]').val(data['Keterangan']);
		$('input[name="masuk"]').val(data['Masuk']);
		$('input[name="pulang"]').val(data['Pulang']);
		$('input[name="dihitung"]').val(data['Dihitung']);
		$('input[name="sb_jm"]').val(data['sb_jm']);
		$('input[name="st_jm"]').val(data['st_jm']);
		$('input[name="sb_jp"]').val(data['sb_jp']);
		$('input[name="st_jp"]').val(data['st_jp']);
        $("#sb_jm").attr("max",max_time('sebelum',data['Masuk']));
        $("#st_jm").attr("max",max_time('setelah',data['Masuk']));
        $("#sb_jp").attr("max",max_time('sebelum',data['Pulang']));
        $("#st_jp").attr("max",max_time('setelah',data['Pulang']));
        $('input[name="edit_jamkerja"]').attr("type", "submit");
        $('input[name="add_jamkerja"]').attr("type", "hidden");
        change_time();
        var count = 0;
        $("input#edit_jamkerja").on("click", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-jamkerja").reportValidity();
            if (validasi) {
                var masuk = $('input[name="masuk"]').val();
                var pulang = $('input[name="pulang"]').val();
                if(masuk.search("_") == -1 && pulang.search("_") == -1){
                count++;
                    if (count == 1) {
                        var formData = new FormData(document.querySelector("#form-jamkerja"));
                        formData.append("id_jam_kerja", id_jam_kerja);
                        $.ajax({
                            url: "absensi/edit_jamkerja",
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
                    }
                }else{
                    notif('error', 'Format jam tidak sesuai!');
                }
            }
        });
    });

    $('body').on('click','#jamkerja-restore', function(){
        let id_jam_kerja = $(this).data('id');
        action('restore_jamkerja',id_jam_kerja,'Data jam kerja akan dikembalikan ke daftar aktif!');
    });

    $('body').on('click','#jamkerja-remove', function(){
        let id_jam_kerja = $(this).data('id');
        action('remove_jamkerja',id_jam_kerja,'Data jam kerja akan dihapus dari daftar aktif');
    });

    $('body').on('click','#jamkerja-delete', function(){
        let id_jam_kerja = $(this).data('id');
        action('delete_jamkerja',id_jam_kerja,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function change_time(){
        $('#masuk').keyup(function(){
            var time = max_time('sebelum',$('#masuk').val());
            if(!isNaN(time))
                $("#sb_jm").attr("max",time);
        });
        $('#masuk').keyup(function(){
            var time = max_time('setelah',$('#masuk').val());
            if(!isNaN(time))
                $("#st_jm").attr("max",time);
        });
        $('#pulang').keyup(function(){
            var time = max_time('sebelum',$('#pulang').val());
            if(!isNaN(time))
                $("#sb_jp").attr("max",time);
        });
        $('#pulang').keyup(function(){
            var time = max_time('setelah',$('#pulang').val());
            if(!isNaN(time))
                $("#st_jp").attr("max",time);
        });
    }

    function max_time(stsb,time){
        var timemax = new Date();
        if(stsb == "sebelum"){
            var timemax = new Date('1/1/1 00:00:00');
        }else if(stsb == "setelah"){
            var timemax = new Date('1/1/1 23:59:00');
        }
        var diff = Math.abs(new Date('1/1/1 '+time) - timemax);
        var minutes = Math.floor((diff/1000)/60);
        return minutes;
    }

    function action(urlfunc,id_jam_kerja,text){
        swal({
            title: "Apakah anda yakin?",
            text: text,
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Batal",
                    className: "btn btn-danger",
                },
                confirm: {
                    text: "Lanjut",
                    className: "btn btn-success",
                },
            },
        }).then((Delete) => {
            if (Delete) {
                $.ajax({
                    url: "absensi/"+urlfunc,
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_jam_kerja: id_jam_kerja
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
            table_jamkerja.ajax.reload();
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
