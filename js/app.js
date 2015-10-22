/*jslint browser: true, devel:true*/
/*global $, jQuery, alert*/

//Variable that tells DB which address book we are using
var bookName = null;

//Function that lists the entries in the DB sorted according to the user's liking
function listEntries(value) {
    "use strict";
    $("#entrylist option").remove();
    $.ajax({
        url: 'php/listentries.php',
        type: 'get',
        data: {
            'bookName' : bookName,
            'sort': value
        },
        dataType: 'json',
        success: function (json) {
            //window.alert("listEntries activated");
            if (value === 'name') {
                $.each(json, function (i, item) {
                    if (typeof item === 'object') {
                        $('#entrylist').append($('<option/>', {
                            value: item.id,
                            text :  item.lastname + ", " + item.firstname
                        }));
                    }
                });
            } else {
                $.each(json, function (i, item) {
                    if (typeof item === 'object') {
                        $('#entrylist').append($('<option/>', {
                            value: item.id,
                            text :  item.zip + "   " + item.lastname + ", " + item.firstname
                        }));
                    }
                });
            }
                
            
                    
                    
                    /*if(item.success){
                        for( var i = 0; i < item.entryList.length; i++){
                            $('#entrylist').append($('<option/>', { 
                                value: item.entryList[i].id,
                                text :  item.entryList[i].lastname + ", " + item.entryList[i].firstname + "         " + item.entryList[i].zip
                            }))
                        }
                    } else {
                        window.alert("Failure to list entries");
                    }*/
                    
          
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
}

//Utility function that toggles the input boxes
function toggleTextBoxes(boolean) {
    "use strict";
    $("input[name=firstname]").prop('disabled', boolean);
	$("input[name=lastname]").prop('disabled', boolean);
    $("input[name=addr1]").prop('disabled', boolean);
	$("input[name=addr2]").prop('disabled', boolean);
	$("input[name=city]").prop('disabled', boolean);
	$("input[name=state]").prop('disabled', boolean);
	$("input[name=zip]").prop('disabled', boolean);
	$("input[name=phone]").prop('disabled', boolean);
	$("input[name=email]").prop('disabled', boolean);
}

//Utility function that clears all of the text boxes
function clearTextBoxes() {
    "use strict";
    $("input[name=firstname]").val("");
	$("input[name=lastname]").val("");
    $("input[name=addr1]").val("");
	$("input[name=addr2]").val("");
	$("input[name=city]").val("");
	$("input[name=state]").val("");
	$("input[name=zip]").val("");
	$("input[name=phone]").val("");
	$("input[name=email]").val("");
}

//Utility function that validates for valid input
function validation() {
    "use strict";
    var phoneRegex = /^(\d{7}|\d{10})$/,
        stateRegex = /\b([A-Z]{2})\b/,
        zipRegex = /^\d{5}(?:[-\s]\d{4})?$/,
        emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    
    if (($("input[name=firstname]").val() === "" && $("input[name=lastname]").val() === "") ||
            ($("input[name=addr1]").val() === "" &&
            $("input[name=addr2]").val() === "" &&
            $("input[name=city]").val() === ""  &&
            $("input[name=state]").val() === "" &&
            $("input[name=zip]").val() === ""   &&
            $("input[name=phone]").val() === "" &&
            $("input[name=email]").val() === "")) {
        window.alert("To submit an entry, please enter at least either a first name or a last name and one other piece of information");
        return false;
    }
    if ($("input[name=phone]").val() !== "" && (!phoneRegex.test($("input[name=phone]").val()))) {
        if (!confirm("Invalid phone number, please correct. Needs 7 or 10 digits. If you want to continue anyways, press OK")) {return false; }
    }
    if ($("input[name=state]").val() !== "" && (!stateRegex.test($("input[name=state]").val()))) {
        if (!confirm("Invalid state code, please correct. Needs to be two uppercase letters. If you want to continue anyways, press OK")) {return false; }
    }
    if ($("input[name=zip]").val() !== "" && (!zipRegex.test($("input[name=zip]").val()))) {
        if (!confirm("Invalid zip number, please correct. Needs 5 or 9 digits. If you want to continue anyways, press OK")) {return false; }
    }
    if ($("input[name=email]").val() !== "" && (!emailRegex.test($("input[name=email]").val()))) {
        if (!confirm("Invalid email number, please correct. Needs an @ symbol and a .suffix (TLD). If you want to continue anyways, press OK")) {return false; }
    }
    return true;
}

//Once document is loaded, several startup actions
$(document).ready(function () {
	"use strict";
    
    bookName = decodeURI(parent.document.URL.substring(parent.document.URL.indexOf('=') + 1, parent.document.URL.length));
    $("#submit-btn").hide();
    $("#cancel-btn").hide();
    $("#change-btn").hide();
    listEntries("name");
    window.alert("WE RECIEVED " + bookName);

});

//Allows you to cancel entering or editing an entry
function cancelEntry() {
    "use strict";
    clearTextBoxes();
    $("#entries").animate({ opacity: 100 });
    $("#edit-btn").fadeIn(300);
    $("#delete-btn").fadeIn(300);
    $("#add-btn").fadeIn(300);
    $("#submit-btn").hide();
    $("#cancel-btn").hide();
    $("#change-btn").hide();
    toggleTextBoxes(true);
}

//Function that shows the user the information for a user when they click on their icon
function viewEntry(value) {
    "use strict";
    $.ajax({
        url: 'php/viewentry.php',
        type: 'get',
        data: {
            'bookName': bookName,
            'id': value
        },
        dataType: 'json',
        success: function (json) {
            $.each(json, function (i, item) {
               
                $("input[name=firstname]").val(item.firstname);
                $("input[name=lastname]").val(item.lastname);
                $("input[name=addr1]").val(item.addr1);
                $("input[name=addr2]").val(item.addr2);
                $("input[name=city]").val(item.city);
                $("input[name=state]").val(item.state);
                $("input[name=zip]").val(item.zip);
                $("input[name=phone]").val(item.phone);
                $("input[name=email]").val(item.email);
            });
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
}

//Function that sets up the page for adding an entry
function addEntry() {
    "use strict";
    $("#entries").animate({ opacity: 0 });
    $("#edit-btn").fadeOut(300);
    $("#submit-btn").show();
    $("#cancel-btn").show();
    toggleTextBoxes(false);
    clearTextBoxes();
}

//Function allows one to press submit and push information to the server.
function submitEntry() {
    "use strict";
    if (validation()) {
        $.ajax({
            url: 'php/addentry.php',
            type: 'post',
            data: {
                'bookName' : bookName,
                'fn': $("input[name=firstname]").val(),
                'ln': $("input[name=lastname]").val(),
                'addr1': $("input[name=addr1]").val(),
                'addr2': $("input[name=addr2]").val(),
                'city': $("input[name=city]").val(),
                'st': $("input[name=state]").val(),
                'zip': $("input[name=zip]").val(),
                'ph': $("input[name=phone]").val(),
                'email': $("input[name=email]").val()
            },
            success: function (data) {
                if (data === -1) {
                    window.alert("Entry was not added, an error occured");
                } else {
                    window.alert("You have successfully added the entry ");
                    listEntries("name");
                }
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError: " + err);
            }
        });
    
        $("#entries").animate({ opacity: 100 });
        $("#edit-btn").fadeIn(300);
        $("#delete-btn").fadeIn(300);
        $("#add-btn").fadeIn(300);
        $("#submit-btn").hide();
        $("#cancel-btn").hide();
        toggleTextBoxes(true);
        clearTextBoxes();
    }
}

//Function that deletes the current entry
function deleteEntry() {
    "use strict";
    if ($('#entrylist')[0].selectedIndex === -1) {
        window.alert("Please select an entry that you would like to delete");
    } else {
        var $value = $('#entrylist option:selected').val();
        $.ajax({
            url: 'php/deleteentry.php',
            type: 'post',
            dataType: 'json',
            data: {
                'bookName' : bookName,
                'id': $value
            },
            success: function (json) {
                if (!json.boolean) {
                    window.alert("Entry was not deleted, an error occured");
                } else {
                    window.alert("You have successfully deleted this entry");
                    listEntries("name");
                }
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError: " + err);
            }
        });
        clearTextBoxes();
    }
}

//Function that sets up the page for editing an existing entry
function editEntry() {
    "use strict";
    if ($('#entrylist')[0].selectedIndex === -1) {
        window.alert("You must have an entry selected in order to edit");
    } else {
        $("#entries").animate({ opacity: 0 });
        $("#edit-btn").fadeOut(300);
        $("#cancel-btn").show();
        $("#change-btn").show();
        toggleTextBoxes(false);
    }
}

//Function that allows one to press change and push information to the server
function changeEntry() {
    "use strict";
    var $value = $('#entrylist option:selected').val();
    //Input validation
    if (validation()) {
        $.ajax({
            url: 'php/editentry.php',
            type: 'post',
            data: {
                'bookName' : bookName,
                'id': $value,
                'fn': $("input[name=firstname]").val(),
                'ln': $("input[name=lastname]").val(),
                'addr1': $("input[name=addr1]").val(),
                'addr2': $("input[name=addr2]").val(),
                'city': $("input[name=city]").val(),
                'st': $("input[name=state]").val(),
                'zip': $("input[name=zip]").val(),
                'ph': $("input[name=phone]").val(),
                'email': $("input[name=email]").val()
            },
            success: function (data) {
                if (data === -1) {
                    window.alert("Entry was not edited, an error occured");
                } else {
                    window.alert("You have successfully edited the entry ");
                    listEntries("name");
                }
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError: " + err);
            }
        });
    
        $("#entries").animate({ opacity: 100 });
        $("#edit-btn").fadeIn(300);
        $("#delete-btn").fadeIn(300);
        $("#add-btn").fadeIn(300);
        $("#submit-btn").hide();
        $("#cancel-btn").hide();
        $("#change-btn").hide();
        toggleTextBoxes(true);
        clearTextBoxes();
    }
}