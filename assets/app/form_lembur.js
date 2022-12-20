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
        
        $('#jam_mulai').keyup(function(){
            range_jam();
        });
        $('#jam_selesai').keyup(function(){
            range_jam();
        });
        function range_jam(){
            var jam_mulai = $('#jam_mulai').val();
            var jam_selesai = $('#jam_selesai').val();
            if(jam_mulai.search("_") == -1 && jam_mulai != '' && jam_selesai.search("_") == -1 && jam_selesai != ''){
                var diff = Math.abs(new Date('1/1/1 '+jam_mulai) - new Date('1/1/1 '+jam_selesai));
                var minutes = Math.floor((diff/1000)/60);
                $('#jumlah').val(minutes);
            }
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