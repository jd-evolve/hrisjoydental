(function ($) {
    $("#filter-karyawan").select2({width: '100%'});
    $(".select2-selection--single").css({
        "height":"calc(2.25rem + 2px)", 
        "padding":"0.3rem 0.4rem", 
        "line-height":"1.5", 
        "max-width":"230px",
        "border": "transparent",
        "background-color":"transparent"
    });
    
    $('select[name="filter-karyawan"]').change(function() {
        rekapgaji();
    });

    $('select[name="filter-periode"]').change(function() {
        rekapgaji();
    });

    rekapgaji();
    function rekapgaji(){
        var periode = $('select[name="filter-periode"]').val();
        var karyawan = $('select[name="filter-karyawan"]').val();
        var id_karyawan = karyawan == "" ? null : karyawan;

        var table_rekapgaji = $("#datatable-rekapgaji").DataTable({
            ajax: {
                url: "rekapdata/read_rekapgaji",
                type: "POST",
                data: {
                    periode: periode,
                    id_karyawan: id_karyawan,
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
                emptyTable: "Belum ada daftar rekap gaji!",
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
                { data: "Total",
                    render: function(data, type, row, meta) {
                        return FormatCurrency(data);
                    }
                },
                { data: "Aksi" , render : function ( data, type, row, meta ) {
                    var list_data = 
                        'data-id="'+data+'" '+
                        'data-periode="'+row['Periode']+'" '+
                        'data-nik="'+row['NIK']+'" '+
                        'data-nama="'+row['Karyawan']+'" '+
                        'data-email="'+row['Email']+'" '+
                        'data-jabatan="'+row['Jabatan']+'" '+
                        'data-grade="'+row['Grade']+'" '+
                        'data-cabang="'+row['Cabang']+'" '+

                        'data-bpjs_persen_kesehatan="'+row['bpjs_persen_kesehatan']+'" '+
                        'data-bpjs_persen_tk="'+row['bpjs_persen_tk']+'" '+

                        'data-gaji_tetap="'+row['gaji_tetap']+'" '+
                        'data-uang_makan="'+row['uang_makan']+'" '+
                        'data-uang_transport="'+row['uang_transport']+'" '+
                        'data-uang_lembur="'+row['uang_lembur']+'" '+
                        'data-insentif="'+row['insentif']+'" '+
                        'data-tunjangan_jabatan="'+row['tunjangan_jabatan']+'" '+
                        'data-tunjangan_str="'+row['tunjangan_str']+'" '+
                        'data-tunjangan_pph21="'+row['tunjangan_pph21']+'" '+
                        'data-dinas_luar="'+row['dinas_luar']+'" '+
                        'data-masuk_hari_libur="'+row['masuk_hari_libur']+'" '+
                        'data-tambahan_shift="'+row['tambahan_shift']+'" '+
                        'data-bonus_thr="'+row['bonus_thr']+'" '+
                        'data-bpjs_corporate="'+row['bpjs_corporate']+'" '+
                        'data-lainnya_terima="'+row['lainnya_terima']+'" '+
                        
                        'data-keterlambatan="'+row['keterlambatan']+'" '+
                        'data-pulangawal="'+row['pulangawal']+'" '+
                        'data-bpjs_kesehatan="'+row['bpjs_kesehatan']+'" '+
                        'data-bpjs_tk="'+row['bpjs_tk']+'" '+
                        'data-cicilan="'+row['cicilan']+'" '+
                        'data-biaya_transfer="'+row['biaya_transfer']+'" '+
                        'data-pajak_pph21="'+row['pajak_pph21']+'" '+
                        'data-bpjs_corporate_ded="'+row['bpjs_corporate_ded']+'" '+
                        'data-lainnya_potong="'+row['lainnya_potong']+'" '+

                        'data-total_penerimaan="'+row['total_penerimaan']+'" '+
                        'data-total_potongan="'+row['total_potongan']+'" '+
                        'data-total_gaji="'+row['Total']+'" '+

                        'data-no_rek="'+row['no_rek']+'" '+
                        'data-nama_bank="'+row['nama_bank']+'" '+
                        'data-nama_rek="'+row['nama_rek']+'" '+
                        '';
                    return type === 'display'  ?
                    '<button type="button" '+list_data+' id="show-form" class="btn btn-icon btn-round btn-secondary btn-sm" title="Lihat detail gaji.">'+
                        '<i class="fa fa-eye"></i>'+
                    '</button>':
                    data;
                }},
            ],
        });
        
        $('body').on('click','#show-form', function(){
            $("#modal-showform").modal();
            let id_karyawan = $(this).data('id');
            $("#list-periode").html($(this).data('periode'));
            $("#list-nik").html($(this).data('nik'));
            $("#list-nama").html($(this).data('nama'));
            $("#list-email").html($(this).data('email'));
            $("#list-jabatan").html($(this).data('jabatan'));
            $("#list-grade").html($(this).data('grade'));
            $("#list-cabang").html($(this).data('cabang'));

            $("#bpjs_persen_kesehatan").html($(this).data('bpjs_persen_kesehatan'));
            $("#bpjs_persen_tk").html($(this).data('bpjs_persen_tk'));

            $("#pen-gaji_tetap").html(FormatCurrency($(this).data('gaji_tetap')));
            $("#pen-uang_makan").html(FormatCurrency($(this).data('uang_makan')));
            $("#pen-uang_transport").html(FormatCurrency($(this).data('uang_transport')));
            $("#pen-uang_lembur").html(FormatCurrency($(this).data('uang_lembur')));
            $("#pen-insentif").html(FormatCurrency($(this).data('insentif')));
            $("#pen-tunjangan_jabatan").html(FormatCurrency($(this).data('tunjangan_jabatan')));
            $("#pen-tunjangan_str").html(FormatCurrency($(this).data('tunjangan_str')));
            $("#pen-tunjangan_pph21").html(FormatCurrency($(this).data('tunjangan_pph21')));
            $("#pen-dinas_luar").html(FormatCurrency($(this).data('dinas_luar')));
            $("#pen-masuk_hari_libur").html(FormatCurrency($(this).data('masuk_hari_libur')));
            $("#pen-tambahan_shift").html(FormatCurrency($(this).data('tambahan_shift')));
            $("#pen-bonus_thr").html(FormatCurrency($(this).data('bonus_thr')));
            $("#pen-bpjs_corporate").html(FormatCurrency($(this).data('bpjs_corporate')));
            $("#pen-lainnya_terima").html(FormatCurrency($(this).data('lainnya_terima')));

            $("#pot-bpjs_corporate_ded").html(FormatCurrency($(this).data('bpjs_corporate_ded')));
            $("#pot-keterlambatan").html(FormatCurrency($(this).data('keterlambatan')));
            $("#pot-pulangawal").html(FormatCurrency($(this).data('pulangawal')));
            $("#pot-bpjs_kesehatan").html(FormatCurrency($(this).data('bpjs_kesehatan')));
            $("#pot-bpjs_tk").html(FormatCurrency($(this).data('bpjs_tk')));
            $("#pot-cicilan").html(FormatCurrency($(this).data('cicilan')));
            $("#pot-biaya_transfer").html(FormatCurrency($(this).data('biaya_transfer')));
            $("#pot-pajak_pph21").html(FormatCurrency($(this).data('pajak_pph21')));
            $("#pot-lainnya_potong").html(FormatCurrency($(this).data('lainnya_potong')));

            $("#total-penerimaan").html(FormatCurrency($(this).data('total_penerimaan')));
            $("#total-potongan").html(FormatCurrency($(this).data('total_potongan')));
            $("#total-gaji").html(FormatCurrency($(this).data('total_gaji'),true));

            $("#nama_bank").html($(this).data('nama_bank'));
            $("#no_rek").html($(this).data('no_rek'));
            $("#nama_rek").html($(this).data('nama_rek'));
        });
    
        function FormatCurrency(angka,rp=false){
            var rev = parseInt(angka, 10).toString().split('').reverse().join('');
            var rev2 = '';
            for (var i = 0; i < rev.length; i++) {
                rev2 += rev[i];
                if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                    rev2 += '.';
                }
            }
            return (rp?'Rp ':'') + rev2.split('').reverse().join('') + '';
        }
    }
})(jQuery);
