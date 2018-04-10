$(document).ready(function () {
    $.ajax({
        type: "get",
        url: "http://localhost/mysoulmate/web/app_dev.php/mysoulmate/checkMatch",
        cache: false,
        success: function (datac) {
            if(datac !== 0 )
            {
                if($.session.get("seen")==null)
                {
                    $.session.set("seen","true");
                    var msg = "you have "+datac.toString()+" new matching";
                    swal("You have New matchings!", msg, "success");
                }
            }
        }
    });
});