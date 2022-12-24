(function ($) {
    $('#nav1').on("click", function(){
        $('#nav1').addClass('active');
        $('#nav2').removeClass('active');
        $('#show-nav1').removeClass('none');
        $('#show-nav2').addClass('none');
        $('.filter-1').addClass('none');
        $('.filter-2').removeClass('none');
        table_acclembur('1','x');
    });
    $('#nav2').on("click", function(){
        $('#nav1').removeClass('active');
        $('#nav2').addClass('active');
        $('#show-nav1').addClass('none');
        $('#show-nav2').removeClass('none');
        $('.filter-1').removeClass('none');
        $('.filter-2').removeClass('none');
        table_acclembur('z',$('#filter-periode').val());
    });

    $('#filter-periode').change(function() {
        table_acclembur('z',$(this).val());
    });

    table_acclembur('1','x');
    function table_acclembur(status,periode){
        var table_acclembur = $("#datatable-acclembur").DataTable({
            ajax: {
                url: "absensi/read_acclembur",
                type: "POST",
                data: {
                    status: status,
                    periode: periode,
                },
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
                    "targets": '_all',
                    "createdCell": function(td, cellData, rowData, row, col) {
                        let style = 'padding-bottom: 8px !important; padding-top: 8px !important;'
                        $(td).attr('style', style);
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                emptyTable: "Belum ada daftar pengajuan!",
                infoEmpty: "Tidak ada data untuk ditampilkan!",
                info: "_START_ to _END_ of _TOTAL_ entries",
                infoFiltered: ""
            },
            dom: 'Brt'+"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [ ],
            columns: [
                { data: "No" },
                { data: "Periode" },
                { data: "Karyawan" },
                { data: "Bagian" },
                { data: "Total" },
                { data: "Status" , render : function ( data, type, row, meta ) {
                    var stts = "";
                    if(data == 1){
                        stts = '<span class="btn btn-warning fw-bold btn-xs py-0 px-1">Proses</span>';
                    }else if(data == 2){
                        stts = '<span class="btn btn-success fw-bold btn-xs py-0 px-1">Selesai</span>';
                    }
                    return type === 'display' ? stts : data;
                }},
                { data: "Aksi" , render : function ( data, type, row, meta ) {
                    var dt = 'data-id="'+data+'" data-ida="'+row['id_atasan']+'" data-idk="'+row['id_karyawan']+'"';
                    var kr = 'data-nama="'+row['Karyawan']+'" data-jabatan="'+row['Jabatan']+'" data-bagian="'+row['Bagian']+'" data-periode="'+row['Periode']+'"';
                    return type === 'display'  ?
                    '<button type="button" data-st="'+status+'" '+dt+' '+kr+' id="show-detail" class="btn btn-icon btn-round btn-secondary btn-sm" title="Lihat form lembur dan lakukan acc atau tolak.">'+
                        '<i class="fa fa-eye"></i>'+
                    '</button>':
                    data;
                }},
            ],
        });
        
        saveKey();
        $('#filter-search').keyup(function(){
            saveKey();
            var src = $('input[name="filter-search"]').val().toLowerCase();
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (~data[2].toLowerCase().indexOf(src))
                    return true;
                if (~data[3].toLowerCase().indexOf(src))
                    return true;
                return false;
            })
            table_acclembur.draw(); 
            $.fn.dataTable.ext.search.pop();
        });
    
        function saveKey(){
            var src = $('input[name="filter-search"]').val().toLowerCase();
            if(src != undefined){
                $('#datatable-acclembur').DataTable().search(src).draw();
            }
        }
    
        $('body').on('click','#show-detail', function(){
            $("#modal-showlembur").modal();
            let id_periode = $(this).data('id');
            let id_atasan = $(this).data('ida');
            let id_karyawan = $(this).data('idk');
            $('#show-nama').html($(this).data('nama'));
            $('#show-jabatan').html($(this).data('jabatan'));
            $('#show-bagian').html($(this).data('bagian'));
            $('#show-periode').html($(this).data('periode'));
            $('input[name="id_periode"]').val(id_periode);
            var show_cek = $(this).data('st');

            $.ajax({
                url: "absensi/karyawan_lembur",
                method: "POST",
                dataType: "json",
                data: {
                    id_periode: id_periode,
                    id_atasan: id_atasan,
                    id_karyawan: id_karyawan,
                },
                success: function (data) {
                    var html = "";
                    $("#tabel-listlembur tbody").html(html);
                    $('input[name="count_lembur"]').val(data.length);
                    if(show_cek == 1){
                        $('#simpan_lembur').removeClass('none');
                        for (var i=0; i<data.length; i++) {
                            html += 
                            '<tr>'+
                                '<td class="text-center"><input type="hidden" name="id_lembur'+i+'" value="'+data[i].id_lembur+'">'+(i+1)+'</td>'+
                                '<td>'+data[i].tanggal+'</td>'+
                                '<td><input type="text" class="form-control form-rm waktu mulai" data-idx="'+i+'" name="mulai'+i+'" id="mulai'+i+'" value="'+data[i].jm_mulai+'" style="min-width: 50px;" required></td>'+
                                '<td><input type="text" class="form-control form-rm waktu selesai" data-idx="'+i+'" name="selesai'+i+'" id="selesai'+i+'" value="'+data[i].jm_selesai+'" style="min-width: 50px;" required></td>'+
                                '<td class="font-weight-bold text-center" id="jumlah'+i+'"><input type="hidden" name="jumlah'+i+'" value="'+data[i].jumlah+'">'+data[i].jumlah+'</td>'+
                                '<td>'+
                                    '<select class="form-control form-rm" name="kategori'+i+'" id="kategori'+i+'" style="height: 28.8px !important;" required>'+
                                        '<option value="1" '+(data[i].kategori == 1 ? 'selected' : '')+'>diluar jam kerja</option>'+
                                        '<option value="2" '+(data[i].kategori == 2 ? 'selected' : '')+'>range jam kerja</option>'+
                                    '</select>'+
                                '</td>'+
                                '<td>'+
                                    '<textarea class="form-control" name="keterangan'+i+'" id="keterangan'+i+'" style="height: 28.8px !important; min-height: 28.8px !important; padding: 0.25rem 0.5rem !important;" required>'
                                    +data[i].keterangan+
                                    '</textarea>'+
                                '</td>'+
                                '<td class="nowraping">'+
                                    '<label class="checkbox-inline mr-3"><input type="radio" data-idx="'+i+'" class="status" name="status'+i+'" id="status'+i+'" value="2" required> Setujui </label>'+
                                    '<label class="checkbox-inline mr-3"><input type="radio" data-idx="'+i+'" class="status" name="status'+i+'" id="status'+i+'" value="3" required> Tolak </label>'+
                                    '<textarea class="form-control none" name="alasan'+i+'" id="alasan'+i+'" placeholder="alasan ditolak" style="height: 28.8px !important; min-height: 28.8px !important; padding: 0.25rem 0.5rem !important;"></textarea>'+
                                '</td>'+
                            '</tr>';
                        }
                        $("#tabel-listlembur tbody").html(html);
                        Inputmask("datetime",{
                            inputFormat: "HH:MM",
                            placeholder: "_",
                            leapday: "-02-29",
                            alias: "tt.mm.jjjj",
                            max: "24",
                        }).mask('.waktu');
                        $('.mulai').keyup(function(){
                            range_jam($(this).data('idx'));
                        });
                        $('.selesai').keyup(function(){
                            range_jam($(this).data('idx'));
                        });
                        function range_jam(idx){
                            var jam_mulai = $('#mulai'+idx).val();
                            var jam_selesai = $('#selesai'+idx).val();
                            if(jam_mulai.search("_") == -1 && jam_mulai != '' && jam_selesai.search("_") == -1 && jam_selesai != ''){
                                var diff = Math.abs(new Date('1/1/1 '+jam_mulai) - new Date('1/1/1 '+jam_selesai));
                                var minutes = Math.floor((diff/1000)/60);
                                $('#jumlah'+idx).html(minutes);
                                $('input[name="jumlah'+idx+'"]').val(minutes);
                            }else{
                                $('#jumlah'+idx).html('0');
                                $('input[name="jumlah'+idx+'"]').val('0');
                            }
                        }
                        $(".status").change(function(){
                            var idx = $(this).data('idx');
                            var status = $('#status'+idx+':checked').val();
                            if(status == '3'){
                                $('#alasan'+idx).removeClass('none');
                                $('#alasan'+idx).attr("required", true);
                                $('#jumlah'+idx).addClass('text-line-through');
                            }else{
                                $('#alasan'+idx).addClass('none');
                                $('#alasan'+idx).attr("required", false);
                                $('#jumlah'+idx).removeClass('text-line-through');
                            }
                        });
                    }else{
                        $('#simpan_lembur').addClass('none');
                        let total = 0;
                        for (var i=0; i<data.length; i++) {
                            html += 
                            '<tr>'+
                                '<td class="text-center">'+(i+1)+'</td>'+
                                '<td>'+data[i].tanggal+'</td>'+
                                '<td>'+data[i].jm_mulai+'</td>'+
                                '<td>'+data[i].jm_selesai+'</td>'+
                                '<td class="'+(data[i].status == 3 ? 'text-line-through' : '')+'">'+data[i].jumlah+'</td>'+
                                '<td class="nowraping">'+(data[i].kategori == 1 ? 'diluar jam kerja' : 'range jam kerja')+'</td>'+
                                '<td>'+data[i].keterangan+'</td>'+
                                '<td>'+
                                    (data[i].status == 1 ? 'diajukan' : 
                                        (data[i].status == 2 ? 
                                            ('<span class="btn btn-success fw-bold btn-xs py-0 px-1">disetujui</span>') : 
                                            ('<span class="btn btn-danger fw-bold btn-xs py-0 px-1">ditolak</span> <br> ('+data[i].alasan+')')
                                        )
                                    )+
                                '</td>'+
                            '</tr>';
                            total += data[i].status == 2 ? parseInt(data[i].jumlah) : 0;
                        }
                        html += '<tr>'+
                                    '<td colspan="4" class="text-right"><b>Total Keseluruhan Lembur</b> (menit)</td>'+
                                    '<td><b>'+total+'</b></td>'+
                                '</tr>';
                        $("#tabel-listlembur tbody").html(html);
                    }
                },
            });
        });

        $('body').on('click','#simpan_lembur', function(e){
            e.preventDefault();
            var count_lembur = $('input[name="count_lembur"]').val();
            var cek = true;
            for (var i=0; i<parseInt(count_lembur); i++) {
                var mulai = $('#mulai'+i).val();
                var selesai = $('#selesai'+i).val();
                if(mulai.search("_") == -1 && selesai.search("_") == -1){
                }else{
                    cek = false;
                }
            }

            if(cek){
                let validasi = document.getElementById("form-showlembur").reportValidity();
                if (validasi) {
                    var formData = new FormData(document.querySelector("#form-showlembur"));
                    formData.append("count_lembur", count_lembur);
                    formData.append("count_lembur", count_lembur);
                    $.ajax({
                        url: "absensi/acc_lembur",
                        method: "POST",
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        success: function (json) {
                            let result = json.result;
                            let message = json.message;
                            notif(result, message);
                            $("#modal-showlembur").modal('hide');
                        },
                    });
                }
            }else{
                notif('error', 'Format jam tidak sesuai!');
            }
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
                table_acclembur.ajax.reload();
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
