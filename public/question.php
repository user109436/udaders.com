<?php
include('../private/initialize.php');
include('../private/pagination.php');
include('shared/header.php');
session_start();

// session_destroy();

/* NOTE additional Task
need to save the users answers to scores
then calculate to the records
if already inserted then create an array of session and save the pagenumber in there 
if pagenumber already exist in the session array disable all buttons for that specific question
if user generates new questions (topic and difficulty) session array of page number equals to empty
re-assign the values of topic and difficulty session
*/
// print_arr($_SESSION);
if (isset($_SESSION['topic' . $_SESSION['user_id']]) and isset($_SESSION['difficulty' . $_SESSION['user_id']]) and isset($_SESSION['user_id' . $_SESSION['user_id']])) {
  $topic = $conn->real_escape_string($_SESSION['topic' . $_SESSION['user_id']]);
  $difficulty = $conn->real_escape_string($_SESSION['difficulty' . $_SESSION['user_id']]);
} else {
  header('location:index.php?generate_question=false');
}


$page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
$per_page = 1;
$total_count = count_question($topic, $difficulty);
$pagination = new Pagination($page, $per_page, $total_count);
$questions = generate_question($topic, $difficulty, $per_page, $pagination->offset());


if ($questions) {

  $_SESSION['num_items' . $_SESSION['user_id']] = $total_count;

  echo '<body class="container "style="background:url(img/question.svg) no-repeat  top center fixed;background-size:cover ">';
  include('shared/nav.php');
  echo '<main class="page-content">';
?>


  <div class="modal-container">
    <div class="modal-content">
      <span class="close-btn">&times;</span>


      <div id="answer" class=" container text-center">

      </div>
      <?php

      echo '<div class="container d-flex justify-content-center">';
      if ($pagination->total_pages() > 0) {
        if ($pagination->has_next_page()) :
          echo '<a href="question.php?page=' . $pagination->next_page() . '"><button class="btn btn-primary">Next</button></a>';

        else :
          echo '<a href="scoreboard.php?get_result=true"><button class="btn btn-primary">Submit My Score</button></a>';
        endif;
        echo '</div>';
      }
      ?>
    </div>
  </div>
  <div class="container-fluid">
    <!--Card-->
    <div class="card t-5 animated rotateInDownLeft" style="width:inherit; margin-top: 5rem;">


      <!--Card content-->
      <div class="card-body">
        <p id='initial-answer'><?php echo 'Intial Answer: ' ?></p>

        <div class="container-fluid">


          <?php


          while ($row = $questions->fetch_assoc()) {
            //first check if $_SESSION['questions'] is set
            if (isset($_SESSION['questions' . $_SESSION['user_id']]) and !empty($_SESSION['questions' . $_SESSION['user_id']])) :
              $question_exist = false;
              for ($i = 0; $i <= count($_SESSION['questions' . $_SESSION['user_id']]) - 1; $i++) {
                if ($row['id'] == (int) $_SESSION['questions' . $_SESSION['user_id']][$i]) :
                  $question_exist = true;
                  break;
                endif;
              } else :
              $question_exist = false;
            endif;

            //disable button if exist
            if ($question_exist) :
          ?>
              <h4 class="text-center "><?php echo $row['question']; ?></h4>
              <div class="row d-flex justify-content-center ">
                <input type="hidden" id="question_id" value="<?php echo $row['id'] ?>" name="question_id">
                <button class="btn btn-yellow btn-lg col-lg-5 col-md-3" disabled="true" value="<?php echo $row['c1'] ?>"><?php echo $row['c1'] ?></button>
                <button class="btn btn-yellow btn-lg col-lg-5 col-md-3" disabled="true" value="<?php echo $row['c2'] ?>"><?php echo $row['c2'] ?></button>
                <button class="btn btn-yellow btn-lg col-lg-5 col-md-3" disabled="true" value="<?php echo $row['c3'] ?>"><?php echo $row['c3'] ?></button>
                <button class="btn btn-yellow btn-lg col-lg-5 col-md-3" disabled="true" value="<?php echo $row['c4'] ?>"><?php echo $row['c4'] ?></button>

              <?php
            else :
              //display the default
              ?>
                <h4 class="text-center "><?php echo $row['question']; ?></h4>
                <div class="row d-flex justify-content-center ">
                  <input type="hidden" id="question_id" value="<?php echo $row['id'] ?>" name="question_id">
                  <button class="btn btn-info btn-lg col-lg-5 col-md-3 choice" id="1" value="<?php echo $row['c1'] ?>"><?php echo $row['c1'] ?></button>
                  <button class="btn btn-info btn-lg col-lg-5 col-md-3 choice" id="2" value="<?php echo $row['c2'] ?>"><?php echo $row['c2'] ?></button>
                  <button class="btn btn-info btn-lg col-lg-5 col-md-3 choice" id="3" value="<?php echo $row['c3'] ?>"><?php echo $row['c3'] ?></button>
                  <button class="btn btn-info btn-lg col-lg-5 col-md-3 choice" id="4" value="<?php echo $row['c4'] ?>"><?php echo $row['c4'] ?></button>
              <?php
            endif;
          }
              ?>
                </div>
                <div class="container" style="clear: both;">
                  <?php
                  if ($pagination->total_pages() > 0) {

                    if ($pagination->has_previous_page()) {
                      echo "<a class='btn btn-orange btn-sm' href=\"question.php?page=";
                      echo $pagination->previous_page();
                      echo "\">&laquo; Previous</a> ";
                    }

                    for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                      if ($i == $page) {
                        echo " <span class=\"btn btn-purple btn-md\">{$i}</span> ";
                      } else {
                        echo " <a href=\"question.php?page={$i}\">{$i}</a> ";
                      }
                    }

                    if ($pagination->has_next_page()) {
                      echo " <a class='btn btn-red btn-sm' href=\"question.php?page=";
                      echo $pagination->next_page();
                      echo "\">Next &raquo;</a> ";
                    } else {
                      echo '<a href="scoreboard.php?get_result=true"><button class="btn btn-success btn-sm">Submit My Score</button></a>';
                    }
                  }
                  ?>
                </div>
              </div>
        </div>

      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 success">
            <p class="my-4">Records</p>
            <?php


            if (isset($_SESSION['questions' . $_SESSION['user_id']]) and isset($_SESSION['user_answer_array' . $_SESSION['user_id']]) and !empty($_SESSION['questions' . $_SESSION['user_id']]) and !empty($_SESSION['user_answer_array' . $_SESSION['user_id']])) {
              for ($i = 0; $i <= count($_SESSION['questions' . $_SESSION['user_id']]) - 1; $i++) {
                $number = $i + 1;
                echo '<p>' . $number . ': ' . $_SESSION['user_answer_array' . $_SESSION['user_id']][$i] . ', ' . $_SESSION['is_correct' . $_SESSION['user_id']][$i] . '</p>';
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    </main>
    </body>
  <?php
} else {
  $_SESSION['return'] = true;
  unset($_SESSION['topic' . $_SESSION['user_id']], $_SESSION['difficulty' . $_SESSION['user_id']]);
  echo ' <body style="background:url(img/upcoming.svg) no-repeat center center fixed;background-size:cover" ;class="mask rgba-white-slight waves-effect waves-light">';
  include('shared/nav.php');
  echo '<main class="page-content">';
  ?>


    <div class="row d-flex justify-content-center">
      <img src="img/sad-tear-regular.svg" alt="" class="animated pulse infinite text-center">
    </div>
    <div class=" row d-flex justify-content-center">
      <p class=" btn btn-info btn-red">The questions for this topic is Upcoming,Sorry for the inconvenience</p>
      <div class="container d-flex justify-content-center">
        <a href="dashboard.php" class="btn btn-success btn-rounded animated bounce infinite">
          <h1>&laquo</h1> Return
        </a>
      </div>
    </div>

  <?php
}
  ?>
  <!-- closing for nav -->
  </main>
  </div>
  <!-- closing for nav -->
  </body>
  <?php include('shared/footer.php');  ?>
  <script type="text/javascript">
    $(document).ready(function() {
      //choices and answers
      var answer = document.getElementById('initial-answer');
      var question_id = document.getElementById('question_id');

      console.log('success');
      $(".choice").on('click', function() {
        answer.innerHTML = 'Your Answer: ' + this.value;
        //Improvement disable the specific button after clicking 

        console.log(question_id.value)
        $("#answer").load('answer.php', {
          user_answer: this.value,
          new_question_id: question_id.value

        });
        $('.modal-container').slideDown();
        $('.modal-container').css('display', 'block');
        //   this.disabled=true;
        $('.choice').attr("disabled", true);
      });


      $('.close-btn').on('click', function() {
        $('.modal-container').slideUp();
        //   setTimeout(location.reload.bind(location), 500)
      });
      $('.modal-container').on('click', function() {
        $('.modal-container').slideUp();
      });

      //Desktops and Laptops animation choices
      $(".choice").on('mouseover', function() {
        answer.innerHTML = 'Your Initial Answer: ' + this.value;
        let id = this.id;
        $('#' + id).addClass('animated pulse');
      });
      $(".choice").on('mouseleave', function() {
        let id = this.id;
        $('#' + id).removeClass('animated pulse');
      });


      //mobile devices animation choices
      $(".choice").on('touchstart', function() {
        answer.innerHTML = 'Your Initial Answer: ' + this.value;
        let id = this.id;
        $('#' + id).addClass('animated pulse');
      });
      $(".choice").on('touchend', function() {
        let id = this.id;
        $('#' + id).removeClass('animated pulse');
      });

    });
  </script>