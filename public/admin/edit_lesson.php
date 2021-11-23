<?php
include('../../private/initialize.php');
session_start();
include('shared/header.php');

if (isset($_POST['s']) and $_POST['s'] == 1) {
    // note: i didn't escape editor because it has html5 characters
    //find a way to improve this because it may cause database corruption in the future specifically scripts that would destroy DB

    $lesson_title = $conn->real_escape_string($_POST['lesson_title']);
    $lesson_id = $conn->real_escape_string($_POST['lesson_id']);
    $editor = $_POST['editor'];
    $topic_id = $conn->real_escape_string($_POST['topic_id']);

    //triming and uppercasing
    $lesson_title = ucwords(trim($lesson_title));
    $editor = trim($editor);
    if (!empty($editor) and !empty($topic_id) and !empty($lesson_title) and !empty($lesson_id)) {
        $sql = "UPDATE lessons SET
                topic_id='$topic_id',
                lesson_title='$lesson_title',
                content='$editor'
                WHERE id=$lesson_id";
        // die($sql);
        if ($conn->query($sql)) {
            header('location:lessons.php?edit_lesson=success');
        } else {
            die('failed');
        }
    } else {
        echo '<div class="alert alert-danger">Please Fill up All Fields</div>';
    }
}
if (isset($_GET['lesson_id']) and !empty($_GET['lesson_id'])) {
    $lesson_id = $_GET['lesson_id'];
    $lesson = read('lessons', 'id', $lesson_id);
    $lesson = $lesson->fetch_object();
} else {
}
?>


<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <div class="container-fluid col-md-10">
            <div class="form-row mt-5">
                <label for="Title" class="font-weight-bold">Lesson Title</label>
                <input type="text" class="form-control mb-4" name="lesson_title" value="<?php echo $lesson->lesson_title ?>">
                <input type="hidden" name="lesson_id" value="<?php echo $lesson_id ?>">
            </div>
            <div class="form-row mt-1 mb-5">
                <label class="font-weight-bold" for="inputGroupSelect01">Topic</label>

                <select class=" browser-default custom-select" id="inputGroupSelect01" name="topic_id">
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
            <textarea name="editor" id="editor" cols="50" rows="50"><?php echo $lesson->content; ?></textarea>

            <input type="hidden" name="s" value="1">
            <button type="submit" name="submit" class="btn btn-info">Save Lesson</button>
        </div>

    </form>
</body>

<script>
    CKEDITOR.replace('editor', {
        extraPlugins: 'image',
        cloudServices_tokeUrl: 'None',
        cloudServices_tokenUrl: 'None'
    });
</script>

<?php ?>