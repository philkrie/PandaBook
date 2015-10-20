var lastOpen = null;

$(document).ready(function () {
	"use strict";
    
    $("#address-books").hide();
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
                            listBooks();
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

function listBooks(){
    "use strict";
    $.ajax({
        url: 'php/listbooks.php',
        type: 'get',
        dataType: 'json',
        success: function (json) {
            window.alert("listbooks activated");
            $.each(json, function(i, item) {
                if(typeof item == 'object') {
                    if(item.success){
                        for( var i = 0; i < item.bookList.length; i++){
                            $('#booklist').append($('<option/>', { 
                                text :  item.bookList[i].BookName
                            }))
                        }
                        if(item.lastBook != null){
                            window.open("book.html?bookName=" + item.lastBook);
                        }
                    }
                }
            })
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });   
}

function addBook(){
    "use strict";
    $.ajax({
        url: 'php/addbook.php',
        type: 'post',
        data: {'bookName': $("input[name=addbook]").val()},
        dataType: 'json',
        success: function (json) {
            window.alert("addbook activated");
            $.each(json, function(i, item) {
                if(typeof item == 'object') {
                    if(item.success){
                        window.alert("Addbook successfully added");
                        listBooks();
                    } else {
                        window.alert("Addbook not added");
                    }
                }
            })
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });   
}

function chooseBook(){
    "use strict";
    var bookName = $("#booklist>option:selected").html();
    window.open("book.html?bookName=" + bookName);
}