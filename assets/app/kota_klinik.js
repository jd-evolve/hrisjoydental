(function ($) {
    var table_kota = $("#datatable-kota").DataTable({
        ajax: {
            url: "masterdata/read_kota",
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
            emptyTable: "Belum ada daftar kota!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah Kota',
                attr:  {
                    id: 'tambah_kota'
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
                    columns: [0,1,2],
                },
                messageTop: "List Kota",
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_kota.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "Inisial" },
            { data: "Kota" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer kota-edit" data-id="'+data+'" id="kota-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer kota-remove" data-id="'+data+'" id="kota-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer kota-restore" data-id="'+data+'" id="kota-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer kota-delete" data-id="'+data+'" id="kota-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "Status" },
        ],
        fnDrawCallback:function(){
            $.ajax({
                url: 'masterdata/level_kota',
                type: 'GET',
                dataType: "json",
                success: function (json) {
                    if(json.tambah){
                        $("#tambah_kota").removeClass("gone");
                    }else{
                        $("#tambah_kota").addClass("gone");
                    }
                    
                    if(json.ubah){
                        $(".kota-edit").removeClass("gone");
                    }else{
                        $(".kota-edit").addClass("gone");
                    }
                    
                    if(json.hapus){
                        $(".kota-remove").removeClass("gone");
                    }else{
                        $(".kota-remove").addClass("gone");
                    }
                }
            });
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.kota-eye').attr('style','');
                $('.kota-edit').attr('style','');
                $('.kota-restore').attr('style',style);
                $('.kota-remove').attr('style','');
                $('.kota-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.kota-eye').attr('style',style);
                $('.kota-edit').attr('style',style);
                $('.kota-restore').attr('style','');
                $('.kota-remove').attr('style',style);
                $('.kota-delete').attr('style',style);
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
        table_kota.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-kota').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-kota').DataTable().search(sta).draw();
        }
    }

    $("body").on("click", "#tambah_kota", function () {
        $("#modal-kota").modal();
        document.getElementById("text-kota").innerHTML = "Tambah Kota";
		$('input[name="inisial_kota"]').val('');
		$('input[name="nama_kota"]').val('');
        $('input[name="edit_kota"]').attr("type", "hidden");
        $('input[name="add_kota"]').attr("type", "submit");
        var count = 0;
        $("body").on("click", "input#add_kota", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-kota").reportValidity();
            if (validasi) {
                count++;
                if (count == 1) {
                    var formData = new FormData(document.querySelector("#form-kota"));
                    $.ajax({
                        url: "masterdata/add_kota",
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
    
    $('body').on('click','#kota-edit',function(){
        $("#modal-kota").modal();
        let id_kota = $(this).data('id');
        document.getElementById("text-kota").innerHTML = "Ubah Kota";
		var data = table_kota.row($(this).parents("tr")).data();
		$('input[name="inisial_kota"]').val(data["Inisial"]);
		$('input[name="nama_kota"]').val(data["Kota"]);
        $('input[name="edit_kota"]').attr("type", "submit");
        $('input[name="add_kota"]').attr("type", "hidden");
        var count = 0;
        $("body").on("click", "input#edit_kota", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-kota").reportValidity();
            if (validasi) {
                count++;
                if (count == 1) {
                    var formData = new FormData(document.querySelector("#form-kota"));
                    formData.append("id_kota", id_kota);
                    $.ajax({
                        url: "masterdata/edit_kota",
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

    $('body').on('click','#kota-restore',function(){
        let id_kota = $(this).data('id');
        action('restore_kota',id_kota,'Data kota akan dikembalikan ke daftar kota aktif!');
    });

    $('body').on('click','#kota-remove',function(){
        let id_kota = $(this).data('id');
        action('remove_kota',id_kota,'Data kota akan dihapus dari daftar kota aktif');
    });

    $('body').on('click','#kota-delete',function(){
        let id_kota = $(this).data('id');
        action('delete_kota',id_kota,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function action(urlfunc,id_kota,text){
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
                        id_kota: id_kota
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
            table_kota.ajax.reload();
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
