(function ($) {
    var table_level = $("#datatable-level").DataTable({
        ajax: {
            url: "masterdata/read_level",
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
            emptyTable: "Belum ada daftar level member!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah Level',
                attr:  {
                    id: 'tambah_level'
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
                messageTop: "List Level Member",
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_level.ajax.reload();
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
                    +'<a class="dropdown-item pointer level-edit" data-id="'+data+'" id="level-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer level-remove" data-id="'+data+'" id="level-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer level-restore" data-id="'+data+'" id="level-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer level-delete" data-id="'+data+'" id="level-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "Status" },
        ],
        fnDrawCallback:function(){
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.level-edit').attr('style','');
                $('.level-restore').attr('style',style);
                $('.level-remove').attr('style','');
                $('.level-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.level-edit').attr('style',style);
                $('.level-restore').attr('style','');
                $('.level-remove').attr('style',style);
                $('.level-delete').attr('style',style);
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
        table_level.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-level').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-level').DataTable().search(sta).draw();
        }
    }

    $('input[name="cb-0"]').change(function(){
        if(!isCheck("cb-0")){
            $('.cb').attr("disabled",true);
            $('.cb').prop("checked",false);
        }else{
            $('.cb').attr("disabled",false);
        }
    });

    $('body').on('click','#tambah_level',function(){
        document.getElementById("show-level").style.display = "none";
        document.getElementById("aksi-level").style.display = "unset";
        document.getElementById("update_level").style.display = "none";
        document.getElementById("simpan_level").style.display = "unset";
        document.getElementById("simpan_level").type = "submit";
        document.getElementById("update_level").type = "button";
        $('.cb').attr("disabled",true);
        $('.cb').prop("checked",false);
        $('input[name="cb-0"]').prop("checked",true);
        $('input[name="nama_posisi"]').val('');
        $('input[name="keterangan"]').val('');
        $('input[name="id_posisi"]').val('');
        
        $.ajax({
            url: "masterdata/list_level",
            method: "POST",
            dataType: "json",
            data: {
                id_level: null
            },
            success: function (jsno) {
                $("#table-level-member tbody").html(jsno.html);
                $('input[name="numb"]').val(jsno.numb);
            },
        });

        $("body").on("click", "#simpan_level", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-level").reportValidity();
            if (validasi) {
                var formData = new FormData(document.querySelector("#form-level"));
                var checkbox = $("#form-level-list").find("input[type=checkbox]");
                $.each(checkbox, function(key, val) {
                    formData.append($(val).attr('name'), $(this).is(':checked')+','+$(val).attr('value'))
                });
                $.ajax({
                    url: "masterdata/add_level",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message, 1);
                    },
                });
            }
            return false;
        });
    });

    $('body').on('click','#level-edit',function(){
        document.getElementById("show-level").style.display = "none";
        document.getElementById("aksi-level").style.display = "unset";
        document.getElementById("update_level").style.display = "unset";
        document.getElementById("simpan_level").style.display = "none";
        document.getElementById("simpan_level").type = "button";
        document.getElementById("update_level").type = "submit";

        let id_level = $(this).data('id');
        let data = table_level.row($(this).parents("tr")).data();
        $('input[name="nama_posisi"]').val(data["Nama"]);
        $('input[name="keterangan"]').val(data["Keterangan"]);
        $('input[name="id_posisi"]').val(id_level);
        
        $.ajax({
            url: "masterdata/list_level",
            method: "POST",
            dataType: "json",
            data: {
                id_level: id_level
            },
            success: function (jsno) {
                $("#table-level-member tbody").html(jsno.html);
                $('input[name="numb"]').val(jsno.numb);
            },
        });
        
        $("body").on("click", "#update_level", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-level").reportValidity();
            if (validasi) {
                var formData = new FormData(document.querySelector("#form-level"));
                var checkbox = $("#form-level-list").find("input[type=checkbox]");
                $.each(checkbox, function(key, val) {
                    formData.append($(val).attr('name'), $(this).is(':checked')+','+$(val).attr('value'))
                });
                $.ajax({
                    url: "masterdata/edit_level",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function (json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message, 1);
                    },
                });
            }
            return false;
        });
    });

    $('body').on('click','#level-restore',function(){
        let id_level = $(this).data('id');
        action('restore_level',id_level,'Level member akan dikembalikan ke daftar data aktif!');
    });

    $('body').on('click','#level-remove',function(){
        let id_level = $(this).data('id');
        action('remove_level',id_level,'Level member akan dihapus dari daftar data aktif!');
    });

    $('body').on('click','#level-delete',function(){
        let id_level = $(this).data('id');
        action('delete_level',id_level,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function action(urlfunc,id_level,text){
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
                        id_posisi: id_level
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
            table_level.ajax.reload();
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
    
    function isCheck(name){
        var checked = $('input[name='+name+']:checked').val();
        if (checked == undefined){
            return true;
        } else {
            return false;
        }
    }
})(jQuery);
