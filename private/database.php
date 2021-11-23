<?php

include('config.php');

//function create($table=""){$sql="INSERT";}
function read($table = "", $column_name = "", $id = "")
{
    global $conn;
    $sql = "SELECT * FROM " . $table . " WHERE " . $column_name . " =" . $id . " ORDER by id DESC";
    return $conn->query($sql);
}
function read_all($table = "")
{
    global $conn;
    $sql = "SELECT * FROM " . $table . " ORDER by id DESC";
    return $conn->query($sql);
}
//function find_question($topic, $difficulty){

//}
function session_exist($session_exist = array())
{

    if (empty($session_exist)) {
        return false;
    }
    for ($i = 0; $i <= count($session_exist) - 1; $i++) {
        if (!isset($session_exist[$i])) {
            return false;
            break;
        }
    }
    return true;
}
function generate_question_new($topic_id = '', $difficulty = '')
{
    global $conn;
    $sql = "SELECT * FROM questions WHERE topic_id='$topic_id' && difficulty='$difficulty'";
    return $conn->query($sql);
}
function generate_question($topic_id = '', $difficulty = '', $limit, $offset)
{
    global $conn;
    $sql = "SELECT * FROM questions WHERE topic_id='$topic_id' && difficulty='$difficulty' ORDER by id DESC LIMIT {$limit} OFFSET {$offset} ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}

function count_question($topic_id = '', $difficulty = '')
{
    global $conn;
    $sql = "SELECT * FROM questions WHERE topic_id='$topic_id' && difficulty='$difficulty'";
    $result = $conn->query($sql);
    return $result->num_rows;
}

//ANSWERS

function answer_is_correct($user_answer = '', $question_id)
{
    global $conn;
    $c_answer = get_answer($question_id);
    if ($c_answer == $user_answer) {
        return true;
    } else {
        return 0;
    }
}
function get_answer($id = '')
{
    global $conn;
    $sql = "SELECT answer FROM questions WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_object()->answer;
}


//========================================================================
//function update(){}
function delete($table = "", $column_name = "", $id = "")
{
    global $conn;
    $sql = "DELETE FROM" . $table . "WHERE" . $column_name . "=" . $id;
    return $conn->query($sql);
}
function difficulty($difficulty = '')
{
    if ($difficulty == 1) {
        $difficulty = 'Easy';
    }
    if ($difficulty == 2) {
        $difficulty = 'Average';
    }
    if ($difficulty == 3) {
        $difficulty = 'Hard';
    }
    return $difficulty;
}
function delete_question($id)
{
    global $conn;
    $sql = "DELETE FROM questions Where id=$id";
    return $conn->query($sql);
}
function update_question($id = "", $topic_id = "", $question = "", $difficulty = "", $c1 = "", $c2 = "", $c3 = "", $c4 = "", $answer = "", $explanation = "")
{
    global $conn;
    $sql = "UPDATE questions SET
                topic_id='$topic_id',
                question='$question',
                difficulty='$difficulty',
                c1='$c1',
                c2='$c2',
                c3='$c3',
                c4='$c4',
                answer='$answer',
                explanation='$explanation'
                WHERE id=$id";

    if ($conn->query($sql)) {

        return $conn->query($sql);
    } else {
        return false;
    }
} //$id, $question,$difficulty,$c1,$c2,$c3,$c4,$answer
//read("topic", "topic_id", "1");
function create_question($topic_id, $question = "", $difficulty = "", $c1 = "", $c2 = "", $c3 = "", $c4 = "", $answer = "", $explanation = "")
{
    global $conn;
    $sql = "INSERT INTO questions(topic_id, question,difficulty,c1,c2,c3,c4,answer, explanation)
    VALUES('$topic_id', '$question','$difficulty','$c1','$c2','$c3','$c4','$answer', '$explanation')";
    return $conn->query($sql);
}


function check_variables($id, $question, $difficulty, $c1, $c2, $c3, $c4, $answer)
{
    echo $id . " <br>";
    echo $question . " <br>";
    echo $difficulty . " <br>";
    echo $c1 . " <br>";
    echo $c2 . " <br>";
    echo $c3 . " <br>";
    echo $c4 . " <br>";
    echo $answer . " <br>";
}

function count_empty_fields($errors = [], $empty = 0)
{

    for ($i = 0; $i <= count($errors) - 1; $i++) {
        if ($errors[$i] == "") {
            $empty++;
        }
    }
    return $empty;
}


function query_success($sql)
{
    global $conn;
    if ($conn->query($sql)) {
        return true;
    } else {
        return false;
    }
}


//USERS
function username_exist($username = "")
{
    global $conn;
    $sql = "SELECT username FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
function user_number_exist($user_number = "")
{
    global $conn;
    $sql = "SELECT user_number FROM users WHERE user_number='$user_number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function create_user($username = "", $user_number = "", $avatar = "")
{
    global $conn;
    $sql = "INSERT INTO users (username, user_number, avatar)"
        . "VALUES('$username', '$user_number', '$avatar')";
    return query_success($sql);
}
function get_user_id($username = "", $user_number = "")
{
    global $conn;
    $sql = "SELECT * FROM users WHERE username='$username' && user_number='$user_number'";
    return $conn->query($sql);
}
function get_user_id_by_user_number($user_number = "")
{
    global $conn;
    $sql = "SELECT * FROM users WHERE user_number='$user_number'";
    return $conn->query($sql);
}

function get_username_and_usernumber($id = '')
{
    global $conn;
    $sql = "SELECT username, user_number FROM users WHERE id=$id";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}


//bug helper
function print_arr($session = [])
{
    echo '<pre>';
    print_r($session);
    echo '</pre>';
}

//cut user_id.user_id
function cut_user_id($session, $user_id_final)
{
    return $session = str_replace($user_id_final, '', $session);
}

//scores
function has_coins($user_id)
{
    global $conn;
    $sql = "SELECT coins FROM coins WHERE id=$user_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_object()->coins;
    } else {
        return false;
    }
}

//progress

// i can return an array giving the score and also the mastery
function mastery($score, $num_items, $num_times_answer)
{
    $percentage = 0;
    if ($score > 0) {
        $percentage = ($score / $num_items / $num_times_answer) * 100;
        $percentage = round($percentage, 2);
    }
    return $percentage;
}

//uploading files

function check_file_error($file_array)
{
    if ($file_array === 0) {
        return false;
    } elseif ($file_array === 1) {
        return $msg = 'File larger than upload_max_filesize';
    } elseif ($file_array === 2) {
        return $msg = 'File larger than max_file_size';
    } elseif ($file_array === 3) {
        return $msg = 'File is partially uploaded';
    } elseif ($file_array === 4) {
        return $msg = 'No file Selected';
    } elseif ($file_array === 6) {
        return $msg = 'No Temporary Directory';
    } elseif ($file_array === 7) {
        return $msg = 'File can\'t write to disk';
    } elseif ($file_array === 8) {
        return $msg = 'File upload stopped by extension';
    }
}
