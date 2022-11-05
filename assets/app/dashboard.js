(function($) {
    let Cal = new Calendar({
        id: "#calendar",
        theme: "basic",
        primaryColor: "#505458",
        calendarSize: "small",
        eventsData: [
            {
              start: "2022-11-04",
              end: "2022-11-04"
            },
            {
              start: "2022-11-10",
              end: "2022-11-10"
            }
        ],
        dateChanged : function (e) {
            var year = e.getFullYear();
            var month = e.getMonth() < 10 ? ('0'+e.getMonth()) : e.getMonth();
            var date = e.getDate() < 10 ? ('0'+e.getDate()) : e.getDate();
            var fullDate = year+'-'+month+'-'+date;
            // console.log(fullDate)
        }
    });
})(jQuery);