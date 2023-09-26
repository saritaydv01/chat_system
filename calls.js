/****************************
 *  fucntion all_chats fetches all the chats from SESSIONS table in the left side panl;
 * it does so by an ajax call which sends a 
 * **************************** */
$(document).on('click', 'li', function (e) {
    var T = $('li').closest('id');
    console.log(T);
    var fun = this.getAttribute('id');
    console.log("fun " + fun);
    $("#add_convo").val(fun);
});

function all_chats(s_session_id) {

    var user_id = document.getElementsByClassName('user_firstnm')[0].textContent;
    const element = $(".chat_list");
    element.empty();
    $.ajax({

        type: "POST",
        url: "ajax.php",
        // dataType: "text",
        // async: false,
        data: "function=all_chats&s_session_id=" + s_session_id,
        // contentType: "application/json; charset=utf-8",
        success: function (data) {
            // console.log("all_chats:: " + data);
            unread_chatlist = JSON.parse(data);

            var count = (unread_chatlist).length;

            // console.log("for count : " + count);
            for (var i = 0; i < (count); i++) {

                // console.log("for counter : " + i);
                // console.log("session_id counter : " + unread_chatlist[i].session_id);
                // console.log("sender counter : " + unread_chatlist[i].sender);
                // console.log("user_id counter : " + unread_chatlist[i].user_id);

                $(element).append(`<div class="contact" data-chat="${i}" id=${unread_chatlist[i].session_id}><img src="img/user.png" alt="openchat"><div class="name"><h4 class="firstname" >${((unread_chatlist[i].sender).localeCompare(user_id)) !== 0 ? (unread_chatlist[i].sender) : (unread_chatlist[i].receiver)}</h4>
                <small class="message_time" }>${timestamp(unread_chatlist[i].timestamp)}</small><br><small class="sentence" }>${unread_chatlist[i].last_msg}</small></div></div>`);

            }

        },
        error: function (textStatus, errorThrown) {
            console.log("error");

        }
    });

}

/****************************************** 
 *  timestamp function takes input datetime in format "2023-03-29 18:54:25"  and returns date as "2023-03-09" if its not todays date OR returns time as "19:45" if its todays date; 
 * its used in the left side panel to show either the time (for today's date) or date for messages fetched as all chats
*******************************************/
function timestamp(datetime) {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    date = datetime.substr(0, 11);
    time = datetime.substr(11, 5);
    //  console.log("today : " + today); console.log("date : " + date); console.log("time :" + time); console.log("local: " + ((today).trim()).localeCompare((date).trim()));

    if (((today).trim()).localeCompare((date).trim()) != 0) {
        //         console.log("equal"); 
        date = datetime.substr(0, 11);
        today = dd + '/' + mm + '/' + yyyy;
        return today;
    }
    else {
        // console.log("no0");
        time = datetime.substr(11, 5);
        return time;
    }
}


/****************************************** 
 * opens an chat messages (conovo) in right panel based on session id  
 * 
 **********************************************************************************/
function open_chat(session_id, data_chat) {


    /*******************    about to be done : getting user id from index.php $session_id  and changing line 100 to swtich the sender's side of msg if its not equal to the logged in session  *************************/


    // console.log("here");
    var currently_active = document.getElementsByClassName(".message_box.active");
    if (currently_active.length > 2) {
        $(".message_box").remove();
        // document.getElementsByClassName('message_box').innerHTML = " ";
    }

    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: "function=open_chat&session_id=" + session_id,
        success: function (data) {
            $(".message_box ").empty();
            open_cht = JSON.parse(data);
            var count = (open_cht).length;
            var user_id = document.getElementsByClassName('user_firstnm')[0].id;

            for (let i = 0; i < count; i++) {
                // console.log('======================================================================');
                // console.log("localeCompare : " + (open_cht[i].sender_id).localeCompare(user_id));
                // console.log("is_outgoing: "+ open_cht[i].is_outgoing );
                // console.log("msg: "+    open_cht[i].msg );

                // console.log('====================================================================== ');
                $(".message_container").closest('div').find('.message_box').attr("data-chat", data_chat);


                $(".message_box").append(`<div class="message ${((open_cht[i].sender_id).localeCompare(user_id))
                    ? (open_cht[i].is_outgoing) !== 1 ? 'white' : 'green'
                    : (open_cht[i].is_outgoing) !== 0 ? 'green' : 'white'
                    }
                    
                    "><p>${open_cht[i].msg}</p><h6>${TimeOnly(open_cht[i].timestamp)}</h6></div></div>
              `);
            }
            $('.message_box').scrollTop($(document).height());
        },
        error: function (textStatus, errorThrown) {
            console.log("error");
        }
    });
}


function TimeOnly(date) {
    var hours = date.substr(11, 2);
    var minutes = date.substr(14, 2);
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    // minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

// fucntion to message date
function ShowDate(datetime) {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    date = datetime.substr(0, 11);
    time = datetime.substr(11, 5);
    date = datetime.substr(0, 11);
    today = dd + '/' + mm + '/' + yyyy;

    return today;
}

function find_ppl() {
    var user_id = document.getElementsByClassName('user_firstnm')[0].id;
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: "function=find_ppl&user_id=" + user_id,
        success: function (data) {
            // alert(data);
            // console.log(data);
            const element = $(".dropdown-menu");
            element.empty();
            unread_chatlist = JSON.parse(data);

            var count = (unread_chatlist).length;

            for (let i = 0; i < (count); i++) {

                $(element).append(`<li class="add_convo" onclick="add_convo('${unread_chatlist[i].uname}')" id="${unread_chatlist[i].uid}" >${unread_chatlist[i].uname} : <small>${unread_chatlist[i].full_name}</small></li>`);

            }

        },
        error: function (textStatus, errorThrown) {
            console.log("error");
        }
    });
}

function add_convo(name) {
      
    $(".message_box").empty();
    // var element = $('.active');
    //   element.classList.remove("active");
     

    $(".header_right").css("opacity", '');
    $(".type_message").css("opacity", '');
    // data-chat count
    var data_chat = document.getElementsByClassName("contact");
    count_DC = data_chat.length + 1;

    var sender = document.getElementsByClassName('user_firstnm')[0].textContent;
    var sender_id = document.getElementsByClassName('user_firstnm')[0].id;

    var receiver_id = document.getElementById("add_convo").value;

    // console.log("sender: "+sender);
    // console.log("sender_id: "+sender_id);
    // console.log("receiver: "+name);
    // console.log("receiver_id: "+receiver_id);
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: "function=add_convo&receiver=" + name + "&sender=" + sender + "&sender_id=" + sender_id + "&receiver_id=" + receiver_id,
        success: function (data) {

        },
        error: function (textStatus, errorThrown) {
            console.log("error");
        }
    });

    // sending msg param
    // $(".firstname").attr("id",name);
    $(".header.firstname").text(name);
    $(".firstname").attr("data-chat", count_DC);

}

