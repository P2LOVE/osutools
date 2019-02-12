function errorFunc()
{   
    var title = $('<p class="errorText errorWrap" id="error"></p>').text("ERROR!");
    var content = $('<p class="errorContent errorWrap" id="error"></p>').text($errorInfo);
    $("#dform").before(title, content);
    $(".errorWrap").wrapAll("<div class='errorCont'></div>");
}