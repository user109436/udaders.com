<?php
include('../../private/initialize.php');
session_start();
include('shared/header.php');
?>


<div class="container-fluid">
    <a href="add_question.php" class="btn btn-info  btn-sm"><i class="fa fa-pencil-alt mr-2"></i>Create New Question</a>
    <div class="col-lg-12">
        <div class="table-responsive">
            <table id="table" cellspacing="0" width="100%" class="table table-striped">
                <p class="font-weight-bold text text-center">
                    <thead class="blue white-text">
                        <tr>
                            <th>ID</th>
                            <th>Topic</th>
                            <th>Level</th>
                            <th>Question</th>
                            <th>A</th>
                            <th>B</th>
                            <th>C</th>
                            <th>D</th>
                            <th>Answer</th>
                            <th>Explanation</th>
                            <th>Date Created</th>
                            <th>Modify</th>
                        </tr>
                    </thead>
                    <tbody id="update">
                        <p class="font-weight-bold text-center" id="message">
                            <?php
                            if (isset($_SESSION['message']) and !empty($_SESSION['message'])) {
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            } else {
                                echo 'Activity';
                            }
                            ?>


                        </p>
                        <?php

                        $result = read_all('questions');
                        // $sql="SELECT * FROM questions ORDER by id DESC Group by topic_id";
                        // $result=$conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {


                        ?>
                                <tr>

                                    <th scope="row"><?php echo $row['id'] ?></th>
                                    <?php
                                    $result2 = read('topics', 'id', $row['topic_id']);
                                    $row2 = $result2->fetch_assoc();
                                    ?>
                                    <td><?php



                                        if (empty($row2['topic'])) {
                                            echo '<p class="red-text text-center animated pulse infinite">Topic is Deleted<i class="fa fa-trash"></i></p>';
                                        } else {
                                            echo $row2['topic'];
                                        }

                                        ?></td>
                                    <td><?php echo $row['difficulty'] ?></td>
                                    <td><?php echo $row['question'] ?></td>
                                    <td><?php echo $row['c1'] ?></td>
                                    <td><?php echo $row['c2'] ?></td>
                                    <td><?php echo $row['c3'] ?></td>
                                    <td><?php echo $row['c4'] ?></td>
                                    <td><?php echo $row['answer'] ?></td>
                                    <td><?php echo empty($row['explanation']) ? 'Explanation Not Set' : $row['explanation'] ?></td>
                                    <td><?php echo $row['date_created'] ?></td>
                                    <td><a class="btn aqua-gradient btn-sm" href="edit_question.php?id=<?php echo $row['id']; ?>">Edit</a><button class="btn btn-danger btn-sm" onclick="del(<?php echo $row['id']; ?>, 'delete_q_id')" id="delete">Delete</button></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<!--Add-->

</body>
<script>
    $('#table').DataTable();
</script>
<?php include('shared/footer.php'); ?>