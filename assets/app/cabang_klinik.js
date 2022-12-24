(function ($) {
    var table_cabang = $("#datatable-cabang").DataTable({
        ajax: {
            url: "masterdata/read_cabang",
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
            emptyTable: "Belum ada daftar cabang!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah Cabang',
                attr:  {
                    id: 'tambah_cabang'
                }
            },
            {
                extend: 'pageLength',
                className: "btn btn-primary btn-icon-text wid-max-select",
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
                    columns: [0,1,2,3,4],
                },
                messageTop: "List Cabang",
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_cabang.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "Kode" },
            { data: "Cabang" },
            { data: "PT" },
            { data: "Alamat" },
            { data: "SN" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer cabang-edit" data-id="'+data+'" id="cabang-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer cabang-remove" data-id="'+data+'" id="cabang-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer cabang-restore" data-id="'+data+'" id="cabang-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer cabang-delete" data-id="'+data+'" id="cabang-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "Status" },
        ],
        fnDrawCallback:function(){
            $.ajax({
                url: 'masterdata/level_cabang',
                type: 'GET',
                dataType: "json",
                success: function (json) {
                    if(json.tambah){
                        $("#tambah_cabang").removeClass("gone");
                    }else{
                        $("#tambah_cabang").addClass("gone");
                    }
                    
                    if(json.ubah){
                        $(".cabang-edit").removeClass("gone");
                    }else{
                        $(".cabang-edit").addClass("gone");
                    }
                    
                    if(json.hapus){
                        $(".cabang-remove").removeClass("gone");
                    }else{
                        $(".cabang-remove").addClass("gone");
                    }
                }
            });
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.cabang-edit').attr('style','');
                $('.cabang-restore').attr('style',style);
                $('.cabang-remove').attr('style','');
                $('.cabang-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.cabang-edit').attr('style',style);
                $('.cabang-restore').attr('style','');
                $('.cabang-remove').attr('style',style);
                $('.cabang-delete').attr('style',style);
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
            if (~data[2].toLowerCase().indexOf(src) && 
                ~data[7].toLowerCase().indexOf(sta))
                return true;
            if (~data[3].toLowerCase().indexOf(src) && 
                ~data[7].toLowerCase().indexOf(sta))
                return true;
            return false;
        })
        table_cabang.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-cabang').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-cabang').DataTable().search(sta).draw();
        }
    }

    $("#tambah_cabang").on("click", function () {
        $("#modal-cabang").modal();
        document.getElementById("text-cabang").innerHTML = "Tambah Cabang";
		$('input[name="kode_cabang"]').val('');
		$('input[name="nama_cabang"]').val('');
		$('input[name="nama_pt"]').val('');
		$('#alamat_cabang').val('');
		$('input[name="sn_mesin"]').val('');
        $('input[name="edit_cabang"]').attr("type", "hidden");
        $('input[name="add_cabang"]').attr("type", "submit");
    });
    
    $("input#add_cabang").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-cabang").reportValidity();
        if (validasi) {
            var formData = new FormData(document.querySelector("#form-cabang"));
            $.ajax({
                url: "masterdata/add_cabang",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-cabang").modal('hide');
                },
            });
        }
    });
    
    $('body').on('click','#cabang-edit', function(){
        $("#modal-cabang").modal();
        let id_cabang = $(this).data('id');
        document.getElementById("text-cabang").innerHTML = "Ubah Cabang";
		var data = table_cabang.row($(this).parents("tr")).data();
		$('input[name="kode_cabang"]').val(data["Kode"]);
		$('input[name="nama_cabang"]').val(data["Cabang"]);
		$('input[name="nama_pt"]').val(data["PT"]);
		$('#alamat_cabang').val(data["Alamat"]);
		$('input[name="sn_mesin"]').val(data["SN"]);
		$('input[name="id_cabang"]').val(id_cabang);
        $('input[name="edit_cabang"]').attr("type", "submit");
        $('input[name="add_cabang"]').attr("type", "hidden");
    });

    $("input#edit_cabang").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-cabang").reportValidity();
        if (validasi) {
            var formData = new FormData(document.querySelector("#form-cabang"));
            $.ajax({
                url: "masterdata/edit_cabang",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-cabang").modal('hide');
                },
            });
        }
    });

    $('body').on('click','#cabang-restore', function(){
        let id_cabang = $(this).data('id');
        action('restore_cabang',id_cabang,'Data cabang akan dikembalikan ke daftar cabang aktif!');
    });

    $('body').on('click','#cabang-remove', function(){
        let id_cabang = $(this).data('id');
        action('remove_cabang',id_cabang,'Data cabang akan dihapus dari daftar cabang aktif');
    });

    $('body').on('click','#cabang-delete', function(){
        let id_cabang = $(this).data('id');
        action('delete_cabang',id_cabang,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function action(urlfunc,id_cabang,text){
        swal({
            title: "Apakah anda yakin?",
            text: text,
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Kembali",
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
                        id_cabang: id_cabang
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
            table_cabang.ajax.reload();
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
