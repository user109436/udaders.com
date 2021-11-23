<?php

include('../../private/initialize.php');
$users = read_all('users');
$topics = read_all('topics');
$questions = read_all('questions');
$avatars = read_all('avatars');
$scores = read_all('scores');
$lessons = read_all('lessons');
?>


<!-- Grid column -->
<div class="col-xl-3 col-md-6 col-sm-3 col-xs-4 mb-4  ">
  <!-- Card -->
  <a href="users.php" style="text-decoration:none">
    <div class="card text-center hoverable">
      <h1 class="blue white-text p-4"><i class="far fa-user display-4"></i></h1>
      <h2><?php echo $users->num_rows ?> Users</h2>
    </div>
  </a>
  <!-- Card -->
</div>
<!-- Grid column -->
<!-- Grid column -->
<div class="col-xl-3 col-md-6 col-sm-3 col-xs-4 mb-4 ">
  <!-- Card -->
  <a href="topics.php" style="text-decoration:none">
    <div class="card text-center hoverable">
      <h1 class="orange white-text p-4 "><i class="fa fa-book display-4"></i></h1>
      <h2><?php echo $topics->num_rows ?> Topics</h2>
    </div>
  </a>
  <!-- Card -->
</div>
<!-- Grid column -->
<!-- Grid column -->
<div class="col-xl-3 col-md-6 col-sm-3 col-xs-4 mb-4 ">
  <!-- Card -->
  <a href="list_question.php" style="text-decoration:none">
    <div class="card text-center hoverable">
      <h1 class="purple white-text p-4"><i class="fa fa-question display-4"></i></h1>
      <h2><?php echo $questions->num_rows ?> Questions</h2>
    </div>
  </a>
  <!-- Card -->
</div>
<!-- Grid column -->
<!-- Grid column -->
<div class="col-xl-3 col-md-6 col-sm-3 col-xs-4 mb-4  ">
  <!-- Card -->
  <a href="avatar.php" style="text-decoration:none">
    <div class="card text-center hoverable">
      <h1 class="pink white-text p-4"><i class="fa fa-photo-video display-4"></i></h1>
      <h2><?php echo $avatars->num_rows ?> Avatars</h2>
    </div>
  </a>
  <!-- Card -->
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="col-xl-3 col-md-6 col-sm-3 col-xs-4 mb-4  ">
  <!-- Card -->
  <a href="scores.php" style="text-decoration:none">
    <div class="card text-center hoverable">
      <h1 class="pink white-text p-4"><i class="fa fa-users display-4"></i></h1>
      <h2><?php echo $scores->num_rows ?> Score Logs</h2>
    </div>
  </a>
  <!-- Card -->
</div>
<!-- Grid column -->
<!-- Grid column -->
<div class="col-xl-3 col-md-6 col-sm-3 col-xs-4 mb-4  ">
  <!-- Card -->
  <a href="scores.php" style="text-decoration:none">
    <div class="card text-center hoverable">
      <h1 class="green white-text p-4"><i class="fa fa-book-reader display-4"></i></h1>
      <h2><?php echo $lessons->num_rows ?> Lessons</h2>
    </div>
  </a>
  <!-- Card -->
</div>
<!-- Grid column -->