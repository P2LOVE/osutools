$("#cbxx").change(function(){
    if  ( $("input:checkbox").prop("checked") ) {

            $("#dform").addClass("openForm");
            $("#but").addClass("butOpenForm");
            $("#cbx").addClass("checkboxOpenForm");
            $("#stat").addClass("openStatus");
            $("#circle").addClass("crtO");
            $("#last").append("<div class='irct' id='newIrc' >IRC Server IP</div>");
            $("#last").append("<input class='irc' name='ircip' id='newIrcF' placeholder='IRC IP'>");
            $("#newIrcF").attr('onfocus', "this.placeholder = ''");
            $("#newIrcF").attr('onblur', "this.placeholder = 'IRC IP'");
    }
    if  ( !$("input:checkbox").prop("checked") ) {
        $("#dform").removeClass( "openForm" );
        $("#but").removeClass( "butOpenForm" );
        $("#cbx").removeClass( "checkboxOpenForm" );
        $("#stat").removeClass("openStatus");
        $("#circle").removeClass("crtO");
        $("#newIrc").remove();
        $("#newIrcF").remove();
    }
})