/* Demo purposes only */
$(".hover").mouseleave(
    function () {
        $(this).removeClass("hover");
    }
);

$.ajaxSetup({ cache: false });
$(document).ready(function () {


    if($(".msg").text() == "Your order has been successfully placed!")
    {
        swal("Thank you!", "Your order has been placed successfully!", "success");

    }
    else if($(".msg").text() == "Your order has been declined!")
    {
        swal("Desclined!", "Your order has been declined!", "error");

    }

    $(".stripe-button-el").removeClass("stripe-button-el").addClass("btn continue").css("background-color","#82ca9c").css("color","white").css("float","right").children("span").css("display","").css("min-height","");
    $('.cart1').on("click",function (e) {

        e.preventDefault();
        var path = $(this).attr("data-path");
        $.ajax({
            type : 'get',
            url  :  path,
            success: function (data) {

                swal("Good job!", "Item has been added to your cart!", "success");

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
                   $(".subtotal.cf2").html('<ul class="cartWrap2"> <li class="totalRow"><span class="label2">Subtotal</span><span class="value">$</span></li><li class="totalRow"><span class="label2">Tax</span><span class="value">$0.00</span></li><li class="totalRow final"><span class="label2">Total</span><span class="value">$0</span></li><form style="float: right;" action="/mysoulmate/web//app_dev.php/checkout/stripe" method="POST"><script src="https://checkout.stripe.com/checkout.js" class="stripe-button active" data-key="pk_test_p5iZQvuYEQg218WFtClGMw43" data-amount="0" data-name="med abdh" data-description="php test" data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto" data-zip-code="true"></script><button disabled="disabled" type="submit" class="btn continue" style="visibility: visible; background-color: rgb(130, 202, 156); color: white; float: right;"><span style="">Pay with Card</span></button></form></ul>');

               }

           }

        });
    });

});
$(document).ready(function () {
    $.ajax({
        type:"get",
        url:"http://localhost/mysoulmate/web/app_dev.php/checkLogged",
        success:function (data) {
            if(data == "false")
            {
            $(".btn.continue").prop("disabled",true);
            }
            else
            {
                return true;
            }
        }

    });
    $("#promobtn").on("click", function (e) {
        e.preventDefault();
        var promocode = $(".inputpromo").val();
        if(promocode == null || promocode == "")
        {
            swal("Sorry!", "Please enter you promo code voucher first!", "error");


        }
        else {
            var check = -1;
            var path = "http://localhost/mysoulmate/web//app_dev.php/cart/discount/" + promocode;
            $.ajax({
                type: "get",
                url: path,
                cache: false,
                success: function (data) {
                    if (parseInt(data)) {
                        if (check !== 1) {
                            var html = document.getElementsByTagName("html");

                            $(".cartWrap").animate({
                                opacity: 0.5 // 50%
                            }, 1000).css("z-index", "-1");
                            $(".popupmsg").css("display", "").animate({
                                opacity: 1
                            }, 3000);
                            $(".popupmsg").css("display", "").css("color", "#777").css("font-family", '"Droid Serif", serif').animate({
                                opacity: 0
                            }, 1000);
                            $(".cartWrap").animate({
                                opacity: 1 // 50%
                            }).css("z-index", "-1");

                            check = 1;
                        }
                        else {
                            var html = document.getElementsByTagName("html");

                            $(".cartWrap").animate({
                                opacity: 0.5 // 50%
                            }, 1000).css("z-index", "-1");
                            $(".popupmsg1").css("display", "").animate({
                                opacity: 1
                            }, 3000);
                            $(".cartWrap").animate({
                                opacity: 1 // 50%
                            }, 1000).css("z-index", "-1");
                            $(".popupmsg1").css("display", "").css("color", "#777").css("font-family", '"Droid Serif", serif').animate({
                                opacity: 0
                            }, 1000);

                        }

                        var final = $(".totalRow.final");
                        var totalprice = parseInt(data);
                        totalprice +=4;
                        final.html('<span class="label2">Total</span><span class="value">$' + totalprice + '</span>');
                    }
                    else {
                        swal("Error","No voucher Found","error");
                    }
                }
            });
        }
    });
});


$(document).ready(function (e) {


    $(".glyph-icon").on("click",function (e) {
        e.preventDefault();
        var email = $(".uemail").val();
        $.ajax({
            type: "get",
            url: "http://localhost/mysoulmate/web/app_dev.php/mysoulmate/likeUser/"+email,
            success: function (data) {
                swal("Success!", "Like successfully sent! You will get a notification as soon as you get a like back from him/her", "success");


            }

        });
        $.ajax({
            type: "get",
            url: "http://localhost/mysoulmate/web/app_dev.php/mysoulmate/checkMatch/"+email,
            success: function (data) {
                    if(data == "true")
                    {
                        swal("Success!", "You have a new matching", "success");
                    }
            }
        })
    });
   $.ajax({
       type: "get",
       url: "http://localhost/mysoulmate/web//app_dev.php/checkTotal",
       success: function (data) {
      if(data == 0)
      {
          $(".subtotal.cf2").html('<ul class="cartWrap2"> <li class="totalRow"><span class="label2">Subtotal</span><span class="value">$</span></li><li class="totalRow"><span class="label2">Tax</span><span class="value">$0.00</span></li><li class="totalRow final"><span class="label2">Total</span><span class="value">$0</span></li><form style="float: right;" action="/mysoulmate/web//app_dev.php/checkout/stripe" method="POST"><script src="https://checkout.stripe.com/checkout.js" class="stripe-button active" data-key="pk_test_p5iZQvuYEQg218WFtClGMw43" data-amount="0" data-name="med abdh" data-description="php test" data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto" data-zip-code="true"></script><button disabled="disabled" type="submit" class="btn continue" style="visibility: visible; background-color: rgb(130, 202, 156); color: white; float: right;"><span style="">Pay with Card</span></button></form></ul>');
      }
       }
   });

});
