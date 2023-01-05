(function ($) {
    $.ajax({
        url: "pengaturan/get_konfigurasi",
        method: "GET",
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (json){
            $('input[name="cuti_tahunan"]').val(json.cuti_tahunan);
            $('input[name="cuti_menikah"]').val(json.cuti_menikah);
            $('input[name="cuti_melahirkan"]').val(json.cuti_melahirkan);
            $('input[name="ijin_pribadi"]').val(json.ijin_pribadi);
            $('input[name="ijin_duka"]').val(json.ijin_duka);
            $('input[name="ijin_sakit"]').val(json.ijin_sakit);
            $('input[name="smtp_host"]').val(json.smtp_host);
            $('input[name="smtp_port"]').val(json.smtp_port);
            $('input[name="smtp_user"]').val(json.smtp_user);
            $('input[name="smtp_pass"]').val(json.smtp_pass);
            $('input[name="initial_name"]').val(json.initial_name);
            $('input[name="keterlambatan"]').val(json.keterlambatan);
            $('input[name="pulang_awal"]').val(json.pulang_awal);
            $('input[name="bpjs_dtnik_kesehatan"]').val(json.bpjs_dtnik_kesehatan);
            $('input[name="bpjs_dtwan_kesehatan"]').val(json.bpjs_dtwan_kesehatan);
            $('input[name="bpjs_dtnik_tk"]').val(json.bpjs_dtnik_tk);
            $('input[name="bpjs_dtwan_tk"]').val(json.bpjs_dtwan_tk);
        },
    });

    $("#simpan_konfigurasi").on("click", function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-konfigurasi").reportValidity();
        if (validasi) {
            var formData = new FormData(document.querySelector("#form-konfigurasi"));
            $.ajax({
                url: "pengaturan/edit_konfigurasi",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                    let result = json.result;
                    let message = json.message;
                    notif(result, message);
                },
            });
        }
    });
    
    $("#logout_all_account").on("click", function (e) {
        e.preventDefault();
        swal({
            title: "Apakah anda yakin?",
            text: "Semua akun yang login akan di logout secara paksa!",
            type: "warning",
            buttons: {
                confirm: {
                    text: "Logout All",
                    className: "btn btn-success",
                },
                cancel: {
                    visible: true,
                    text: "Cancel",
                    className: "btn btn-danger",
                },
            },
        }).then((Delete) => {
            if (Delete) {
                $.ajax({
                    url: "pengaturan/logout_all",
                    method: "GET",
                    dataType: "json",
                    success: function (json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message, 1);
                    },
                });
            } else {
                swal.close();
            }
        });
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