(function ($) {
    var table_jadwalkerja = $("#datatable-jadwalkerja").DataTable({
        ajax: {
            url: "absensi/read_jadwalkerja",
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
                "targets": [4],
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
            emptyTable: "Belum ada daftar jadwal kerja!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah Jadwal',
                attr:  {
                    id: 'tambah_jadwalkerja'
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
                    columns: [0,1,2,3],
                },
                messageTop: "List Jadwal Kerja",
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_jadwalkerja.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "Nama" },
            { data: "Keterangan" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer jadwalkerja-edit" data-id="'+data+'" id="jadwalkerja-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer jadwalkerja-remove" data-id="'+data+'" id="jadwalkerja-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer jadwalkerja-restore" data-id="'+data+'" id="jadwalkerja-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer jadwalkerja-delete" data-id="'+data+'" id="jadwalkerja-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "Status" },
        ],
        fnDrawCallback:function(){
            $.ajax({
                url: 'absensi/level_jadwalkerja',
                type: 'GET',
                dataType: "json",
                success: function (json) {
                    if(json.tambah){
                        $("#tambah_jadwalkerja").removeClass("gone");
                    }else{
                        $("#tambah_jadwalkerja").addClass("gone");
                    }
                    
                    if(json.ubah){
                        $(".jadwalkerja-edit").removeClass("gone");
                    }else{
                        $(".jadwalkerja-edit").addClass("gone");
                    }
                    
                    if(json.hapus){
                        $(".jadwalkerja-remove").removeClass("gone");
                    }else{
                        $(".jadwalkerja-remove").addClass("gone");
                    }
                }
            });
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.jadwalkerja-edit').attr('style','');
                $('.jadwalkerja-restore').attr('style',style);
                $('.jadwalkerja-remove').attr('style','');
                $('.jadwalkerja-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.jadwalkerja-edit').attr('style',style);
                $('.jadwalkerja-restore').attr('style','');
                $('.jadwalkerja-remove').attr('style',style);
                $('.jadwalkerja-delete').attr('style',style);
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
                ~data[4].toLowerCase().indexOf(sta))
                return true;
            if (~data[2].toLowerCase().indexOf(src) && 
                ~data[4].toLowerCase().indexOf(sta))
                return true;
            return false;
        })
        table_jadwalkerja.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-jadwalkerja').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-jadwalkerja').DataTable().search(sta).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $('.check-lbr').change(function() {
        let id_hari = $(this).data('idh');
        if(this.checked) {
            $('select[name="jk'+id_hari+'-1"]').val('');
            $('select[name="jk'+id_hari+'-2"]').val('');
            $('select[name="jk'+id_hari+'-3"]').val('');
            $('select[name="jk'+id_hari+'-4"]').val('');
            $('select[name="jk'+id_hari+'-5"]').val('');
        }else{
            var jk1 = $('select[name="jk'+id_hari+'-1"]').val();
            var jk2 = $('select[name="jk'+id_hari+'-2"]').val();
            var jk3 = $('select[name="jk'+id_hari+'-3"]').val();
            var jk4 = $('select[name="jk'+id_hari+'-4"]').val();
            var jk5 = $('select[name="jk'+id_hari+'-5"]').val();
            if (!jk1 && !jk2 && !jk3 && !jk4 && !jk5){
                $("#lbr-"+id_hari).prop("checked", true);
            }else if (jk1 || jk2 || jk3 ||jk4 || jk5){
                $("#lbr-"+id_hari).prop("checked", false);
            }
        }
    });

    $('.slct-jk').change(function() {
        let id_hari = $(this).data('idh');
        var jk1 = $('select[name="jk'+id_hari+'-1"]').val();
        var jk2 = $('select[name="jk'+id_hari+'-2"]').val();
        var jk3 = $('select[name="jk'+id_hari+'-3"]').val();
        var jk4 = $('select[name="jk'+id_hari+'-4"]').val();
        var jk5 = $('select[name="jk'+id_hari+'-5"]').val();
        if (!jk1 && !jk2 && !jk3 && !jk4 && !jk5){
            $("#lbr-"+id_hari).prop("checked", true);
        }else if (jk1 || jk2 || jk3 ||jk4 || jk5){
            $("#lbr-"+id_hari).prop("checked", false);
        }
    });

    $("#tambah_jadwalkerja").on("click", function () {
        $("#modal-jadwalkerja").modal();
		$('input[name="id_jadwal_kerja"]').val('');
        document.getElementById("text-jadwalkerja").innerHTML = "Tambah Jadwal Kerja";
		$('input[name="nama"]').val('');
		$('input[name="keterangan"]').val('');
		$('input[name="add-edit"]').val('Tambah');
        $("#lbr-1").prop("checked", true);
        $("#lbr-2").prop("checked", true);
        $("#lbr-3").prop("checked", true);
        $("#lbr-4").prop("checked", true);
        $("#lbr-5").prop("checked", true);
        $("#lbr-6").prop("checked", true);
        $("#lbr-0").prop("checked", true);
        for (var i=0; i<=6; i++) {
            for(var x=1; x<=5; x++){
                $('select[name="jk'+i+'-'+x+'"]').val('');
            }
        }
    });
    
    $('body').on('click','#jadwalkerja-edit', function(){
        $("#modal-jadwalkerja").modal();
        let id_jadwal_kerja = $(this).data('id');
		$('input[name="id_jadwal_kerja"]').val(id_jadwal_kerja);
        document.getElementById("text-jadwalkerja").innerHTML = "Ubah Jadwal Kerja";
		var data = table_jadwalkerja.row($(this).parents("tr")).data();
		$('input[name="nama"]').val(data['Nama']);
		$('input[name="keterangan"]').val(data['Keterangan']);
		$('input[name="add-edit"]').val('Ubah');
        $.ajax({
            url: "absensi/list_jadwalkerja",
            method: "POST",
            dataType: "json",
            data: {
                id_jadwal_kerja: id_jadwal_kerja
            },
            success: function (data) {
                //Null all data
                $("#lbr-1").prop("checked", false);
                $("#lbr-2").prop("checked", false);
                $("#lbr-3").prop("checked", false);
                $("#lbr-4").prop("checked", false);
                $("#lbr-5").prop("checked", false);
                $("#lbr-6").prop("checked", false);
                $("#lbr-0").prop("checked", false);
                for (var i=0; i<=6; i++) {
                    for(var x=1; x<=5; x++){
                        $('select[name="jk'+i+'-'+x+'"]').val('');
                    }
                }
                //Show all data
                for (var i=0; i<data.length; i++) {
                    if(data[i].libur != 1){
                        $('select[name="'+data[i].id+'"]').val(data[i].id_jk);
                    }else{
                        $("#"+data[i].id).prop("checked", true);
                    }
                }
            },
        });
    });

    $("input#add-edit").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-jadwalkerja").reportValidity();
        if(validasi){
            let list = [];
            for (var id_hari=0; id_hari<=6; id_hari++) {
                var jk1 = $('select[name="jk'+id_hari+'-1"]').val();
                var jk2 = $('select[name="jk'+id_hari+'-2"]').val();
                var jk3 = $('select[name="jk'+id_hari+'-3"]').val();
                var jk4 = $('select[name="jk'+id_hari+'-4"]').val();
                var jk5 = $('select[name="jk'+id_hari+'-5"]').val();
                let data = {};
                if (!jk1 && !jk2 && !jk3 && !jk4 && !jk5){
                    data = {
                        'id_hari' : id_hari,
                        'id_jam_kerja' : 0,
                        'libur' : 1,
                        'urutan' : 1,
                    };
                    list.push(data);
                } else if (jk1 || jk2 || jk3 ||jk4 || jk5){
                    var urutan = 1;
                    for(var x=1; x<=5; x++){
                        var jk = $('select[name="jk'+id_hari+'-'+x+'"]').val();
                        if(jk){
                            data = {
                                'id_hari' : id_hari,
                                'id_jam_kerja' : jk,
                                'libur' : 0,
                                'urutan' : urutan,
                            };
                            list.push(data);
                            urutan++;
                        }
                    }
                }
            }
            $.ajax({
                url: "absensi/edit_add_jadwalkerja",
                method: "POST",
                dataType: "json",
                data: {
                    nama: $('input[name="nama"]').val(),
                    keterangan: $('input[name="keterangan"]').val(),
                    id_jadwal_kerja: $('input[name="id_jadwal_kerja"]').val(),
                    list: JSON.stringify(list)
                },
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    $("#modal-jadwalkerja").modal('hide');
                    notif(result, message);
                },
            });
        }
    });

    $('body').on('click','#jadwalkerja-restore', function(){
        let id_jadwal_kerja = $(this).data('id');
        action('restore_jadwalkerja',id_jadwal_kerja,'Data jadwal kerja akan dikembalikan ke daftar aktif!');
    });

    $('body').on('click','#jadwalkerja-remove', function(){
        let id_jadwal_kerja = $(this).data('id');
        action('remove_jadwalkerja',id_jadwal_kerja,'Data jadwal kerja akan dihapus dari daftar aktif');
    });

    $('body').on('click','#jadwalkerja-delete', function(){
        let id_jadwal_kerja = $(this).data('id');
        action('delete_jadwalkerja',id_jadwal_kerja,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function action(urlfunc,id_jadwal_kerja,text){
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
                        id_jadwal_kerja: id_jadwal_kerja
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
            table_jadwalkerja.ajax.reload();
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
