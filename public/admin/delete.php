<?php
include('../../private/initialize.php');


//question
if (isset($_POST['delete_q_id'])) {
    $id = $_POST['delete_q_id'];
    delete_question($id);
}
//topic    
if (isset($_POST['delete_t_id'])) {
    $id = $_POST['delete_t_id'];
    $conn->query("DELETE FROM topics WHERE id=$id");
}

if (isset($_POST['delete_l_id'])) {
    $id = $_POST['delete_l_id'];
    $conn->query("DELETE FROM lessons WHERE id=$id");
}
