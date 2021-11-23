<?php
include('../../private/initialize.php');



// ===========================QUESTIONS===================
if (isset($_GET['delete_q_id']) and !empty($_GET['delete_q_id'])) {
    //===========for debugging=====
    // $sql="SELECT * FROM questions order by id ASC";
    // $result=$conn->query($sql);
    //===========for debugging=====
    $result = read_all('questions');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {


?>
            <tr>
                <p class="font-weight-bold" id="message"></p>
                <th scope="row"><?php echo $row['id'] ?></th>
                <?php
                $result2 = read('topics', 'id', $row['topic_id']);
                $row2 = $result2->fetch_assoc();
                ?>
                <td><?php echo $row2['topic'] ?></td>
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
}
// ===========================QUESTIONS===================


// ===========================TOPICS===================

if (isset($_GET['delete_t_id']) and !empty($_GET['delete_t_id'])) {
    //===========for debugging=====
    // $sql="SELECT * FROM topics order by id ASC";
    // $result=$conn->query($sql);
    //===========for debugging=====

    $result = read_all('topics');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

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
                <td><?php echo $row['date_created'] ?></td>
                <td><a class="btn aqua-gradient btn-sm" href="edit_topic.php?id=<?php echo $row['id']; ?>">Edit</a><button onclick="del(<?php echo $row['id']; ?>, 'delete_t_id', 'Sure? It will cause data Corruption')" class="btn btn-danger btn-sm">Delete</button></td>
            </tr>
        <?php

        }
    }
}
// ===========================LESSONS===================
if (isset($_POST['delete_l_id']) and !empty($_POST['delete_l_id'])) {
    $lessons =   $read_all('lessons');
    if ($lessons->num_rows > 0) {
        while ($row = $lessons->fetch_assoc()) {


        ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['lesson_title'] ?></td>
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
                    <a href="edit_lesson.php?lesson_id=<?php echo $row['id'] ?>" class="btn aqua-gradient btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="del(<?php echo $row['id'] ?>, 'delete_l_id')">Delete</button>
                </td>
            </tr>

<?php
        }
    }
}
// ===========================TOPICS===================
?>