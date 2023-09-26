<?php
include("dbcon.php");

$function = $_REQUEST;
// echo json_encode($function);
// exit;
if ($function['function'] == 'all_chats') {
    // echo "all_chats";
    $s_session_id = $function['s_session_id'];
    $user = "select * from sessions where sender_id !=''  AND receiver_id !='' AND sender_id !=' '  AND receiver_id !=' ' AND 
    sender_id ='$s_session_id' OR receiver_id ='$s_session_id' ";
    // $user = "select * from sessions ";
    $result = mysqli_query($conn, $user);

    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;
    echo json_encode($rows);
    exit;
}

if ($function['function'] == 'open_chat') {
    // echo "open_chats";
    $rows = array();
    $user = "select * from messages where session_id = '" . $function['session_id'] . "'";
    $result = mysqli_query($conn, $user);
    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;

    echo json_encode($rows);
    exit;
}

if ($function['function'] == 'send_msg') {
    $msg = $function['msg'];
    $session_id = $function['session_id'];
    $curr_sender =  $function['sender'];

    $query = "select * from sessions where session_id = '$session_id' ";
    $result = mysqli_query($conn, $query);
    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;

    $sender = $rows[0]['sender'];


    // the below if condition works as if the under cuurently logged (curr_sender) is the same user as the orginal intiater of the convo [this is just what i have picked for distinction] the sender and reciver params will remain the same as inderted in the session table for this session. if the current user isnt the user who intiated the convo, this indicates that the other person is sending the msg, so we reverse the params to be inserted in the else part.   

    if (strcmp(trim($sender), trim($curr_sender)) == 0) {
        $sender = $rows[0]['sender'];
        $sender_id = $rows[0]['sender_id'];
        $receiver = $rows[0]['receiver'];
        $receiver_id = $rows[0]['receiver_id'];
        $is_outgoing = 1;
    } else {
        $sender = $rows[0]['receiver'];
        $sender_id = $rows[0]['receiver_id'];
        $receiver = $rows[0]['sender'];
        $receiver_id = $rows[0]['sender_id'];
        $is_outgoing = 0;
    }

    // for is_outgoing : is_outgoing is derived and stored in sessions table and it help in determining which color the msg would be. here it is crucial that correct is_outgoing param is passed. if the sender == sender in session table, is outgoing would be 1, otherwise it'll be zero. distinguishing the two users who talk to each other.

    $query = "INSERT INTO `messages`(`session_id`,`sender`,  `sender_id` ,`receiver`, `receiver_id`, `msg`, `is_outgoing`, `last_msg`) values ('$session_id','$sender' , '$sender_id' , '$receiver' , '$receiver_id' , '$msg' , '$is_outgoing', '$msg') ";

    $query1 = "update sessions set last_msg = '$msg' where session_id = '$session_id' ";

    $result = mysqli_query($conn, $query);
    $result = mysqli_query($conn, $query1);

    exit;
}

if ($function['function'] == 'find_ppl') {

    $result_arr = array();
    $UsersData = array();
    $SessionData = array();
    $user_id =  $function['user_id'];
    $query = "select uname , full_name , uid from users";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if ($row['uid'] !== '' and $row['uid'] !== $function['user_id']) {
            $UsersData[$row['uid']] = $row;
        }
    }

    $query = "select `sender_id`, `receiver_id` from sessions where `sender_id` = '" . $function['user_id'] . "' OR `receiver_id` = '" . $function['user_id'] . "'";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $SessionData[$row['sender_id']] = $row;
        $SessionData[$row['receiver_id']] = $row;
        $SessionData[$function['user_id']] = $row;
    }

    $result_arr = array_diff_key($UsersData, $SessionData);
    $array = array_values($result_arr);
    // echo json_encode($UsersData);echo "=====================================================";
    // echo json_encode($SessionData);
    echo json_encode($array);
    exit;
}

if ($function['function'] == 'add_convo') {
    $new_convo_receiver = $function['receiver'];
    $new_convo_receiver_id = $function['receiver_id'];
    $new_convo_sender = $function['sender'];
    $new_convo_sender_id = $function['sender_id'];

    $query = "INSERT INTO `sessions`( `receiver`,`sender`, `sender_id`, `receiver_id`) VALUES ( '$new_convo_receiver', 
    '$new_convo_sender','$new_convo_sender_id','$new_convo_receiver_id')";
    $result = mysqli_query($conn, $query);

    $query ="select session_id from sessions where `sender_id` = '" . $new_convo_sender . "' OR `receiver_id` = '" .$new_convo_receiver . "'";
    while ($r = mysqli_fetch_assoc($result)) $rows[] = $r;

    echo json_encode($rows);

    exit;
}
