(function ($) {
    var table_kegiatan = $("#datatable-kegiatan").DataTable({
        ajax: {
            url: "masterdata/read_kegiatan",
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
                "targets": [5],
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
            emptyTable: "Belum ada daftar pengumuman/kegiatan!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah Info',
                attr:  {
                    id: 'tambah_kegiatan'
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
                messageTop: "List Kegiatan",
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_kegiatan.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "Tanggal" },
            { data: "Kegiatan" },
            { data: "Oleh" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer kegiatan-edit" data-id="'+data+'" id="kegiatan-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer kegiatan-remove" data-id="'+data+'" id="kegiatan-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer kegiatan-restore" data-id="'+data+'" id="kegiatan-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer kegiatan-delete" data-id="'+data+'" id="kegiatan-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "Status" },
        ],
        fnDrawCallback:function(){
            $.ajax({
                url: 'masterdata/level_kegiatan',
                type: 'GET',
                dataType: "json",
                success: function (json) {
                    if(json.tambah){
                        $("#tambah_kegiatan").removeClass("gone");
                    }else{
                        $("#tambah_kegiatan").addClass("gone");
                    }
                    
                    if(json.ubah){
                        $(".kegiatan-edit").removeClass("gone");
                    }else{
                        $(".kegiatan-edit").addClass("gone");
                    }
                    
                    if(json.hapus){
                        $(".kegiatan-remove").removeClass("gone");
                    }else{
                        $(".kegiatan-remove").addClass("gone");
                    }
                }
            });
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.kegiatan-edit').attr('style','');
                $('.kegiatan-restore').attr('style',style);
                $('.kegiatan-remove').attr('style','');
                $('.kegiatan-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.kegiatan-edit').attr('style',style);
                $('.kegiatan-restore').attr('style','');
                $('.kegiatan-remove').attr('style',style);
                $('.kegiatan-delete').attr('style',style);
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
                ~data[5].toLowerCase().indexOf(sta))
                return true;
            if (~data[2].toLowerCase().indexOf(src) && 
                ~data[5].toLowerCase().indexOf(sta))
                return true;
            if (~data[3].toLowerCase().indexOf(src) && 
                ~data[5].toLowerCase().indexOf(sta))
                return true;
            return false;
        })
        table_kegiatan.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-kegiatan').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-kegiatan').DataTable().search(sta).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_kegiatan").on("click", function () {
        $("#modal-kegiatan").modal();
        document.getElementById("text-kegiatan").innerHTML = "Tambah Pengumuman/Kegiatan";
		$('input[name="tgl_kegiatan"]').val('');
		$('#kegiatan').val('');
        $('input[name="edit_kegiatan"]').attr("type", "hidden");
        $('input[name="add_kegiatan"]').attr("type", "submit");
        var count = 0;
        $("input#add_kegiatan").on("click", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-kegiatan").reportValidity();
            if (validasi) {
                count++;
                if (count == 1) {
                    var formData = new FormData(document.querySelector("#form-kegiatan"));
                    $.ajax({
                        url: "masterdata/add_kegiatan",
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
            }
        });

    });
    
    $('body').on('click','#kegiatan-edit', function(){
        $("#modal-kegiatan").modal();
        let id_kegiatan = $(this).data('id');
        document.getElementById("text-kegiatan").innerHTML = "Ubah Pengumuman/Kegiatan";
		var data = table_kegiatan.row($(this).parents("tr")).data();
		$('input[name="tgl_kegiatan"]').val(data["Tanggal"]);
		$('#kegiatan').val(data["Kegiatan"]);
        $('input[name="edit_kegiatan"]').attr("type", "submit");
        $('input[name="add_kegiatan"]').attr("type", "hidden");
        var count = 0;
        $("input#edit_kegiatan").on("click", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-kegiatan").reportValidity();
            if (validasi) {
                count++;
                if (count == 1) {
                    var formData = new FormData(document.querySelector("#form-kegiatan"));
                    formData.append("id_kegiatan", id_kegiatan);
                    $.ajax({
                        url: "masterdata/edit_kegiatan",
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
            }
        });
    });

    $('body').on('click','#kegiatan-restore', function(){
        let id_kegiatan = $(this).data('id');
        action('restore_kegiatan',id_kegiatan,'Data kegiatan akan dikembalikan ke daftar kegiatan aktif!');
    });

    $('body').on('click','#kegiatan-remove', function(){
        let id_kegiatan = $(this).data('id');
        action('remove_kegiatan',id_kegiatan,'Data kegiatan akan dihapus dari daftar kegiatan aktif');
    });

    $('body').on('click','#kegiatan-delete', function(){
        let id_kegiatan = $(this).data('id');
        action('delete_kegiatan',id_kegiatan,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function action(urlfunc,id_kegiatan,text){
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
                    url: "masterdata/"+urlfunc,
                    method: "POST",
                    dataType: "json",
                    data: {
                        id_kegiatan: id_kegiatan
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
            table_kegiatan.ajax.reload();
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
