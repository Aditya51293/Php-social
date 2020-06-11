$(document).ready(function(){
    //to show registration form
    $("#signup").click(function(){
        $("#first").slideUp("slow",function(){
            $("#second").slideDown("slow");
        });
    });


    //to show login form
    $("#signin").click(function(){
        $("#second").slideUp("slow",function(){
            $("#first").slideDown("slow");
        });
    });
});