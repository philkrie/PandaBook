/*jslint browser: true, devel:true*/
/*global $, jQuery, alert*/

var lastOpen = null;

$(document).ready(function () {
	"use strict";
    
    $("#address-books").hide();
    $("#failure").hide();

});

//Open last opened book
function openLast() {
    "use strict";
    $.ajax({
        url: 'php/openlast.php',
        type: 'get',
        success: function (data) {
            window.open("book.html?bookName=" + data);
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
}

function listBooks() {
    "use strict";
    $("#booklist option").remove();
    $.ajax({
        url: 'php/listbooks.php',
        type: 'get',
        dataType: 'json',
        success: function (json) {
            $.each(json, function (i, item) {
                $('#booklist').append($('<option/>', {
                    text :  item.bookName
                }));
                        /*for( var i = 0; i < item.bookList.length; i++){
                            $('#booklist').append($('<option/>', { 
                                text :  item.bookList[i].BookName
                            }))
                        }
                        if(item.lastBook != null){
                            window.open("book.html?bookName=" + item.lastBook);
                        }*/
            });
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
}

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
            if (json.success) {
                if (json.loginOk) {
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
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
            $("#failure").show();
        }
    });
}

function addBook() {
    "use strict";
    $.ajax({
        url: 'php/addbook.php',
        type: 'post',
        data: {'bookName': $("input[name=addbook]").val()},
        dataType: 'json',
        success: function (json) {
            window.alert("addbook activated");
            if (json.success) {
                window.alert("Addbook successfully added");
                listBooks();
                $("input[name=addbook]").val("");
            } else {
                window.alert("Addbook not added");
                window.alert(json.debug);
            }
                
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
}

function deleteBook() {
    "use strict";
    if ($('#booklist')[0].selectedIndex === -1) {
        window.alert("Please select an address book that you would like to delete");
    } else {
        $.ajax({
            url: 'php/deletebook.php',
            type: 'post',
            dataType: 'json',
            data: {
                'bookName' : $("#booklist>option:selected").html()
            },
            success: function (json) {
                if (!json.boolean) {
                    window.alert("Entry was not deleted, an error occured");
                } else {
                    window.alert("You have successfully deleted this entry");
                    listBooks();
                }
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError: " + err);
            }
        });
    }
}

function chooseBook() {
    "use strict";
    var bookName = $("#booklist>option:selected").html();
    window.open("book.html?bookName=" + bookName);
}