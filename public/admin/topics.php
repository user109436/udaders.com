<?php
include('../../private/initialize.php');
include('shared/header.php');
session_start();

if (isset($_POST['s']) and $_POST['s'] == 1 and $_SERVER['REQUEST_METHOD'] == 'POST') {
    $topic = $conn->real_escape_string($_POST['topic']);
    if ($topic == "") {
        $activity = 'Topic Field is Empty';
    } else {
        $sql = "INSERT INTO topics(topic) VALUES('$topic')";
        if ($conn->query($sql) === TRUE) {
            $activity = 'Successfully Added';
        }
    }
}

?>
<p class="font-weight-bold text text-center mt-5" id="message"><?php echo isset($activity) ? $activity : 'Activity' ?></p>
<div class="container-fluid">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <div class="form-row">
            <input type="hidden" name='s' value="1">
            <label class="font-weight-bold">Add Topic</label>
            <input type="text" class="form-control mb-4" name="topic">
        </div>
        <button type="submit" class="btn btn-info  btn-sm">Add</button>
    </form>
    <div class="table-responsive">
        <table class="table table-striped" id="table">
            <thead class="blue white-text">
                <tr>
                    <th>ID</th>
                    <th>Topic</th>
                    <th>Questions</th>
                    <th>Lessons</th>
                    <th>Date Created</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody id="update">
                <?php $result = read_all('topics');
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        //get the id , id =topic_id for questions
                        //counts all rows with this topic_id
                ?>
                        <tr>
                            <th scope="row"><?php echo $row['id'] ?></th>
                            <td><?php echo $row['topic'] ?></td>
                            <td><?php
                                $result2 = read('questions', 'topic_id', $row['id']);

                                echo $result2->num_rows;
                                if ($result2->num_rows > 0) {
                                    echo '<span class="red-text btn-sm"> Existing Data<i class="fa fa-database ml-2"></i></span>';
                                } else {
                                    echo '<span class="green-text btn-sm"> Existing Data<i class="fa fa-database ml-2"></i></span>';
                                }

                                ?></td>
                            <td><?php
                                $lessons = read('lessons', 'topic_id', $row['id']);

                                echo $lessons->num_rows;
                                if ($lessons->num_rows > 0) {
                                    echo '<span class="red-text btn-sm"> Existing Data<i class="fa fa-database ml-2"></i></span>';
                                } else {
                                    echo '<span class="green-text btn-sm"> Existing Data<i class="fa fa-database ml-2"></i></span>';
                                }

                                ?></td>
                            <td><?php echo $row['date_created'] ?></td>
                            <td><a class="btn aqua-gradient btn-sm" href="edit_topic.php?id=<?php echo $row['id']; ?>">Edit</a><button onclick="del(<?php echo $row['id']; ?>, 'delete_t_id', 'Sure? It will cause data Corruption')" class="btn btn-danger btn-sm">Delete</button></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!--Add-->

</body>
<script>
    $('#table').DataTable();
</script>
<?php
include('shared/footer.php');
?>