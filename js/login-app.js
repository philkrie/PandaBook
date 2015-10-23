/*jslint browser: true, devel:true*/
/*global $, jQuery, alert*/

var lastOpen = null;

$(document).ready(function () {
	"use strict";
    $("#address-books").hide();
    $("#failure").hide();

    $("#import").submit(function (e) {
    
    var formObj = $(this);
    var formURL = formObj.attr("action");
    var formData = new FormData(this);
    $.ajax({
        url: formURL,
        type: 'POST',
        data:  formData,
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data, textStatus, jqXHR) {
            if(data === 'FAILURE'){
                window.alert("The file was not imported!");
            } else {
              window.alert("The file was successfully imported!");
                listBooks();  
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            window.alert("The file was not imported!");
        }
    });
    e.preventDefault(); //Prevent Default action. 
    e.unbind();
});
$("#multiform").submit(); //Submit the form

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
                    openLast();
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
    if($("input[name=addbook]").val().replace(/^\s+|\s+$/g, "").length == 0){
        window.alert("You must type in a name for the address book");
    } else {
    $.ajax({
        url: 'php/addbook.php',
        type: 'post',
        data: {'bookName': $("input[name=addbook]").val()},
        dataType: 'json',
        success: function (json) {
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
}

function deleteBook() {
    "use strict";
    if($('#booklist option').length <= 1){
        window.alert("You cannot delete your last book!");
    }
    else if ($('#booklist')[0].selectedIndex === -1) {
        window.alert("Please select an address book that you would like to delete");
    } else if (confirm("Are you sure you want to delete this book?")) {
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
    window.alert("Opened address book: " + bookName);
}

function exportBook() {
    "use strict";
    if ($('#booklist')[0].selectedIndex === -1) {
        window.alert("Please select an address book to export");
    }else {
    var bookName = $("#booklist>option:selected").html();
    $.ajax({
        url: 'php/exportbook.php',
        type: 'get',
        data: {
            'bookName': bookName
        },
        dataType: 'html',
        success: function (data) {
            window.location.href = 'php/'+bookName+'.tsv';
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
    }
}