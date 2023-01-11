(function ($) {
    var table_dinasluar = $("#datatable-dinasluar").DataTable({
        ajax: {
            url: "dinasluar/read_dinasluar",
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
                "targets": [6],
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
            emptyTable: "Belum ada daftar dinasluar!",
            infoEmpty: "Tidak ada data untuk ditampilkan!",
            info: "_START_ to _END_ of _TOTAL_ entries",
            infoFiltered: ""
        },
        dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
                className: "btn btn-warning wid-max-select text-white",
                text: '<i class="fas fa-plus mr-2"></i> Buat Pengajuan Dinas',
                attr:  {
                    id: 'tambah_dinasluar'
                }
            },
            {
                className: "btn btn-secondary wid-max-select text-white",
                text: '<i class="fas fa-sync-alt mr-2"></i> Refresh',
                action: function (e, dt, node, config) {
                    table_dinasluar.ajax.reload();
                },
            },
        ],
        columns: [
            { data: "No" },
            { data: "Tujuan" },
            { data: "Nama" },
            { data: "Tanggal" },
            { data: "Keperluan" },
            { data: "Aksi" , render : function ( data, type, row, meta ) {
                return type === 'display'  ?
                '<button type="button" data-id="'+data+'" id="show-detail" class="btn btn-icon btn-round btn-secondary btn-sm" title="Lihat ijin/cuti dan lakukan acc atau tolak.">'+
                    '<i class="fas fa-folder-open"></i>'+
                '</button>':
                data;
            }},
            { data: "Status" },
        ],
        rowCallback:function(row,data,index){
            $('td', row).eq(2).addClass('nowraping');
            $('td', row).eq(3).addClass('nowraping');
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
                ~data[6].toLowerCase().indexOf(sta))
                return true;
            if (~data[2].toLowerCase().indexOf(src) && 
                ~data[6].toLowerCase().indexOf(sta))
                return true;
            if (~data[3].toLowerCase().indexOf(src) && 
                ~data[6].toLowerCase().indexOf(sta))
                return true;
            if (~data[4].toLowerCase().indexOf(src) && 
                ~data[6].toLowerCase().indexOf(sta))
                return true;
            return false;
        })
        table_dinasluar.draw(); 
        $.fn.dataTable.ext.search.pop();
    }

    function saveKey(){
        var src = $('input[name="filter-search"]').val().toLowerCase();
        var sta = $('select[name="filter-status"]').val().toLowerCase();
        
        if(src != undefined){
            $('#datatable-dinasluar').DataTable().search(src).draw();
        }
        if(sta != undefined){
            $('#datatable-dinasluar').DataTable().search(sta).draw();
        }
    }

    function action(urlfunc,id_dinasluar,text){
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
                        id_dinas_diluar: id_dinasluar
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
            table_dinasluar.ajax.reload();
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
