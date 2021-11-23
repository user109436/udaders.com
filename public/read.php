<?php
include('../private/initialize.php');
session_start();
include('shared/header.php');
include('shared/nav.php');

?>

<!-- <body style="background:url(img/library.svg) no-repeat fixed;background-size:cover;" ;class="mask rgba-white-slight waves-effect waves-light "> -->

<main class="page-content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center ">
            <h2 class="text-center btn btn-info p-2 m-0 "><i class="fa fa-book-reader mr-2"></i><?php echo $name ?>'s Library</h2>
        </div>
        <!-- CONTAINER -->
        <div class="row">

            <?php

            if (isset($_GET['lesson']) and !empty((int) $_GET['lesson'])) {
                $lesson_id = $_GET['lesson'];
                $lesson = read('lessons', 'id', $lesson_id);
                if ($lesson->num_rows > 0) {
                    $lesson = $lesson->fetch_object();


            ?>
                    <!-- READDDDDDDING -->
                    <div class="col-md-8 m-0 p-0">
                        <div class="col-md-12 col-12 white-text blue p-3 mt-5 mb-5  ">
                            <h4>Lesson Title: <?php echo $lesson->lesson_title ?></h4>
                            <p>Topic: <?php
                                        $topic_id = $lesson->topic_id;
                                        $topic = read('topics', 'id', $topic_id);
                                        if ($topic->num_rows <= 0) {
                                            echo '<p class="red-text text-center animated pulse infinite">Topic is Deleted<i class="fa fa-trash"></i></p>';
                                        } else {
                                            echo  $topic_title = $topic->fetch_object()->topic;
                                        }

                                        ?></p>
                        </div>
                        <a href="read.php" class="btn btn-info btn-sm">Return</a>
                        <hr>

                        <!-- KAMOTENG WRAPPER need to improve this  -->
                        <div class="row">
                            <div class="container-fluid m-0 p-0">
                                <?php


                                echo $lesson->content;
                                ?>
                            </div>
                        </div>
                        <!-- KAMOTENG WRAPPER need to improve this  -->
                    </div>
                    <!-- READDDDDDDING -->
                    <!-- NAVIGATION -->
                    <div class="col-md-4 col-12 mt-5 m-0">
                        <div class="table-responsive  ">
                            <table class="table table-striped" width="100%" cellspacing="0">
                                <thead class="green white-text">
                                    <tr>
                                        <th>Related Lessons in <?php echo $topic_title ?></th>
                                    </tr>
                                </thead>
                                <tbody id="update">
                                    <?php
                                    $lessons = read('lessons', 'topic_id', $topic_id);
                                    if ($lessons->num_rows > 0) {
                                        while ($row = $lessons->fetch_assoc()) {
                                    ?>

                                            <tr>
                                                <td>
                                                    <?php
                                                    if ($lesson_id == $row['id']) {
                                                        //current
                                                    ?>
                                                        <a href="read.php?lesson=<?php echo $row["id"] ?>">
                                                            <i class="fa fa-book-open green-text mr-2"></i><?php echo $row["lesson_title"] ?>
                                                        </a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="read.php?lesson=<?php echo $row["id"] ?>"><?php echo $row["lesson_title"] ?></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                    <?php

                                        }
                                    } else {
                                        echo '0 Results';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- NAVIGATION -->
                <?php

                } else {
                    echo '<div class="alert  alert-danger text-center">0 Materials for this Lesson</div>';
                }
            } else {
                //for post
                ?>

                <body style="background:url(img/library2.svg) no-repeat fixed;background-size:cover" ;>
                    <div class="table-responsive  ">
                        <table class="table table-striped" id="table" width="100%" cellspacing="0">
                            <thead class="blue white-text">
                                <tr>
                                    <th>Topic</th>
                                    <th>Lesson Title</th>
                                </tr>
                            </thead>
                            <tbody id="update" class="rgba-black-strong white-text">
                                <?php
                                $lessons = read_all('lessons');
                                if ($lessons->num_rows > 0) {
                                    while ($row = $lessons->fetch_assoc()) {
                                        $topic_id = $row['topic_id'];
                                ?>

                                        <tr>
                                            <td><?php
                                                $topic = read('topics', 'id', $topic_id);
                                                if ($topic->num_rows <= 0) {
                                                    echo '<p class="red-text text-center animated pulse infinite">Topic is Deleted<i class="fa fa-trash"></i></p>';
                                                } else {
                                                    echo  $topic_title = $topic->fetch_object()->topic;
                                                }
                                                ?></td>
                                            <td><a href="read.php?lesson=<?php echo $row['id'] ?>" class="white-text"><i class="fa fa-book mr-2"></i><?php echo $row['lesson_title'] ?></a></td>
                                        </tr>

                            <?php

                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
        </div>
    </div>

</main>
</body>
<script>
    $('#table').DataTable();
</script>
<?php
include('shared/footer.php');
?>