(function($) {
    Inputmask("datetime", {inputFormat: "dd-mm-yyyy", placeholder: "_", leapday: "-02-29", alias: "tt.mm.jjjj" }).mask("#tgl_lahir");

    $("#profile_image").change(function() {
        var file = $("#profile_image")[0].files[0].name;
        if (file.length > 20) {
            file = file.substr(0, 10) + "..." + file.substr(-10);
        }
        $(this).prev("label").text(file);
    });

    $("body").on("click", "#ganti_foto", function(e) {
        e.preventDefault();
        var validasi = $('input[name="profile_image"]').val();
        if (validasi != "") {
            var formData = new FormData(document.querySelector("#form_photo"));
            $.ajax({
                url: "profil/ganti_foto",
                method: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(json) {
                    let result = json.result;
                    let message = json.message;
                    if (result == "success") {
                        swal("Berhasil", message, {
                            icon: "success",
                            buttons: {
                                confirm: {
                                    className: "btn btn-success",
                                },
                            },
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        swal("Gagal", message, {
                            icon: "error",
                            buttons: {
                                confirm: {
                                    className: "btn btn-danger",
                                },
                            },
                        });
                    }
                },
            });
        } else {
            swal("Faild", "Photo must be input!", {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                    },
                },
            });
        }
    });

    $("body").on("click", "input#edit_profile", function() {
        $.validator.setDefaults({
            submitHandler: function() {
                var formData = new FormData(document.querySelector("#ubah_profil"));
                $.ajax({
                    url: "profil/update_profile",
                    method: "POST",
                    dataType: "json",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message);
                    },
                });
            },
        });
        $("form#ubah_profil").validate();
    });

    $('body').on('click', '#simpan_password', function(e) {
        e.preventDefault();
        let new_pass = $('input[name="new_password1"]').val();
        let repeat_pass = $('input[name="new_password2"]').val();
        if(new_pass && repeat_pass){
            if(new_pass == repeat_pass){
                $.ajax({
                    url: "profil/ganti_password",
                    method: "POST",
                    dataType: "json",
                    data: {
                        pass1: new_pass,
                        pass2: repeat_pass,
                    },
                    success: function(json) {
                        let result = json.result;
                        let message = json.message;
                        notif(result, message);
                    },
                });
            }else{
                notif('gagal', 'Password tidak sama harap ulangi kembali');
            }
        }else if(new_pass && !repeat_pass){
            notif('gagal', 'Password harus di isi dan password harus sama');
        }else if(!new_pass && repeat_pass){
            notif('gagal', 'Password harus di isi dan password harus sama');
        }
    });

    function notif(result, message) {
        if (result == "success") {
            swal("Berhasil", message, {
                icon: "success",
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            swal("Gagal", message, {
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
