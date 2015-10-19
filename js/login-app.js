$(document).ready(function () {
	"use strict";
    
    //$("#address-books").hide();
    $("#failure").hide();

});


function credentials() {
    "use strict";
    $.ajax({
        url: 'php/credentials.php',
        type: 'post',
        data: {'user': $("input[name=username]").val(),
               'pass': $("input[name=password]").val(), 
              },
        dataType: 'json',
        success: function (json) {
            window.alert("credentials activated");
            $.each(json, function(i, item) {
                if(typeof item == 'object') {
                    if(item.success){
                        if(item.loginOk){
                            $("#address-books").show();
                            $("#login").hide();
                            $("#failure").hide();
                            //listBooks();
                        } else {
                            $("#failure").show();
                        }
                    } else {
                        $("#failure").shoq();
                    }
                }
            })
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
            $("#failure").show();
        }
    });
    
    
}
