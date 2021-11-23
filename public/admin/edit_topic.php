<?php
include('../../private/initialize.php');
include ('shared/header.php');

if(isset($_GET['id'])){
    $id=$_GET['id'];
    $result=read('topics', 'id', $id);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            $topic=$row['topic'];
        }
    }
}else if(!isset($_GET['id']))
{header('location:topics.php');}
if(isset($_POST['s']) and $_SERVER['REQUEST_METHOD']=='POST'){
    $topic=$conn->real_escape_string($_POST['topic']);
    $update_id=$conn->real_escape_string($_POST['s']);
    if($topic==""){
        echo "Topic Field is Empty";
    }else{
        $sql="UPDATE topics SET topic='$topic' WHERE id=$update_id";
        if($conn->query($sql)===TRUE){
            session_start();
            $_SESSION['message']="Succesfully Updated";
            header('location:topics.php');
        }

    }
}
?>
<div class="card">

<h5 class="card-header info-color white-text text-center py-4">
    <strong>Edit Topic</strong>
</h5>

<!--Card content-->
<div class="card-body px-lg-5 pt-0">

    <!-- Form -->
    <form class="text-center" style="color: #757575;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" >
    <input type="hidden" name='s' value="<?php echo $id;?>">
    <!--Material textarea-->
        <div class="form-row">
            <label class="font-weight-bold" >Topic</label>
        <input type="text" class="form-control mb-4" name="topic" value="<?php echo $topic;?>">
        </div>
        </div>
        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Save</button>
    </form>
    <!-- Form -->

</div>

</div>

<?php
include ('shared/footer.php');
?>