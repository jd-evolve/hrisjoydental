(function($) {
    $("#persetujuan").click(function() {
        $('.notif').addClass('none');
    });
    $('#setuju_sop').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
    $('#nav1').on("click", function(){
        $('#nav1').addClass('active');
        $('#nav2').removeClass('active');
        $('#show-nav1').removeClass('none');
        $('#show-nav2').addClass('none');
    });
    $('#nav2').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
    Inputmask("datetime", {
        inputFormat: "HH:MM",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj",
        max: "24",
    }).mask('.waktu');

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl');

    $("#tambah_lembur").on("click", function () {
        $("#modal-lembur").modal();
        document.getElementById("text-lembur").innerHTML = "Tambah Lembur";
		// $('input[name="nama"]').val('');
		// $('input[name="keterangan"]').val('');
		// $('input[name="masuk"]').val('');
		// $('input[name="pulang"]').val('');
		// $('input[name="dihitung"]').val('');
		// $('input[name="sb_jm"]').val('');
		// $('input[name="st_jm"]').val('');
		// $('input[name="sb_jp"]').val('');
		// $('input[name="st_jp"]').val('');
        // $('input[name="edit_lembur"]').attr("type", "hidden");
        // $('input[name="add_lembur"]').attr("type", "submit");
        // change_time();
        // var count = 0;
        // $("input#add_lembur").on("click", function (e) {
        //     e.preventDefault();
        //     let validasi = document.getElementById("form-lembur").reportValidity();
        //     if(validasi){
        //         var masuk = $('input[name="masuk"]').val();
        //         var pulang = $('input[name="pulang"]').val();
        //         if(masuk.search("_") == -1 && pulang.search("_") == -1){
        //             count++;
        //             if (count == 1) {
        //                 var formData = new FormData(document.querySelector("#form-lembur"));
        //                 $.ajax({
        //                     url: "absensi/add_lembur",
        //                     method: "POST",
        //                     data: formData,
        //                     dataType: "json",
        //                     processData: false,
        //                     contentType: false,
        //                     success: function (json) {
        //                         let result = json.result;
        //                         let message = json.message;
        //                         if (result=="error") { count=0; }
        //                         notif(result, message, 1);
        //                     },
        //                 });
        //             }
        //         }else{
        //             notif('error', 'Format jam tidak sesuai!');
        //         }
        //     }
        // });
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