<?php
include('../private/initialize.php');
include('shared/header.php');

session_start();
// print_arr($_SESSION);


if (!isset($_SESSION['user_id' . $_SESSION['user_id']])) {
  header('location: index.php?login=false');
}

//if the questions are upcoming
if (isset($_SESSION['return']) and $_SESSION['return'] == false or isset($_SESSION['topic' . $_SESSION['user_id']]) and isset($_SESSION['difficulty' . $_SESSION['user_id']])  and !empty($_SESSION['difficulty' . $_SESSION['user_id']]) and $_SESSION['topic' . $_SESSION['user_id']] > 0) {
  header('location:question.php?topic=' . $_SESSION['topic' . $_SESSION['user_id']] . '&difficulty=' . $_SESSION['difficulty' . $_SESSION['user_id']]) . '&dashboard=false';
} else if (isset($_SESSION['return']) and $_SESSION['return'] == true) {
  unset($_SESSION['return']);
}

if (isset($_GET['logout']) and $_GET['logout'] == true) {
  unset($_SESSION['user_id' . $_SESSION['user_id']], $_SESSION['user_id']);
  header('location: index.php?logout=true');
  exit;
}

if (isset($_POST['s']) and $_POST['s'] == 1 and $_SERVER['REQUEST_METHOD'] == 'POST') {
  $topic = $_SESSION['topic' . $_SESSION['user_id']] = $conn->real_escape_string($_POST['topic_id']);
  $difficulty = $conn->real_escape_string($_POST['difficulty']);
  $difficulty = $_SESSION['difficulty' . $_SESSION['user_id']] = difficulty($difficulty);
  $errors = [];
  $error = 0;
  if (empty($topic)) {
    array_push($errors, 'Please Select Topic');
    $error++;
  }
  if (empty($difficulty)) {
    array_push($errors, 'Please Select Difficulty');
    $error++;
  }

  if (count($errors) == 0) {
    header('location:question.php?topic=' . $topic . '&difficulty=' . $difficulty . '&request_quiz=success');
  }
}

include('shared/nav.php');
?>
<main class="page-content">
  <div class="container-fluid">
    <h2 href="#" class=" font-weight-bold  btn btn-yellow btn-sm ">
      <i class="fa fa-coins "></i>
      <span>Coins <?php echo $coins->fetch_object()->coins ?></span>
    </h2>
    <hr>
    <div class="row">
      <div class="form-group col-md-12">
        <div class="row d-flex justify-content-center">
          <p id="message" class="btn btn-danger btn-sm text-center">
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
            echo $throw_error === "" ? "Initialize Successful" : $throw_error;

            ?>
          </p>
        </div>
        <form class="text-center" style="color: #757575;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
          <input type="hidden" name='s' value="1">
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
          <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Start Quiz</button>
        </form>
      </div>
      <div class="form-group col-md-12">
      </div>
    </div>
    <h5>My Progress</h5>
    <hr>
    <?php
    $result = read_all('topics');
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $topics[] = $row['topic'];
        $topic_id[] = $row['id'];
      }
      $num_topics = count($topics);
      $num_topic_id = count($topic_id);
      $user_id = $_SESSION['user_id'];
      $num_times_answer = [];
      $num_items = [];
      $scores = [];
      $over_all_score = 0;
      for ($i = 0; $i <= $num_topic_id - 1; $i++) {
        //count all the records then save it as Number of times answered

        $sql = "SELECT * FROM scores WHERE topic_id=$topic_id[$i] and user_id=$user_id";
        $result = $conn->query($sql);
        $num_times_answer[] = $result->num_rows;
        $score = 0;
        while ($row = $result->fetch_assoc()) {
          $score += $row['score'];
        }
        $scores[] = $score;
        $over_all_score += $scores[$i];
        //get num of items
        $sql = "SELECT topic_id FROM questions WHERE topic_id=$topic_id[$i]";
        $result = $conn->query($sql);
        $num_items[] = $result->num_rows;
      }
    ?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="blue-gradient white-text">
            <tr>
              <th>Topic</th>
              <th>Number of Times Answered</th>
              <th>Total Score</th>
              <th>Items</th>
              <th>Mastery</th>
            </tr>
          </thead>
          <tbody>

            <?php

            if ($over_all_score > 0) {


              for ($i = 0; $i <= $num_topic_id - 1; $i++) {
                if ($num_times_answer[$i] != 0 and $num_items[$i] != 0) :

            ?>

                  <tr>
                    <th scope="row"><?php echo $topics[$i] ?></th>
                    <td><?php echo  $num_times_answer[$i] ?></td>
                    <td><?php echo  $scores[$i] ?></td>
                    <td><?php echo  $num_items[$i] ?></td>
                    <td class="red-text" style="font-size:1rem; font-weight:bold"><?php echo mastery($scores[$i], $num_items[$i], $num_times_answer[$i]); ?></td>
                  </tr>

            <?php
                endif;
              }
            } else {
              echo '<p class="text-center blue-text display-4">0%</p>';
            }
            ?>
          </tbody>
        </table>

      </div>
  </div>
<?php
    } else {
      echo 'No Topics So Far';
    }

?>

</main>
<!-- page-content" -->
</div>
<?php include('shared/footer.php');  ?>