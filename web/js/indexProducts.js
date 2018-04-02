/* Demo purposes only */
$(".hover").mouseleave(
    function () {
        $(this).removeClass("hover");
    }
);

$.ajaxSetup({ cache: false });
$(document).ready(function () {
    $(".stripe-button-el").removeClass("stripe-button-el").addClass("btn continue").css("background-color","#82ca9c").css("color","white").css("float","right").children("span").css("display","").css("min-height","");
    $('.cart1').on("click",function (e) {
        e.preventDefault();
        var path = $(this).attr("data-path");
        $.ajax({
            type : 'get',
            url  :  path,
            success: function (data) {

                $(".alert").show().fadeIn().fadeOut(5000);

            }
        });


    });
    $('.remove').on("click",function (e) {
        e.preventDefault();
        $.ajaxSetup({ cache: false });
        var path =$(this).attr("data-path");
        $.ajax({
           type : 'get',
            url : path,
            success: function (data2) {
            var final =$(".totalRow.final");
            var totall=parseInt(data2)+4;
               final.html('<span class="label2">Total</span><span class="value">$'+totall+'</span>');

               if(data2 == 0)
               {
                   $(".subtotal.cf2").html('<ul class="cartWrap2"> <li class="totalRow"><span class="label2">Subtotal</span><span class="value">$</span></li><li class="totalRow"><span class="label2">Tax</span><span class="value">$0.00</span></li><li class="totalRow final"><span class="label2">Total</span><span class="value">$0</span></li><li class="totalRow"><a href="" class="btn continue" disabled="disabled">Checkout</a></li></ul>');

               }

           }

        });
    });

});
