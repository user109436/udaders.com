<?php
include('../private/initialize.php');
session_start();
if (isset($_POST['user_answer']) and isset($_POST['new_question_id'])) {

    $question_id = $conn->real_escape_string($_POST['new_question_id']);
    $user_answer = $conn->real_escape_string($_POST['user_answer']);
    $msg = answer_is_correct($user_answer, $question_id);
    $c_answer = get_answer($question_id);
    $explanation = read('questions', 'id', $question_id);
    $avatar = read('users', 'id', $_SESSION['user_id']);


    // echo '<div class="container-fluid d-flex justify-content-center">';

    // echo '</div>';
    //NOTE: d ko muna na isave at nasa debugging palang me, masyadong hassle pag inayos ko kaagad
    //list of questions, user_answer, and message if correct or wrong
    $_SESSION['questions' . $_SESSION['user_id']][] = $question_id;
    $_SESSION['user_answer_array' . $_SESSION['user_id']][] = $user_answer;
    $_SESSION['is_correct' . $_SESSION['user_id']][] = $msg;

?>

    <div class="row d-flex justify-content-center">
        <div class="col-md-3">
            <?php
            if ($msg) :
                echo '<p class="light-blue-text display-2 my-1 pr-3 text-center animated fadeIn delay-3s "><i class="far fa-smile-wink animated bounce infinite"></i><i class="fas fa-check animated fadeIn pl-3 my-1"></i></p>';
            else :
                echo '<p class="pink-text display-2 my-1 pr-3 text-center animated fadeIn delay-3s "><i class="far fa-sad-tear animated pulse infinite"></i><i class="fas fa-times animated fadeIn pl-3 my-1"></i></p>';
            endif;
            ?>
        </div>
        <div class="col-md-5 col-xs-12 col-10">
            <img class="card-img-top animated fadeIn slow " src="img/avatars/<?php echo $avatar->fetch_object()->avatar . '.png' ?>">
            <div class="card-body animated fadeIn slow delay-1s">
                <h5 class="card-title">Answer: <?php echo $c_answer ?></h5>
                <!-- <p><Strong>Your Answer: </Strong> <?php //echo $user_answer 
                                                        ?></p> -->
                <p><?php echo $explanation->fetch_object()->explanation ?></p>
            </div>
        </div>
    </div>


<?php

    $_SESSION['user_answer' . $_SESSION['user_id']] = $user_answer;

    //save the answer of user to records
}
?>