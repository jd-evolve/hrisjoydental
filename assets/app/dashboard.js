(function($) {
    let Cal = new Calendar({
        id: "#calendar",
        theme: "basic",
        primaryColor: "#505458",
        calendarSize: "small",
        dateChanged : function (e) {
            var year = e.getFullYear();
            var month = e.getMonth() < 10 ? ('0'+e.getMonth()+1) : e.getMonth()+1;
            var date = e.getDate() < 10 ? ('0'+e.getDate()) : e.getDate();
            var fullDate = year+'-'+month+'-'+date;
            $.ajax({
                url: 'dashboard/list_kegiatan',
                method: "POST",
                dataType: "json",
                data: {
                    full_date: fullDate, 
                },
                success: function (data) {
                    var html = "";
                    var bg = "secondary" 
                    if(data.length < 1){
                        html = '<li class="bg-grey2 text-center p-2" style="margin-left: -15px;margin-right: -15px;">'+
                                    '<time class="date" datetime="9-25">Tidak ada kegiatan atau pengumuman</time>'+
                                '</li>';
                    }else{
                        for (var i=0; i<data.length; i++) {
                            let color = "secondary success warning primary danger secondary success warning primary danger";
                            const bg = color.split(" ");
                            html += '<li class="feed-item feed-item-'+bg[i.toString().substr(-1)]+'">'+
                                        '<time class="date" datetime="9-25">'+data[i].Tanggal+'</time>'+
                                        '<span class="text text-info">"'+data[i].Kegiatan+'"</span>'+
                                    '</li>';
                        }
                    }
                    $('#list_kegiatan').html(html);
                },
            });
        }
    });

})(jQuery);