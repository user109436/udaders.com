<?php
include('../../private/initialize.php');
include('shared/header.php');

if (isset($_GET['id']) and $_GET['id'] != "") {

    $id = $_GET['id'];
    $result = read("questions", "id", $id);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $topic_id = $row['topic_id'];
            $question = $row['question'];
            $difficulty = $row['difficulty'];
            $c1 = $row['c1'];
            $c2 = $row['c2'];
            $c3 = $row['c3'];
            $c4 = $row['c4'];
            $explanation = $row['explanation'];
            $answer = $row['answer'];
        }
        $affected_rows = $conn->affected_rows;
    }
    $result = read('topics', 'id', $topic_id);
    if ($result->num_rows > 0) {
        $topic = $result->fetch_object()->topic;
    }
} else {
    header('location:list_question.php');
}


if (isset($_POST['s']) and $_SERVER['REQUEST_METHOD'] == 'POST') {
    //     echo '<pre>';
    //   print_r($_POST);
    //   echo'</pre>';

    $id = $conn->real_escape_string($_POST['s']);
    $topic_id = $conn->real_escape_string($_POST['topic_id']);
    $question = $conn->real_escape_string($_POST['question']);
    $difficulty = $conn->real_escape_string($_POST['difficulty']);
    $c1 = $conn->real_escape_string($_POST['c1']);
    $c2 = $conn->real_escape_string($_POST['c2']);
    $c3 = $conn->real_escape_string($_POST['c3']);
    $c4 = $conn->real_escape_string($_POST['c4']);
    $explanation = $conn->real_escape_string($_POST['explanation']);
    $answer = $conn->real_escape_string($_POST['answer']);

    if ($answer == "A") {
        $answer = $c1;
    }
    if ($answer == "B") {
        $answer = $c2;
    }
    if ($answer == "C") {
        $answer = $c3;
    }
    if ($answer == "D") {
        $answer = $c4;
    }

    $difficulty = difficulty($difficulty);

    $errors = array($question, $difficulty, $c1, $c2, $c3, $c4, $answer);
    if (count_empty_fields($errors) == 0) {
        $result = update_question($id, $topic_id, $question, $difficulty, $c1, $c2, $c3, $c4, $answer, $explanation);
        // echo 'Result: '.$result;
        // die;
        session_start();
        $_SESSION['message'] = "Succesfully Updated";
    } else {
        $fields = $empty . " Empty Field(s)";
    }
}

?>


<!-- Material form register -->
<div class="card">



    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">

        <!-- Form -->
        <form class="text-center" style="color: #757575;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <input type="hidden" name='s' value="<?php echo $id; ?>">
            <!--Material textarea-->
            <div class="col-md-12 mt-3"><label for="form7" class="font-weight-bold ">Edit Question</label></div>
            <div class="md-form">
                <p><?php if (isset($fields)) {
                        echo $fields;
                    } else {
                        echo '';
                    } ?></p>
                <textarea id="editor" name="question" class="md-textarea form-control" rows="3" type="text"><?php echo $question; ?></textarea>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend ">
                    <label class="input-group-text btn-info white-text" for="inputGroupSelect01">Difficulty</label>
                </div>
                <select class="browser-default custom-select" id="inputGroupSelect01" name="difficulty" value="<?php echo $difficulty ?>">
                    <option value="1">Easy</option>
                    <option value="2">Medium</option>
                    <option value="3">Hard</option>
                </select>
                <div class="input-group-prepend ">
                    <label class="input-group-text btn-info white-text" for="inputGroupSelect01">Topic</label>
                </div>
                <select class="browser-default custom-select" id="inputGroupSelect01" name="topic_id">">
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
            <div class="form-row">
                <label class="font-weight-bold">A</label>
                <input type="text" class="form-control mb-4" name="c1" value="<?php echo $c1; ?>">
            </div>
            <div class="form-row">
                <label class="font-weight-bold">B</label>
                <input type="text" class="form-control mb-4" name="c2" value="<?php echo $c2; ?>">
            </div>
            <div class="form-row">
                <label class="font-weight-bold">C</label>
                <input type="text" class="form-control mb-4" name="c3" value="<?php echo $c3; ?>">
            </div>
            <div class="form-row">
                <label class="font-weight-bold">D</label>
                <input type="text" class="form-control mb-4" name="c4" value="<?php echo $c4; ?>">
            </div>
            <div class="form-row">
                <label class="font-weight-bold">Answer</label>
                <div class="container-fluid radio">
                    <label class="font-weight-bold radio-padding">A
                        <input type="radio" value="A" name="answer" checked>
                    </label>
                    <label class="font-weight-bold radio-padding">B
                        <input type="radio" value="B" name="answer">
                    </label>
                    <label class="font-weight-bold radio-padding">C
                        <input type="radio" value="C" name="answer">
                    </label>
                    <label class="font-weight-bold radio-padding">D
                        <input type="radio" value="D" name="answer">
                    </label>
                </div>
            </div>
            <div class="col-md-12 mt-3"><label for="form7" class="font-weight-bold ">Explanation</label></div>
            <div class="md-form">
                <textarea id="editor2" name="explanation" class="md-textarea form-control" rows="3" type="text"><?php echo $explanation ?></textarea>
            </div>
            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Save</button>
        </form>
        <!-- Form -->

    </div>

</div>
<script>
    CKEDITOR.replace('editor', {
        extraPlugins: 'image',
        cloudServices_tokeUrl: 'None',
        cloudServices_tokenUrl: 'None'
    });
    CKEDITOR.replace('editor2', {
        extraPlugins: 'image',
        cloudServices_tokeUrl: 'None',
        cloudServices_tokenUrl: 'None'
    });
</script>
<?php include('shared/footer.php'); ?>