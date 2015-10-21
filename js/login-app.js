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
               'pass': $("input[name=password]").val() 
              },
        dataType: 'json',
        success: function (json) {
            if(json.success){
                if(json.loginOk){
                    $("#address-books").show();
                    $("#login").hide();
                    $("#failure").hide();
                    listBooks();
                } else {
                    $("#failure").show();
                }
            } else {
                $("#failure").show();
            }
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
            $("#failure").show();
        }
    });   
}

function listBooks(){
    $("#booklist option").remove();
    "use strict";
    $.ajax({
        url: 'php/listbooks.php',
        type: 'get',
        dataType: 'json',
        success: function (json) {
            $.each(json, function(i, item){ {
                    $('#booklist').append($('<option/>', { 
                                text :  item.bookName
                            }))
                        /*for( var i = 0; i < item.bookList.length; i++){
                            $('#booklist').append($('<option/>', { 
                                text :  item.bookList[i].BookName
                            }))
                        }
                        if(item.lastBook != null){
                            window.open("book.html?bookName=" + item.lastBook);
                        }*/
                    
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
                    if(json.success){
                        window.alert("Addbook successfully added");
                        listBooks();
                        $("input[name=addbook]").val("");
                    } else {
                        window.alert("Addbook not added");
                        window.alert(json.debug);
                    }
                
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });   
}

function deleteBook(){
    if($('#booklist')[0].selectedIndex == -1){
        window.alert("Please select an address book that you would like to delete");
    } else {
        $.ajax({
        url: 'php/deletebook.php',
        type: 'post',
        dataType: 'json',
        data: {
            'bookName' : $("#booklist>option:selected").html(),
        },
        success: function(json) {
            if(!json.boolean){
                window.alert("Entry was not deleted, an error occured");
            } else {
                window.alert("You have successfully deleted this entry");
                listBooks();
            };
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
    }
}

function chooseBook(){
    "use strict";
    var bookName = $("#booklist>option:selected").html();
    window.open("book.html?bookName=" + bookName);
}