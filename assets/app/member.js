(function ($) {
    var table_member = $("#datatable-member").DataTable({
        ajax: {
            url: "masterdata/read_member",
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
                "targets": [7,8,9,10,11,12,13,14,15,16,17,18,19,20,21],
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
            emptyTable: "Belum ada daftar member!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah Member',
                attr:  {
                    id: 'tambah_member'
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
                messageTop: "List Member",
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_member.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "Nama" },
            { data: "Posisi" },
            { data: "Nohp" },
            { data: "Email" },
            { data: "AlamatLengkap" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer member-edit" data-id="'+data+'" id="member-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer member-restore" data-id="'+data+'" id="member-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer member-remove" data-id="'+data+'" id="member-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer member-delete" data-id="'+data+'" id="member-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "Status" },
            { data: "IDposisi" },
            { data: "AlamatLengkap" },
            { data: "id_posisi" },
            { data: "tgl_masuk" },
            { data: "Gender" },
            { data: "Kode" },
            { data: "No_induk" },
            { data: "sisa_cuti" },
            { data: "nama_bank" },
            { data: "nama_rek" },
            { data: "no_rek" },
            { data: "id_kota" },
            { data: "tempat_lahir" },
            { data: "tgl_lahir" },
        ],
        fnDrawCallback:function(){
            $.ajax({
                url: 'masterdata/level_member',
                type: 'GET',
                dataType: "json",
                success: function (json) {
                    if(json.tambah){
                        $("#tambah_member").removeClass("gone");
                    }else{
                        $("#tambah_member").addClass("gone");
                    }
                    
                    if(json.ubah){
                        $(".member-edit").removeClass("gone");
                    }else{
                        $(".member-edit").addClass("gone");
                    }
                    
                    if(json.hapus){
                        $(".member-remove").removeClass("gone");
                    }else{
                        $(".member-remove").addClass("gone");
                    }
                }
            });
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.member-edit').attr('style','');
                $('.member-restore').attr('style',style);
                $('.member-remove').attr('style','');
                $('.member-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.member-edit').attr('style',style);
                $('.member-restore').attr('style','');
                $('.member-remove').attr('style',style);
                $('.member-delete').attr('style',style);
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

    $('select[name="filter-posisi"]').change(function() {
        saveKey();
        filter();
    });

    function filter(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var pos = $('select[name="filter-posisi"]').val().toLowerCase();
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (~data[1].toLowerCase().indexOf(src) && 
                ~data[8].toLowerCase().indexOf(pos) &&
                ~data[7].toLowerCase().indexOf(sta))
                return true;
            if (~data[2].toLowerCase().indexOf(src) && 
                ~data[8].toLowerCase().indexOf(pos) &&
                ~data[7].toLowerCase().indexOf(sta))
                return true;
            if (~data[4].toLowerCase().indexOf(src) && 
                ~data[8].toLowerCase().indexOf(pos) &&
                ~data[7].toLowerCase().indexOf(sta))
                return true;
            if (~data[5].toLowerCase().indexOf(src) && 
                ~data[8].toLowerCase().indexOf(pos) &&
                ~data[7].toLowerCase().indexOf(sta))
                return true;
                
            return false;
        })
        table_member.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var pos = $('select[name="filter-posisi"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-member').DataTable().search(src).draw();
        }
        if(pos != undefined){
            $('#datatable-member').DataTable().search(pos).draw();
        }
        if(sta != undefined){
            $('#datatable-member').DataTable().search(sta).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_member").on("click", function () {
        $("#modal-member").modal();
        document.getElementById("text-member").innerHTML = "Tambah Member";
		$('input[name="kode"]').val('');
		$('input[name="nomor_induk"]').val('');
		$('input[name="nama"]').val('');
        $('select[name="gender"]').val('');
		$('input[name="tempat_lahir"]').val('');
		$('input[name="tgl_lahir"]').val('');
		$('input[name="nohp"]').val('');
		$('input[name="email"]').val('');
		$('input[name="alamat"]').val('');
		$('input[name="nama_bank"]').val('');
		$('input[name="no_rek"]').val('');
		$('input[name="nama_rek"]').val('');
		$('input[name="sisa_cuti"]').val('');
        $('select[name="posisi"]').val('');
        $('select[name="kota"]').val('');
		$('input[name="tgl_masuk"]').val(moment().format("DD-MM-YYYY"));
        $('input[name="edit_member"]').attr("type", "hidden");
        $('input[name="add_member"]').attr("type", "submit");
        var count = 0;
        $("input#add_member").on("click", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-member").reportValidity();
            if (validasi) {
                count++;
                if (count == 1) {
                    var formData = new FormData(document.querySelector("#form-member"));
                    $.ajax({
                        url: "masterdata/add_member",
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
    
    $('#member-edit').on('click', function(){
        $("#modal-member").modal();
        let id_account = $(this).data('id');
        document.getElementById("text-member").innerHTML = "Ubah Member";
		var data = table_member.row($(this).parents("tr")).data();
		$('input[name="kode"]').val(data["Kode"]);
		$('input[name="nomor_induk"]').val(data["No_induk"]);
        $('select[name="gender"]').val(data["Gender"]);
		$('input[name="tempat_lahir"]').val(data["tempat_lahir"]);
		$('input[name="tgl_lahir"]').val(data["tgl_lahir"]);
		$('input[name="nama_bank"]').val(data["nama_bank"]);
		$('input[name="no_rek"]').val(data["no_rek"]);
		$('input[name="nama_rek"]').val(data["nama_rek"]);
		$('input[name="sisa_cuti"]').val(data["sisa_cuti"]);
		$('input[name="nama"]').val(data["Nama"]);
		$('input[name="email"]').val(data["Email"]);
		$('input[name="nohp"]').val(data["Nohp"]);
		$('input[name="alamat"]').val(data["AlamatLengkap"]);
		$('input[name="tgl_masuk"]').val(data["tgl_masuk"]);
        $('select[name="posisi"]').val(data["id_posisi"]);
        $('select[name="kota"]').val(data["id_kota"]);

        $('input[name="edit_member"]').attr("type", "submit");
        $('input[name="add_member"]').attr("type", "hidden");
        var count = 0;
        $("input#edit_member").on("click", function (e) {
            e.preventDefault();
            let validasi = document.getElementById("form-member").reportValidity();
            if (validasi) {
                count++;
                if (count == 1) {
                    var formData = new FormData(document.querySelector("#form-member"));
                    formData.append("id_account", id_account);
                    $.ajax({
                        url: "masterdata/edit_member",
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

    $('#member-restore').on('click', function(){
        let id_account = $(this).data('id');
        action('restore_member',id_account,'Member akan dikembalikan ke daftar data aktif!');
    });

    $('#member-remove').on('click', function(){
        let id_account = $(this).data('id');
        action('remove_member',id_account,'Member akan dihapus dari daftar data aktif!');
    });

    $('#member-delete').on('click', function(){
        let id_account = $(this).data('id');
        action('delete_member',id_account,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function action(urlfunc,id_account,text){
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
                        id_account: id_account
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
            table_member.ajax.reload();
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
