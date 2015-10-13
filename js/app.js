$(document).ready(function () {
	"use strict";
    
    $("#submit-btn").hide();
    $("#cancel-btn").hide();
    listEntries();

});

//Function that shows the user the information for a user when they click on their icon
function viewEntry(value) {
    "use strict";
    $.ajax({
        url: 'php/viewentry.php',
        type: 'get',
        data: {'id': value},
        dataType: 'json',
        success: function (json) {
            window.alert("viewEntry activated");
            $.each(json, function(i, item) {
	           if(typeof item == 'object') {
                $("input[name=firstname]").val(item.firstname);
                $("input[name=lastname]").val(item.lastname);
                $("input[name=city]").val(item.city);
                $("input[name=state]").val(item.state);
                $("input[name=zip]").val(item.zip);
                $("input[name=phone]").val(item.phone);
                $("input[name=email]").val(item.email);
               }
            })
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
    
    
}

//Function that sets up the page for adding an entry
function addEntry(){
    "use strict";
    $("#entries").fadeOut(300);
    $("#edit-btn").fadeOut(300);
    $("#add-btn").fadeOut(300);
    $("#submit-btn").show();
    $("#cancel-btn").show();
    
    $("input[name=firstname]").prop('disabled', false);
	$("input[name=lastname]").prop('disabled', false);
	$("input[name=city]").prop('disabled', false);
	$("input[name=state]").prop('disabled', false);
	$("input[name=zip]").prop('disabled', false);
	$("input[name=phone]").prop('disabled', false);
	$("input[name=email]").prop('disabled', false);
    $("input[name=firstname]").val("");
	$("input[name=lastname]").val("");
	$("input[name=city]").val("");
	$("input[name=state]").val("");
	$("input[name=zip]").val("");
	$("input[name=phone]").val("");
	$("input[name=email]").val("");
    
}

//Function allows one to press submit and push information to the server.
function submitEntry(){
    
    //TODO: NEEDS INPUT VALIDATION AND VIEW
    $.ajax({
        url: 'php/addentry.php',
        type: 'post',
        data: {
            'fn': $("input[name=firstname]").val(), 
            'ln': $("input[name=lastname]").val(),  
            'city': $("input[name=city]").val(),  
            'st': $("input[name=state]").val(), 
            'zip': $("input[name=zip]").val(), 
            'ph': $("input[name=phone]").val(), 
            'email': $("input[name=email]").val(), 
        },
        success: function(data) {
            if(data == -1){
                window.alert("Entry was not added, an error occured");
            } else {
                window.alert("You have successfully added this entry");
                $('#entrylist').append($('<option/>', { 
                    value: data,
                    text :  $("input[name=lastname]").val() + ", " + $("input[name=firstname]").val()
                }))
            
            };
            
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
    
    $("#entries").fadeIn(300);
    $("#edit-btn").fadeIn(300);
    $("#delete-btn").fadeIn(300);
    $("#add-btn").fadeIn(300);
    $("#submit-btn").hide();
}

function listEntries(){
    $.ajax({
        url: 'php/getlist.php',
        type: 'get',
        dataType: 'json',
        success: function (json) {
            window.alert("listEntries activated");
            $.each(json, function(i, item) {
	           if(typeof item == 'object') {
                    $('#entrylist').append($('<option/>', { 
                        value: item.id,
                        text :  item.lastname + ", " + item.firstname
                    }))
               }
            })
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
}

function deleteEntry(){
    if($('#entrylist')[0].selectedIndex == -1){
        window.alert("Please select an entry that you would like to delete");
    } else {
        $value = $('#entrylist option:selected').val();
        $.ajax({
        url: 'php/deleteentry.php',
        type: 'post',
        data: {'id': $value},
        success: function(data) {
            if(data == -1){
                window.alert("Entry was not deleted, an error occured");
            } else {
                window.alert("You have successfully deleted this entry");
                
                $('#entrylist option[value=' + $value + ']').remove();
            };
        },
        error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError: " + err);
        }
    });
    }
}

//TODO CANCEL BUTTON
//TODO EDIT BUTTON