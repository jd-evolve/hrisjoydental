(function($) {
    $("#persetujuan").click(function() {
        $('.notif').addClass('none');
    });
    $('#setuju_sop').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#nav3').removeClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
            $('#show-nav3').addClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
    $('#nav2').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#nav3').removeClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
            $('#show-nav3').addClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
    $('#nav1').on("click", function(){
        $('#nav1').addClass('active');
        $('#nav2').removeClass('active');
        $('#nav3').removeClass('active');
        $('#show-nav1').removeClass('none');
        $('#show-nav2').addClass('none');
        $('#show-nav3').addClass('none');
    });
    $('#nav3').on("click", function(){
        $('#nav1').removeClass('active');
        $('#nav2').removeClass('active');
        $('#nav3').addClass('active');
        $('#show-nav1').addClass('none');
        $('#show-nav2').addClass('none');
        $('#show-nav3').removeClass('none');
    });

    Inputmask("datetime", {
        inputFormat: "dd-mm-yyyy HH:MM",
        placeholder: "_",
        leapday: "-02-29",
        alias: "tt.mm.jjjj"
    }).mask('.tgl-wkt');

    $('#setuju_sop').on("click", function(){
        if($('#persetujuan').is(":checked")){
            $('#nav1').removeClass('active');
            $('#nav2').addClass('active');
            $('#nav3').removeClass('active');
            $('#show-nav1').addClass('none');
            $('#show-nav2').removeClass('none');
            $('#show-nav3').addClass('none');
        } else {
            $('.notif').removeClass('none');
        }
    });
    
    $('#ajukan_form').on('click',function (e) {
        e.preventDefault();
        let validasi = document.getElementById("form-ijincuti").reportValidity();
        if(validasi){
            $("#ajukan_form").prop( "disabled",true);
            var formData = new FormData(document.querySelector("#form-ijincuti"));
            $.ajax({
                url: "layanan/add_ijincuti",
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
        }else{
            $("#ajukan_form").prop( "disabled",false);
        }
    });
})(jQuery);