$(function (){
    $(".prodcat").click(function () {
        var id = $(this).attr("value");
        $.ajax({
            type : "POST",
            url: "../includes/functions/functions.php",
            data: { id: id},
            success: function (data) {
                if(data){  
                console.log("success");
                }else{
                    console.log("fail");
                }
                $.each(data, function(key, data) {
                    console.log(data.name);
                });
                $("#prodsubcats").html(data);
                //window.location = "products_create.php";
            }
        });
        return data;
      });


    $(".confirm").click(function () {
        return confirm("Are you sure you want to delete this object?");
    });    

});