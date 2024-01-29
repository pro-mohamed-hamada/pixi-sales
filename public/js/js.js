$(document).ready(function(){
    $(".sideBar-button").click(function(){
        $(".sideBar").toggle(300);
    });
    // $("body").niceScroll();
    $(".sideBar").niceScroll();

    $(".clientsTable tr").on("dblclick", function(e){
        e.preventDefault();
        $(this).next(".displayView").css("display", "block");
        // $(".displayView").css("display", "block");
    });
    $(".displayView").on("click", ".close", function(){
        $(".displayView").css("display","none");
    });
    $('.alert_message').delay(2000).fadeOut().hide(0);
    // $("body").on("click", "a[name='delete']",function(e){
    //     e.preventDefault();
    //     var _token = $("#_token").val();
    //     var url = $(this).attr("href");
    //     var status = confirm("حذفك لهذا الحقل سيؤدى الى حذف جميع البيانات المتعلقه به");
    //     if(status==true){
    //         $.ajax({
    //             url:url,
    //             method:"post",
    //             data:{"_token":_token},
    //             beforeSend:function(){
    //                 $(".load_content").css("display","block");
    //             },
    //             success:function(responsetext){
    //                 $(".load_content").css("display","none");
    //                 $("#alert_message").text("تم حذف الحقل بنجاح").fadeIn().delay(2000).fadeOut();
    //                 $("#table_body").html(responsetext);
    //             },
    //             error: function(data_error, exception){
    //                 $(".load_content").css("display","none");
    //                 if(exception == "error"){
    //                     $("#alert_message").text(data_error.responseJSON.message).fadeIn().delay(2000).fadeOut();
    //                 }
    //             }
    //         });
    //     }
        
    // });
    

    $("#search").on("click",function(){
        var search_text = $("#search_text").val();
        var url = $(this).parents('form:first').attr("action");
        var _token = $("#_token").val();
        $.ajax({
            url:url,
            method:"post",
            data:{"_token":_token,"search_text":search_text},
            beforeSend:function(){
                $(".load_content").css("display","block");
            },
            success:function(responsetext){
                $(".load_content").css("display","none");
                $("#table_body").html(responsetext);
            },
            error: function(data_error, exception){
                $(".load_content").css("display","none");
                if(exception == "error"){
                    $("#alert_message").text("تحقق من البيانات المدخله وحاول مره اخرى").fadeIn().delay(2000).fadeOut();
                }
            }
        });
    });

  
    
    //get department's categories
    $("body").on("change", "select[name='depart_number']", function(){
        var department_number = $(this).val();
        var _token =$("#_token").val();
        $.ajax({
            url:"/get/department/categories",
            method:"post", 
            data:{"_token":_token, "department_number":department_number},
            success: function(responsetext){
                $("select[name='category_number']").html(responsetext);
            }
        });
    });

    //get category products
    $(document).on("change", "select[name='category_number']", function(){
        var category_number = $(this).val();
        var _token =$("#_token").val();
        $.ajax({
            url:"/get/category/products",
            method:"post", 
            data:{"_token":_token, "category_number":category_number},
            success: function(responsetext){
                $("select[name='product_number']").html(responsetext);
            }
        });
    });
});



