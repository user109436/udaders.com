<?php
include('../../private/initialize.php');
include ('shared/header.php');



?>
<div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <p class="font-weight-bold text text-center"><?php 
                if (isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    }
                  
                    ?></p>
                <thead class="blue white-text">
                    <tr>
                        <th >ID</th>
                        <th >Username</th>
                        <th >User Number</th>
                        <th  >Topic</th>
                        <th >Score</th>
                        <th  >Number of Items</th>
                        <th  >Date Recorded</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $result=read_all('scores');
                        if ($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                $user_id=$row['user_id'];
                       
                    ?>
                    <tr><p class="font-weight-bold" id="message"></p>
                        <th scope="row"><?php echo $row['id']?></th>
                        <!-- =============THIS WENT WRONG============== -->
                        <?php 
                                $result2=get_username_and_usernumber($user_id);
                                // print_arr($result2);
                                   
                            ?>
                            
                        <td><?php echo $result2['username']?></td>
                        <td><?php echo $result2['user_number']?></td>
                        <!-- ============================ -->
                        <td><?php
                            $topic=read('topics', 'id', $row['topic_id']);
                            echo $topic->fetch_object()->topic;
                            ?></td>
                        <td><?php echo $row['score']?></td>
                        <td><?php echo $row['num_items']?></td>
                        <td><?php echo $row['date_created']?></td>
                    
                    <?php
                             }
                            }else{
                                echo "<p class='btn btn-default'>0 Records Found</p>";
                            }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
        <script>
    $('#table').DataTable();
  </script>
        <?php
include ('shared/footer.php');
?>