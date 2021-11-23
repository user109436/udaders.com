<?php
include('../../private/initialize.php');
session_start();
include('shared/header.php');


if (isset($_GET['view_lesson']) and !empty($_GET['view_lesson'])) {
    $lesson_id = $_GET['view_lesson'];
    $lesson = read('lessons', 'id', $lesson_id);
    $lesson = $lesson->fetch_object();
?>
    <div class="container-fluid">
        <div class="container col-md-12">

            <div class="col-md-12 col-12 white-text blue p-3 mt-5 mb-5">
                <h4>Lesson Title: <?php echo $lesson->lesson_title ?></h4>
                <p>Topic: <?php
                            $topic_id = $lesson->topic_id;
                            $topic = read('topics', 'id', $topic_id);
                            if ($topic->num_rows <= 0) {
                                echo '<p class="red-text text-center animated pulse infinite">Topic is Deleted<i class="fa fa-trash"></i></p>';
                            } else {
                                echo  $topic_data = $topic->fetch_object()->topic;
                            }

                            ?></p>
            </div>
            <hr>
            <?php


            echo $lesson->content;
            ?>
        </div>
    </div>
<?php


} else {
    if (isset($_POST['s']) and $_POST['s'] == 1) {
        // note: i didn't escape editor because it has html5 characters
        //find a way to improve this because it may cause database corruption in the future specifically scripts that would destroy DB
        $editor = $_POST['editor'];
        $topic_id = $conn->real_escape_string($_POST['topic_id']);

        if (!empty($editor) and !empty($topic_id)) {
            $sql = "INSERT INTO lessons (topic_id, content)VALUES('$topic_id', '$editor')";
            if ($result = $conn->query($sql)) {
                header('locatioin:lessons.php');
            }
        }
    }

?>

    <body>

        <div class="container-fluid mt-5">
            <a href="add_lesson.php" class="btn btn-info  btn-sm"><i class="fa fa-pencil-alt mr-2"></i>Create New Lesson</a>
            <div class="table-responsive">
                <p class="font-weight-bold text-center" id="message">Activity</p>
                <table class="table table-striped" id="table" width="100%" cellspacing="0">
                    <thead class="blue white-text">
                        <tr>
                            <th>ID</th>
                            <th>Lesson Title</th>
                            <th>Topic</th>
                            <th>Date Created</th>
                            <th>Manipulate</th>
                        </tr>
                    </thead>
                    <?php
                    $content = read_all('lessons');
                    if ($content->num_rows > 0) {
                        while ($row = $content->fetch_assoc()) {
                            $topic_id = $row['topic_id'];

                    ?>
                            <tbody id="update">
                                <tr>
                                    <td><?php echo $row['id'] ?></td>
                                    <td><a href="lessons.php?view_lesson=<?php echo $row['id'] ?>"><?php echo $row['lesson_title'] ?></a></td>
                                    <td><?php
                                        $topic = read('topics', 'id', $topic_id);
                                        if ($topic->num_rows <= 0) {
                                            echo '<p class="red-text text-center animated pulse infinite">Topic is Deleted<i class="fa fa-trash"></i></p>';
                                        } else {
                                            echo  $topic_data = $topic->fetch_object()->topic;
                                        }
                                        ?></td>
                                    <td><?php echo $row['date_created'] ?></td>
                                    <td>
                                        <a href="edit_lesson.php?lesson_id=<?php echo $row['id'] ?>" class="blue-text p-2"><i class="fa fa-edit"></i></a>
                                        <a class="red-text p-2" onclick="del(<?php echo $row['id'] ?>, 'delete_l_id')"><i class="fa fa-trash"></i></a>
                                    </td>
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
    </body>
    <script>
        $('#table').DataTable();
    </script>
    <?php include('shared/footer.php'); ?>