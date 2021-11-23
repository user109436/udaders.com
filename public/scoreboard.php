<?php
include('../private/initialize.php');
include('shared/header.php');
session_start();
// print_arr($_SESSION);

if (!isset($_GET['get_result']) or empty($_GET['get_result']) and !isset($_SESSION['questions' . $_SESSION['user_id']])) {
    header('location:dashboard.php?scoreboard=false');
}
if (isset($_SESSION['questions' . $_SESSION['user_id']]) and isset($_SESSION['user_answer_array' . $_SESSION['user_id']]) and !empty($_SESSION['questions' . $_SESSION['user_id']]) and !empty($_SESSION['user_answer_array' . $_SESSION['user_id']]) and isset($_SESSION['is_correct' . $_SESSION['user_id']]) and !empty($_SESSION['is_correct' . $_SESSION['user_id']])) :
?>

    <body class="animated fadeInDownBig" style="background:url(img/res.svg) no-repeat center center fixed;background-size:cover;">



        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="blue-gradient white-text">
                    <tr>
                        <th>Question Answered by Order</th>
                        <th>Your Answer</th>
                        <th>Evaluation</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $total_items = $_SESSION['num_items' . $_SESSION['user_id']];
                    $score = 0;
                    for ($i = 0; $i <= $total_items - 1; $i++) {
                        $number = $i + 1;
                        if (isset($_SESSION['is_correct' . $_SESSION['user_id']][$i]) and $_SESSION['is_correct' . $_SESSION['user_id']][$i] == true) {
                            $score++;
                        }


                    ?>
                        <tr>
                            <th scope="row"><?php echo $number ?></th>
                            <td><?php echo isset($_SESSION['user_answer_array' . $_SESSION['user_id']][$i]) ? $_SESSION['user_answer_array' . $_SESSION['user_id']][$i] : 'Question Not Yet Answered'  ?> </td>
                            <td><?php
                                if (isset($_SESSION['is_correct' . $_SESSION['user_id']][$i]) and $_SESSION['is_correct' . $_SESSION['user_id']][$i] == true) {
                                    echo '<i class="fa fa-check btn btn-success btn-sm animated flipInY " style="animation-duration:1s; animation-delay:1s;"></i>';
                                } else {
                                    echo '<i class="fas fa-times btn btn-red btn-sm animated flipInY " style="animation-duration:1s; animation-delay:1s;"></i>';
                                }

                                ?>
                            </td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="brown white-text">
                    <tr>
                        <th>Score</th>
                        <th>Message</th>
                        <th>Reward</th>
                    </tr>
                </thead>
                <tbody>
                    <th scope="row">
                        <h5 class="animated pulse infinite blue-text" style="font-size:1.5rem; font-weight:bold"><?php echo $score . ' / ' . $total_items; ?></h5>
                    </th>
                    <td><span class=" btn btn-blue btn-sm  ">
                            <?php
                            $result = get_username_and_usernumber($_SESSION['user_id']);
                            echo $result['username'] . ', ';
                            $rating = ($score / $total_items) * 100;
                            $rating = round($rating, 2);
                            if ($score == $total_items) {
                                echo "it's Unbelievable, You are Amazing!";
                            } elseif ($rating >= 50 and $rating <= 75) {
                                echo 'You can still do more, Cheer Up!';
                            } elseif ($rating >= 75 and $rating <= 90) {
                                echo "You're doing Great!, Keep it Up!";
                            } elseif ($rating < 50 and $rating >= 0) {
                                echo "You're better than that, Study Well!";
                            } else {
                                echo 'Score can\'t be evaluated';
                            }


                            ?></span>
                    </td>
                    <td>
                        <p class="text-warning" style="font-size:2rem"><i class="fas fa-coins animated tada infinite"><?php echo $rating ?></i></p>
                    </td>
                    </tr>

                </tbody>
            </table>
        </div>


    </body>



    <?php
    // die();
    $user_id = $_SESSION['user_id'];
    $topic = $_SESSION['topic' . $_SESSION['user_id']];
    unset($_SESSION['topic' . $_SESSION['user_id']], $_SESSION['difficulty' . $_SESSION['user_id']], $_SESSION['questions' . $_SESSION['user_id']], $_SESSION['user_answer_array' . $_SESSION['user_id']], $_SESSION['is_correct' . $_SESSION['user_id']], $_SESSION['user_answer' . $_SESSION['user_id']], $_SESSION['num_items' . $_SESSION['user_id']]);
    $sql = "INSERT INTO scores (topic_id, score, num_items, user_id)VALUES('$topic','$score','$total_items','$user_id')";
    if ($conn->query($sql) === TRUE) :
        $score_save = true;
    endif;
    $coins = has_coins($user_id);
    if ($coins > 0) {
        //add the new reward to existing coins then update
        $rating += $coins;
        $sql = "UPDATE coins SET coins='$rating' WHERE user_id=$user_id";
    } else {
        //create a vacancy for this user reward
        $sql = "INSERT INTO coins(user_id, coins) VALUES('$user_id','$rating')";
    }
    if ($conn->query($sql) === TRUE) :
        $coins_save = true;
    endif;

    if ($score_save == true and $coins_save == true) {
    ?>

        <div class="col-lg-12 container d-flex justify-content-center">
            <a href="dashboard.php?score_recorded=true" class="btn btn-info animated pulse">Go to Dashboard, Data Saved<i class="far fa-save p-2"></i></a>
        </div>

    <?php
    } else {
        echo '<h1>Not saved</h1>';
    }
    ?>

<?php
//
else :

?>

    <body style="background:url(img/answer.svg) no-repeat center center fixed;background-size:cover;">;
        <div class="row d-flex justify-content-center">
            <img src="img/sad-tear-regular.svg" alt="" class="animated pulse infinite text-center">
        </div>
        <div class=" row d-flex justify-content-center">
            <p class=" btn btn-info btn-red">0 Results, Please answer atleast 1 question</p>
            <div class="container d-flex justify-content-center">

                <?php
                if (isset($_SESSION['topic' . $_SESSION['user_id']]) and isset($_SESSION['difficulty' . $_SESSION['user_id']]) and isset($_SESSION['user_id' . $_SESSION['user_id']])) :
                    //go back to questions
                ?>

                    <a href="question.php?<?php echo '&topic=' . $_SESSION['topic' . $_SESSION['user_id']] . '&difficulty=' . $_SESSION['difficulty' . $_SESSION['user_id']] . '&record_score=false' ?> " class="btn btn-success btn-rounded animated bounce infinite" ;>

                    <?php
                elseif (isset($_SESSION['user_id' . $_SESSION['user_id']]) and !empty($_SESSION['user_id' . $_SESSION['user_id']])) :

                    ?>
                        <a href="dashboard.php?record_score=false" class="btn btn-success btn-rounded">
                        <?php

                    endif;
                        ?>
                        <h1>&laquo</h1> Return
                        </a>
            </div>
        </div>
    <?php
endif;
    ?>
    </body>