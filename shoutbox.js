//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
$(document).ready(function () {
    var inputUser = $("#nick");
    var inputMessage = $("#message");
    var loading = $("#loading");
    var messageList = $(".content > ul");

    function updateShoutbox() {
        messageList.hide();
        loading.fadeIn();
        scrollTop: $('#shoutbox').get(0).scrollHeight;
        $.ajax({
            type: "POST",
            url: "shoutbox.php",
            data: "action=update",
            complete: function (data) {
                loading.fadeOut();
                messageList.html(data.responseText);
                messageList.fadeIn(1);
                $('#shoutbox').animate({
                    scrollTop: $('#shoutbox').get(0).scrollHeight
                }, 1)
            }
        })
    }function checkForm() {
        if (inputUser.attr("value") && inputMessage.attr("value")) return true;
        else return false;
    }
    setInterval(updateShoutbox, 30000);
    updateShoutbox();
    $('#shoutbox').animate({
        scrollTop: $('#shoutbox').get(0).scrollHeight
    }, 1);
    $("#form").submit(function () {
        if (checkForm()) {
            var nick = inputUser.attr("value");
            var message = inputMessage.attr("value");
            $("#send").attr({
                disabled: true,
                value: "..."
            });
            $("#send").blur();
            $.ajax({
                type: "POST",
                url: "shoutbox.php",
                data: "action=insert&nick=" + nick + "&message=" + message,
                complete: function (data) {
                    messageList.html(data.responseText);
                    updateShoutbox();
                    $("#send").attr({
                        disabled: false,
                        value: ">>"
                    });
                    $("#message").attr({
                        disabled: false,
                        value: ""
                    });
                    $('input[name=message]').val('000')
                }
            })
        } else alert("Please fill all fields!");
        return false
    })
});