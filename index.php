<?php
include('dbcon.php');
session_start();

/****  when user logs in, all the related data will be fetched from users table. such as a user id . 
 */

$session_un = $_SESSION['username'];
$session_uid = $_SESSION['session_id'];


// $session_un = $_SESSION['username'] = 'hema';
// $session_uid = $_SESSION['session_id'] = 'U100' ;

// echo $query = "select * from sessions where sender OR receiver ='$session_un' ";
// $result = mysqli_query($conn, $query);
// while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;
// // echo "<pre>";
// // var_dump($rows);
// $session_uid = $_SESSION['session_id'] = $rows[0]['session_id'] ;


if (isset($_SESSION['username'])) {
  //echo $_SESSION['username']; 
} else {
  header("location : login.php");
  echo "session isnt set ";
  exit;
}

?>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <script src="calls.js"></script>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <link rel="stylesheet" href="styles.css">
  <title>Chat system</title>
</head>

<body>
  <header>
    <div class="header_left">
      <img src="img/user.png" alt="profile">

      <h3 class="user_firstnm" id="<?php echo $_SESSION['session_id'] ?>"><?php echo ($_SESSION['username']) ?></h4>
        <div class="icons_left">
        <i class="fas fa-circle-notch" title="Logout" style="margin-right: 70px;">
        <a href="logout.php">Logout</a>
        </i> 

          <div class="dropdown">
            <i class="dropdown fas fa-user-plus dropdown-toggle " data-toggle="dropdown" title="Find new people" onclick="find_ppl()"></i>
            <ul class="dropdown-menu" style="z-index: 2;">
              <!-- <li><a href="#">HTML</a></li>
              <li><a href="#">CSS</a></li>
              <li><a href="#">JavaScript</a></li> -->
            </ul>
            </div>
          
          <!-- <i class="fas fa-comment-alt"></i> -->
          <!-- <i class="fas fa-ellipsis-v"></i> -->
        </div>
    </div>

    <div class="header_right" style="opacity: 0; z-index:-1;">
      <img src="img/user.png" alt="openchat">
      <div class="name">
        <h4 class="header firstname">Socrates</h4>
        <!-- <small>Last seen today at <span class="message_time">18:30</span></small> -->
      </div>
      <!-- <div class="icons_right">
        <i class="fas fa-search"></i>
        <i class="fas fa-paperclip"></i>
        <i class="fas fa-ellipsis-v"></i>
      </div> -->
    </div>
  </header>

  <section>
    <input name="add_convo" type="hidden" id="add_convo" name="add_convo" value=" ">
    <div class="container_left">
      <div class="search_bar">
        <i class="fas fa-search"></i>
        <input class="searchme" type="text" placeholder="Search or start new chat">
      </div>
      <div class="chat_list" id="chat_list">

        <!--  <div class="contact active" data-chat="0">
          <img src="img/user.png" alt="openchat">
          <div class="name">
            <h4 class="firstname">Socrates</h4>
            <small class="message_time">06:35</small><br>
            <small class="sentence">True knowledge exists in knowing that you know nothing</small>
          </div>
        </div>  -->



      </div>
    </div>

    <div class="container_right">
      <div class="message_container">

        <!-- <div class="message date">
          29/10/2023
        </div> -->

        <!-- <div class="message_box " data-chat="0">
          <div class="message white">
            <p>data-chat="0"</p>
            <h6>05:15</h6><i class="fas fa-chevron-down"></i>
            <div class="message_dropdown">
              <div class="message_options">
                <div class="message_info">Info</div>
                <div class="message_delete">Delete</div>
              </div>
            </div>
          </div>

          <div class="message green">
            <p>Imagination is moredata-chat="0"</p>
            <h6>05:30</h6><i class="fas fa-chevron-down"></i>
            <div class="message_dropdown">
              <div class="message_options">
                <div class="message_info">Info</div>
                <div class="message_delete">Delete</div>
              </div>
            </div>
          </div>
        </div> -->

      </div>

      <footer>
        <div class="type_message" style="opacity: 0;">
          <!-- <i class="fas fa-smile"></i> -->
          <input class="type_here" type="text" placeholder="Type a message">
          <i class="fas fa-paper-plane"></i>
        </div>
      </footer>
    </div>
  </section>

  <div class="template">
    <div class="message green">
      <p class="content">Something new</p>
      <h6 class="message_time">5:55</h6><i class="fas fa-chevron-down"></i>
      <div class="message_dropdown">
        <div class="message_options">
          <div class="message_info">Info</div>
          <div class="message_delete">Delete</div>
        </div>
      </div>
    </div>
  </div>

  <script src="basic.js" charset="utf-8"></script>
  <script>
    $(document).ready(function() {
      all_chats('<?php echo $session_uid ?>');
    });

    /**
     * find the nearest div and session_id stores its ID 
     */
    $('.chat_list').on('click', '.contact', function(e) {

      var session_id = $(this).closest('div').attr('id');

      var data_chat = $(this).closest('div').attr('data-chat');


      var currently_active = document.getElementsByClassName("active");
      if (currently_active.length > 0) {
        currently_active[0].className = currently_active[0].className.replace(" active", "");
      }
      this.className += " active";

      open_chat(session_id, data_chat);

      // $(".message_box.active").hide();

      $.ajax({
        type: "POST",
        url: "ajax.php",
        data: "function=open_chat&session_id=" + session_id,
        success: function(data) {

          open_cht = JSON.parse(data);
          var count = (open_cht).length;

          $(".message_container").append(` <div class="message_box active" data-chat="">  </div>`);
          for (let i = 0; i < count; i++) {

            $(".message_container").closest('div').find('.message_box').attr("data-chat", data_chat);

            $(".message_box").append(`  
                <div class="message ${(open_cht[i].is_outgoing == 1) ? 'green' : 'white'}"><p>${open_cht[i].msg}</p><h6>for counter :${i}</h6><i class="fas fa-chevron-down"></i><div class="message_dropdown"><div class="message_options"><div class="message_info">Info</div><div class="message_delete">Delete</div></div></div></div>
              `);

          }

          $('.message_box').scrollTop($(document).height());
        },
        error: function(textStatus, errorThrown) {
          console.log("error");

        }
      });

    //   $.ajax({
    //     type: "POST",
    //     url: "ajax.php",
    //     data: "function=open_chat&session_id=" + session_id,
    //     success: function (data) {
    //         $(".message_box ").empty();
    //         open_cht = JSON.parse(data);
    //         var count = (open_cht).length;
    //         var user_id = document.getElementsByClassName('user_firstnm')[0].id;

    //         for (let i = 0; i < count; i++) {
              
    //             $(".message_container").closest('div').find('.message_box').attr("data-chat", data_chat);

    //             $(".message_box").append(`<div class="message ${((open_cht[i].sender_id).localeCompare(user_id))
    //                 ? (open_cht[i].is_outgoing) !== 1 ? 'white' : 'green'
    //                 : (open_cht[i].is_outgoing) !== 0 ? 'green' : 'white'
    //                 }
                    
    //                 "><p>${open_cht[i].msg}</p><h6>${TimeOnly(open_cht[i].timestamp)}</h6></div></div>
    //           `);
    //         }
    //         $('.message_box').scrollTop($(document).height());
    //     },
    //     error: function (textStatus, errorThrown) {
    //         console.log("error");
    //     }
    // });
    });

    $(document).ready(function() {


      setInterval(function() {
          var session_id = $('.firstname').attr('id');
          var data_chat = $('.firstname').attr('data-chat');

          open_chat(session_id, data_chat);
          // all_chats('<?php echo $session_uid ?>');
        },
        1000
      );
    });

  </script>
</body>

</html>