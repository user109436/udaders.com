<?php
include('../private/initialize.php');
?>
<!-- DOCTYPE html> -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Udaders.com</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/mdb.min.css">
    <link type="text/css" rel="stylesheet" href="./css/all.css">
    <script type="text/javascript" src="./js/jquery.js"></script>
</head>


<?php

session_start();
ob_start();
// print_arr($_SESSION);
//if user is already log in prevent them from coming to index
if (isset($_SESSION['user_id'])) {

    if (isset($_SESSION['user_id' . $_SESSION['user_id']])) {
        if (isset($_SESSION['topic' . $_SESSION['user_id']]) and isset($_SESSION['difficulty' . $_SESSION['user_id']])) {
            $topic = $_SESSION['topic' . $_SESSION['user_id']];
            $difficulty = $_SESSION['difficulty' . $_SESSION['user_id']];
            header('location:question.php?topic=' . $topic . '&difficulty=' . $difficulty);
        }
        header('location:dashboard.php?user_in=true');
    }
}


//kailangan kong i track kung anong index na nila
if (isset($_POST['s']) and $_POST['s'] == 1 and $_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $conn->real_escape_string($_POST['username']);
    $user_number = $conn->real_escape_string($_POST['user_number']);
    $avatar = $conn->real_escape_string($_POST['avatar']);
    //redundant sa part na to find a way para d sya maging DRY
    $topic = $conn->real_escape_string($_POST['topic_id']);
    $difficulty = $conn->real_escape_string($_POST['difficulty']);

    $errors = [];
    $error = 0;
    //if user_number exist proceed to generate question and then log in
    if ((user_number_exist($user_number) == true) and (username_exist($username)) == true) {
        //need to check the topic and difficulty for more secure accesss
        $result_id = get_user_id_by_user_number($user_number);
        if ($result_id->num_rows > 0) {
            $_SESSION['user_id'] = $result_id->fetch_object()->id;
            $_SESSION['user_id' . $_SESSION['user_id']] = $_SESSION['user_id'];
            //user_id.user_id is added on topic and difficulty
            $topic = $_SESSION['topic' . $_SESSION['user_id']] = $conn->real_escape_string($_POST['topic_id']);
            $difficulty = $conn->real_escape_string($_POST['difficulty']);
            $difficulty = $_SESSION['difficulty' . $_SESSION['user_id']] = difficulty($difficulty);
            //redirect to the questions 
            header('location:question.php?topic=' . $topic . '&difficulty=' . $difficulty);
            exit;
        }
    }
    if ((user_number_exist($user_number)) == true) {
        array_push($errors, 'User Number Already Taken');
        $error++;
    }
    if (empty($username)) {
        array_push($errors, 'Username Empty');
        $error++;
    }
    if (empty($user_number)) {
        array_push($errors, 'Usernumber Empty');
        $error++;
    }
    if (empty($avatar)) {
        array_push($errors, 'Choose your Avatar');
        $error++;
    }
    if (empty($topic)) {
        array_push($errors, 'Please Select Topic');
        $error++;
    }
    if (empty($difficulty)) {
        array_push($errors, 'Please Select Difficulty');
        $error++;
    }

    if (count($errors) == 0) {

        // If user not Exist Create a New User
        if (create_user($username, $user_number, $avatar)) {
            $result_id = get_user_id_by_user_number($user_number);
            if ($result_id->num_rows > 0) {
                $_SESSION['user_id'] = $result_id->fetch_object()->id;
                $_SESSION['user_id' . $_SESSION['user_id']] = $_SESSION['user_id'];
                //user_id.user_id is added on topic and difficulty
                $topic = $_SESSION['topic' . $_SESSION['user_id']] = $conn->real_escape_string($_POST['topic_id']);
                $difficulty = $conn->real_escape_string($_POST['difficulty']);
                $difficulty = $_SESSION['difficulty' . $_SESSION['user_id']] = difficulty($difficulty);
            }
        } else {
            echo "Create User Failed";
            die();
        }

        header('location:question.php?topic=' . $topic . '&difficulty=' . $difficulty);
        ob_get_clean();
    }
}
?>


