(function ($) {
    var table_account = $("#datatable-account").DataTable({
        ajax: {
            url: "masterdata/read_account",
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
                "targets": [7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37],
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
            emptyTable: "Belum ada daftar account!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Tambah Account',
                attr:  {
                    id: 'tambah_account'
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
                    columns: [0,1,2,3,4,5],
                },
                messageTop: "List Account",
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_account.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "nama_account" },
            { data: "nama_posisi" },
            { data: "telp" },
            { data: "email" },
            { data: "alamat" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<div class="btn-group" role="group">'
                +'<button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    +'Action'
                +'</button>'
                +'<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">'
                    +'<a class="dropdown-item pointer account-lihat" data-id="'+data+'" id="account-lihat"> <i class="fas fa-eye"></i> Lihat</a>'
                    +'<a class="dropdown-item pointer account-edit" data-id="'+data+'" id="account-edit"> <i class="fas fa-pen"></i> Edit</a>'
                    +'<a class="dropdown-item pointer account-salary" data-id="'+data+'" id="account-salary"> <i class="fas fa-file-invoice-dollar"></i> Salary</a>'
                    +'<a class="dropdown-item pointer account-restore" data-id="'+data+'" id="account-restore"> <i class="fas fa-undo-alt"></i> Restore</a>'
                    +'<a class="dropdown-item pointer account-remove" data-id="'+data+'" id="account-remove"> <i class="fas fa-trash"></i> Remove</a>'
                    +'<a class="dropdown-item pointer account-delete" data-id="'+data+'" id="account-delete"> <i class="fas fa-trash-alt"></i> Delete</a>'
                +'</div>'
                +'</div>':
                data;
            }},
            { data: "status" },
            { data: "IDposisi" },
            { data: "alamat" },
            { data: "id_posisi" },
            { data: "tgl_masuk" },
            { data: "gender" },
            { data: "Kode" },
            { data: "nomor_induk" },
            { data: "sisa_cuti" },
            { data: "nama_bank" },
            { data: "nama_rek" },
            { data: "no_rek" },
            { data: "id_cabang" },
            { data: "tempat_lahir" },
            { data: "tgl_lahir" },
            { data: "bagian" },
            { data: "nama_cabang" },
            { data: "level" },
            { data: "no_ktp" },
            { data: "nama_ibu" },
            { data: "telp_referensi" },
            { data: "pendidikan_terakhir" },
            { data: "lulus_dari" },
            { data: "alamat_ktp" },
            { data: "status_karyawan" },
            { data: "tgl_evaluasi" },
            { data: "tgl_resign" },
            { data: "alasan_resign" },
            { data: "masa_kerja" },
            { data: "id_jadwal_kerja" },
            { data: "nama_jadwal_kerja" },
        ],
        fnDrawCallback:function(){
            $.ajax({
                url: 'masterdata/level_account',
                type: 'GET',
                dataType: "json",
                success: function (json) {
                    if(json.tambah){
                        $("#tambah_account").removeClass("gone");
                    }else{
                        $("#tambah_account").addClass("gone");
                    }
                    
                    if(json.ubah){
                        $(".account-edit").removeClass("gone");
                        $(".account-salary").removeClass("gone");
                    }else{
                        $(".account-edit").addClass("gone");
                        $(".account-salary").addClass("gone");
                    }
                    
                    if(json.hapus){
                        $(".account-remove").removeClass("gone");
                    }else{
                        $(".account-remove").addClass("gone");
                    }
                }
            });
            var sta = $('select[name="filter-status"]').val().toLowerCase();
            let style = 'display:none;';
            if(sta == 'aktif-'){
                $('.account-edit').attr('style','');
                $('.account-salary').attr('style','');
                $('.account-restore').attr('style',style);
                $('.account-remove').attr('style','');
                $('.account-delete').attr('style',style);
            }else if(sta == 'hapus-'){
                $('.account-edit').attr('style',style);
                $('.account-salary').attr('style',style);
                $('.account-restore').attr('style','');
                $('.account-remove').attr('style',style);
                $('.account-delete').attr('style',style);
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
        table_account.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        var pos = $('select[name="filter-posisi"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-account').DataTable().search(src).draw();
        }
        if(pos != undefined){
            $('#datatable-account').DataTable().search(pos).draw();
        }
        if(sta != undefined){
            $('#datatable-account').DataTable().search(sta).draw();
        }
    }

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_account").on("click", function () {
        $("#modal-account").modal();
        document.getElementById("text-account").innerHTML = "Tambah Account";
		$('input[name="kode"]').val('');
		$('input[name="nomor_induk"]').val('');
		$('input[name="nomor_ktp"]').val('');
		$('input[name="nomor_npwp"]').val('');
		$('input[name="nama_ibu"]').val('');
		$('input[name="nama"]').val('');
        $('select[name="gender"]').val('');
		$('input[name="tempat_lahir"]').val('');
		$('input[name="tgl_lahir"]').val('');
		$('input[name="nohp"]').val('');
		$('input[name="nohp2"]').val('');
		$('input[name="sisa_cuti"]').val('');
		$('input[name="jam_perhari"]').val('');
		$('select[name="pendidikan_terakhir"]').val('');
		$('input[name="lulus_dari"]').val('');
		$('input[name="email"]').val('');
		$('input[name="alamat"]').val('');
		$('input[name="alamat2"]').val('');
		$('input[name="nama_bank"]').val('');
		$('input[name="no_rek"]').val('');
		$('input[name="nama_rek"]').val('');
        $('select[name="level"]').val('');
        $('select[name="bagian"]').val('');
        $('select[name="posisi"]').val('');
        $('select[name="jadwal_kerja"]').val('');
        $('select[name="status_karyawan"]').val('');
		$('input[name="tgl_masuk"]').val('');
		$('input[name="tgl_evaluasi"]').val('');
		$('input[name="tgl_keluar"]').val('');
		$('input[name="alasan_keluar"]').val('');
        $('select[name="cabang"]').val('');
        $('input[name="edit_account"]').attr("type", "hidden");
        $('input[name="add_account"]').attr("type", "submit");
    });
    
    $("input#add_account").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-account").reportValidity();
        if (validasi) {
            var formData = new FormData(document.querySelector("#form-account"));
            $.ajax({
                url: "masterdata/add_account",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-account").modal('hide');
                },
            });
        }
    });
    
    $('body').on('click','#account-lihat',function(){
        $("#modal-lihat").modal();
		var data = table_account.row($(this).parents("tr")).data();
        document.getElementById("text-lihat").innerHTML = "Data account : <b>"+data["nama_account"]+'</b>';
		$("#show-kode").html(data["Kode"]);
		$("#show-nomor_induk").html(data["nomor_induk"]);
		$("#show-nomor_ktp").html(data["no_ktp"]);
		$("#show-nomor_npwp").html(data["no_npwp"]);
		$("#show-nama_ibu").html(data["nama_ibu"]);
        $("#show-gender").html(data["gender"] != 0 ? 'Laki-Laki' : 'Perempuan');
		$("#show-tempat_lahir").html(data["tempat_lahir"]);
		$("#show-tgl_lahir").html(data["tgl_lahir"]);
		$("#show-nama_bank").html(data["nama_bank"]);
		$("#show-no_rek").html(data["no_rek"]);
		$("#show-nama_rek").html(data["nama_rek"]);
		$("#show-sisa_cuti").html(data["sisa_cuti"]);
		$("#show-jam_perhari").html(data["jam_perhari"]);
		$("#show-nama").html(data["nama_account"]);
		$("#show-email").html(data["email"]);
		$("#show-telp").html(data["telp"]);
		$("#show-telp2").html(data["telp_referensi"]);
		$("#show-alamat").html(data["alamat"]);
		$("#show-alamat2").html(data["alamat_ktp"]);
		$("#show-pendidikan_terakhir").html(data["pendidikan_terakhir"]);
		$("#show-lulus_dari").html(data["lulus_dari"]);
		$("#show-tgl_masuk").html(data["tgl_masuk"]);
		$("#show-tgl_evaluasi").html(data["tgl_evaluasi"]);
		$("#show-tgl_keluar").html(data["tgl_resign"]);
		$("#show-status_karyawan").html(data["status_karyawan"] == 1 ? 'Tetap' : 'Percobaan');
        $("#show-level").html(data["level"] == 1 ? 'Staff' : 'Atasan');
        $("#show-bagian").html(data["bagian"]);
        $("#show-posisi").html(data["nama_posisi"]);
        $("#show-jadwal_kerja").html(data["nama_jadwal_kerja"]);
        $("#show-alasan_keluar").html(data["alasan_resign"]);
        $("#show-masa_kerja").html(data["masa_kerja"]);
        $("#show-cabang_klinik").html(data["nama_cabang"]);
    });
    
    $('body').on('click','#account-edit', function(){
        $("#modal-account").modal();
        let id_account = $(this).data('id');
        document.getElementById("text-account").innerHTML = "Ubah Account";
		var data = table_account.row($(this).parents("tr")).data();
		$('input[name="kode"]').val(data["Kode"]);
		$('input[name="nomor_induk"]').val(data["nomor_induk"]);
		$('input[name="nomor_ktp"]').val(data["no_ktp"]);
		$('input[name="nomor_npwp"]').val(data["no_npwp"]);
		$('input[name="nama_ibu"]').val(data["nama_ibu"]);
		$('input[name="nama"]').val(data["nama_account"]);
        $('select[name="gender"]').val(data["gender"]);
		$('input[name="tempat_lahir"]').val(data["tempat_lahir"]);
		$('input[name="tgl_lahir"]').val(data["tgl_lahir"]);
		$('input[name="nohp"]').val(data["telp"]);
		$('input[name="nohp2"]').val(data["telp_referensi"]);
		$('input[name="sisa_cuti"]').val(data["sisa_cuti"]);
		$('input[name="jam_perhari"]').val(data["jam_perhari"]);
		$('select[name="pendidikan_terakhir"]').val(data["pendidikan_terakhir"]);
		$('input[name="lulus_dari"]').val(data["lulus_dari"]);
		$('input[name="email"]').val(data["email"]);
		$('input[name="alamat"]').val(data["alamat"]);
		$('input[name="alamat2"]').val(data["alamat_ktp"]);
		$('input[name="nama_bank"]').val(data["nama_bank"]);
		$('input[name="no_rek"]').val(data["no_rek"]);
		$('input[name="nama_rek"]').val(data["nama_rek"]);
        $('select[name="level"]').val(data["level"]);
        $('select[name="bagian"]').val(data["bagian"]);
        $('select[name="posisi"]').val(data["id_posisi"]);
        $('select[name="jadwal_kerja"]').val(data["id_jadwal_kerja"]);
        $('select[name="status_karyawan"]').val(data["status_karyawan"]);
		$('input[name="tgl_masuk"]').val(data["tgl_masuk"]);
		$('input[name="tgl_evaluasi"]').val(data["tgl_evaluasi"]);
		$('input[name="tgl_keluar"]').val(data["tgl_resign"]);
		$('input[name="alasan_keluar"]').val(data["alasan_resign"]);
        $('select[name="cabang"]').val(data["id_cabang"]);
		$('input[name="id_account"]').val(id_account);
        $('input[name="edit_account"]').attr("type", "submit");
        $('input[name="add_account"]').attr("type", "hidden");
    });
    
    $("input#edit_account").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-account").reportValidity();
        if (validasi) {
            var formData = new FormData(document.querySelector("#form-account"));
            $.ajax({
                url: "masterdata/edit_account",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-account").modal('hide');
                },
            });
        }
    });

    $('body').on('click','#account-salary', function(){
        $("#modal-salary").modal();
        let id_account = $(this).data('id');
		var data = table_account.row($(this).parents("tr")).data();
		$('input[name="gaji_tetap"]').val(data["gaji_tetap"]);
		$('input[name="insentif"]').val(data["insentif"]);
		$('input[name="uang_makan"]').val(data["uang_makan"]);
		$('input[name="uang_transport"]').val(data["uang_transport"]);
		$('input[name="uang_hlibur"]').val(data["uang_hlibur"]);
		$('input[name="uang_lembur"]').val(data["uang_lembur"]);
		$('input[name="uang_shift"]').val(data["uang_shift"]);
		$('input[name="tunjangan_jabatan"]').val(data["tunjangan_jabatan"]);
		$('input[name="tunjangan_str"]').val(data["tunjangan_str"]);
		$('input[name="tunjangan_pph21"]').val(data["tunjangan_pph21"]);
		$('input[name="bpjs_kesehatan"]').val(data["bpjs_kesehatan"]);
		$('input[name="bpjs_tk"]').val(data["bpjs_tk"]);
		$('input[name="bpjs_corporate"]').val(data["bpjs_corporate"]);
		$('input[name="id_account"]').val(id_account);
        $('#gaji_tetap').keyup(function(){
            var gaji = $(this).val().split('.').join('');
            var u_lembur = parseInt(gaji/173).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            var u_shift = parseInt(gaji/25).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            const pph21 = gaji > data["pph21_ketentuan_gaji"] && data["no_npwp"] ? (data["pph21_persen_gaji"]/100*gaji) : 0;
            var u_pph21 = parseInt(pph21).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            $('input[name="uang_lembur"]').val(u_lembur);
            $('input[name="uang_shift"]').val(u_shift);
            $('input[name="tunjangan_pph21"]').val(u_pph21);
        });
    });
    
    $("input#edit_salary").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-salary").reportValidity();
        if (validasi) {
            var formData = new FormData(document.querySelector("#form-salary"));
            $.ajax({
                url: "masterdata/edit_account_salary",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                    $("#modal-salary").modal('hide');
                },
            });
        }
    });

    $('body').on('click','#account-restore', function(){
        let id_account = $(this).data('id');
        action('restore_account',id_account,'Account akan dikembalikan ke daftar data aktif!');
    });

    $('body').on('click','#account-remove', function(){
        let id_account = $(this).data('id');
        action('remove_account',id_account,'Account akan dihapus dari daftar data aktif!');
    });

    $('body').on('click','#account-delete', function(){
        let id_account = $(this).data('id');
        action('delete_account',id_account,'Data yang di hapus tidak dapat dikembalikan lagi!');
    });

    function action(urlfunc,id_account,text){
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
            table_account.ajax.reload();
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
