<?php
include('../../private/initialize.php');
include('shared/header.php');

if (isset($_GET['id']) and !empty($_GET['id'])) :
?>

    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <p class="font-weight-bold text text-center">
                    <thead class="blue white-text">
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>User Number</th>
                            <th>Avatar</th>
                            <th>Date Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $result = read('scores', 'user_id', $_GET['id']);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                        ?>
                                <tr>
                                    <th scope="row"><?php echo $row['id'] ?></th>
                                    <td><a href="users.php?id=<?php echo $row['id'] ?>"><?php echo $row['username'] ?></a></td>
                                    <td><?php echo $row['user_number'] ?></td>
                                    <td><?php echo empty($row['avatar']) ? 'Not Set' : $avatar ?></td>
                                    <td><?php echo $row['date_created'] ?></td>

                            <?php
                            }
                        } else {
                            echo "<p class='btn btn-default'>0 Records Found</p>";
                        }
                            ?>
                    </tbody>
            </table>
        </div>
    </div>
    </div>

<?php
else :

?>

    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <p class="font-weight-bold text text-center"><?php
                                                                if (isset($_SESSION['message'])) {
                                                                    echo $_SESSION['message'];
                                                                    unset($_SESSION['message']);
                                                                }

                                                                ?></p>
                <thead class="blue white-text">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>User Number</th>
                        <th>Avatar</th>
                        <th>Date Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $result = read_all('users');
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if (empty($row['avatar'])) {
                                $avatar = 'Not Set';
                                //    echo  date('Y-m-d-H-i-s');
                            } else {
                                $avatar = $row['avatar'];
                            }

                    ?>
                            <tr>
                                <p class="font-weight-bold" id="message"></p>
                                <th scope="row"><?php echo $row['id'] ?></th>

                                <td><a href="users.php?id=<?php echo $row['id'] ?>"><?php echo $row['username'] ?></a></td>
                                <td><?php echo $row['user_number'] ?></td>
                                <td><?php echo empty($row['avatar']) ? 'Not Set' : $avatar ?></td>
                                <td><?php echo $row['date_created'] ?></td>

                        <?php
                        }
                    } else {
                        echo "<p class='btn btn-default'>0 Records Found</p>";
                    }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
endif;
?>

<script>
    $('#table').DataTable();
</script>

<?php

include('shared/footer.php');
?>