<body style="background:url(img/bg-index9.svg) no-repeat fixed;background-size:cover ; " class="mask rgba-white-slight waves-effect waves-light">
    <div class="container-fluid ">
        <!-- <div class="col-lg-12"> -->
        <audio src="./amazing_grace.mp3" type="audio/mp3" autoplay loop></audio>
        <div class="container col-lg-10 col-md-12 col-sm-12">
            <div class="col-md-12 d-flex justify-content-center">
            </div>
            <div class="row d-flex justify-content-center">
                <p id="message" class="btn btn-danger" style="text-align:center">
                    <?php


                    $throw_error = "";
                    if (isset($errors)) {
                        if (count($errors) > 0) {

                            foreach ($errors as $error) {
                                if ($throw_error === "") {
                                    $throw_error = $error;
                                } else {
                                    $throw_error .= ", $error";
                                }
                            }
                        }
                    }

                    echo $throw_error === "" ? "Choose your Avatar" : $throw_error;


                    ?>
                </p>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <!-- view overlay hm-white-light z-depth-1-half -->
                    <!-- <img src="img/bg-index2.jpg" alt="" class="img-fluid img-responsive"> -->
                    <?php include('carousel.php') ?>
                </div>
            </div>

        </div>
        <div class="row col-12 d-flex justify-content-center">
            <form class="col-sm-10 col-xs-10 col-lg-5 text-center" id="form" style="color: #757575;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <input type="hidden" name='s' value="1">
                <input type="hidden" name='avatar' value='' id='avatar'>
                <div class="form-row">
                    <div class="col-sm-6">
                        <label class="font-weight-bold white-text">Username</label>
                        <input type="text" class="form-control mb-1" name='username'>
                    </div>
                    <div class="col-sm-6">
                        <label class="font-weight-bold white-text">Student Number</label>
                        <input type="number" class="form-control mb-4" id="user_number1" name='user_number'>
                    </div>
                </div>
                <div class="input-group mb-3">

                    <div class="input-group-prepend">
                        <label class="input-group-text btn-info" for="inputGroupSelect01">Difficulty</label>
                    </div>
                    <select class="browser-default custom-select" id="inputGroupSelect01" name="difficulty">
                        <option value="1">Easy</option>
                        <option value="2">Medium</option>
                        <option value="3">Hard</option>
                    </select>
                    <div class="input-group-prepend ">
                        <label class="input-group-text btn-info" for="inputGroupSelect02">Topic</label>
                    </div>
                    <select class="browser-default custom-select" id="inputGroupSelect02" name="topic_id">
                        <?php $result = read_all('topics');
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                        ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['topic'] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <button class="btn btn-outline-white btn-rounded btn-block" type="submit">GET STARTED</button>
            </form>
        </div>
        <!-- </div> -->
    </div>

    </div>
    <!-- End your project here-->

    <!-- jQuery -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <!-- Your custom scripts (optional) -->
    <script type="text/javascript">
        $(document).ready(function() {
            let img = $('.card-img-top');
            var message = document.getElementById('message');
            let avatar = document.getElementById('avatar');
            //Dekstop
            $('.card-img-top').on('click', function() {
                //count the class animated
                let animated = $('.animated').length;

                if (animated > 0) {
                    $('.animated').removeClass('animated pulse infinite');
                }
                $('#' + this.id).addClass('animated pulse infinite');
                message.innerHTML = this.id;
                avatar.value = this.id;

            });

            // $('#user_number').on('keypress', console.log('keypress'));
            //Mobile
            // $('.card-img-top').on('touchstart', function(){
            //     $('#'+this.id).addClass('peach-gradient');

            // });
            // $('.card-img-top').on('touchend', function(){
            //     $('#'+this.id).removeClass('peach-gradient');

            // });
        });
    </script>

</body>
<?php include('shared/footer.php');  ?>