
$(function () {

  $(".fa-paper-plane").click(function () {


    var msg = $(".type_here").val();
    var session_id = $('.firstname').attr('id');
    var sender  = document.getElementsByClassName('user_firstnm')[0].innerText;
    
    //  console.log("sender: "+sender);
    // console.log("session_id: "+session_id);
    // console.log("receiver_id: "ac+receiver_id);
   

    $.ajax({
      type: "POST",
      url: "ajax.php",
      // dataType: "text",
      // async: false,
      data: "function=send_msg&session_id=" + session_id + "&msg=" + msg + "&sender=" + sender ,
      // contentType: "application/json; charset=utf-8",
      success: function (data) {
        $(".type_here").val(' ');
        // console.log('ajax msg');
        // console.log(data);
        // console.log("ajax msg");
      
      },
      error: function (textStatus, errorThrown) {
        console.log("error");

      }
    });


    // if (text) {
    //   var new_text = $(".template .message").clone();
    //   new_text.children(".content").text(text);
    //   new_text.children(".message_time").text(current_time());
    //   $(".message_box.active").append(new_text);
    //   $(".message_box").scrollTop(10000);
    // };
    // $(".type_here").val("");

    // setTimeout(function () {
    //   var new_text = $(".template .message").clone();
    //   new_text.toggleClass("green white");
    //   new_text.children(".content").text("Happiness is the meaning and purpose of life, the aim and end of one's existence");
    //   new_text.children(".message_time").text(current_time());
    //   $(".message_box.active").append(new_text);
    //   $(".header_right").find(".message_time").text(current_time());
    //   $(".chat_list").children(".contact.active").find(".sentence").text("Happiness is the meaning and purpose of life, the aim and end of one's existence").css("color", "black").css("font-weight", "Bold");
    //   $(".chat_list").children(".contact.active").find(".message_time").text(current_time());
    //   $(".message_box").scrollTop(10000);
    // }, 1000);

  });
  $(".type_here").keypress(function (e) {
    var key = e.which;
    if (key == 13) {
      $(".fa-paper-plane").click();
      return false;
    }
  });

  $(".searchme").keyup(function () {
    var lookup = $(this).val().toLowerCase();
    $(".contact").each(function () {
      if ($(this).find(".firstname").text().toLowerCase().includes(lookup)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });

  // $(".contact").click(function () {

  $('.chat_list').on('click', '.contact', function (e) {
    let talk = $(e.target).attr('data-chat') || $(e.target).closest('.contact').attr('data-chat');

    var talkscreen = $('.message_box[data-chat="' + talk + '"]');
    $(".message_box").removeClass("active");
    $(".contact").removeClass("active");
    talkscreen.addClass("active");
    $(this).addClass("active");
    
    var name = $(".contact.active").find(".firstname").text();
    var session_id = $(this).attr('id');
    var data_chat = $(this).attr('data-chat');
    
    $(".header_right").css("opacity",'');
    $(".type_message").css("opacity",'');
    $(".header_right").children(".name").find(".firstname").text(name);
    $(".header_right").children(".name").find(".firstname").attr("id", session_id);
    $(".header_right").children(".name").find(".firstname").attr("data-chat", data_chat);
    var photo = $(this).find("img").attr("src");
    $(".header_right").children("img").attr("src", photo)
  });



  $(document).on("click", ".message i", function () {
    $(this).parent(".message").find(".message_options").toggleClass("active");
  });

  $(document).on("click", ".message_delete", function () {
    $(this).closest(".message").hide();
  });
});

function current_time() {
  var d = new Date();
  var m = d.getMinutes();
  var h = d.getHours();

  if (m < 10) {
    m = "0" + m;
  };
  if (h < 10) {
    h = "0" + h;
  }
  return h + ":" + m;
};



