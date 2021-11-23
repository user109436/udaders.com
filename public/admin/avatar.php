<?php
include('../../private/initialize.php');
include('shared/header.php');

if (isset($_POST['s']) and $_POST['s']==1){
    $errors=[];
    print_arr($_FILES);
    if (!empty($_FILES)):
        if(preg_match("!image!", $_FILES['avatar']['type'])):
            array_push($errors, "Please Upload Image Only");
        endif;
        if($_FILES['avatar']['size']<=5000000):
            array_push($errors, "File Size must be Below 15mb");
        endif;
        if(check_file_error($_FILES['avatar']['error'])===false):
            $file_ext=explode('.',$_FILES['avatar']['name']);
            $file_actual_ext=end($file_ext);
            $filename=$_FILES['avatar']['name']=uniqid('',true).'.'.$file_actual_ext;
             $avatar_path=$conn->real_escape_string('../img/avatars/'.$filename);
             $file_temp_loc=$_FILES['avatar']['tmp_name'];
            
            
            if (empty($errrors)){
                    $move=move_uploaded_file($file_temp_loc, $avatar_path);
                    $sql="INSERT INTO avatars (filename, file_path)VALUES('$filename','$avatar_path') ";
                    if($conn->query($sql)===TRUE){
                            $_SESSION['message']="Avatar Succesfully Saved";
                            header('location:avatar.php?upload=success');
                    }
            }
endif;
endif;
    // print_r($_POST['avatar']);
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">  
        <input type="hidden" value="1" name="s">
        <input type="file" name="avatar" accept="image/*" name="avatar" id="file_input" class="btn btn-info" >
        <button type="submit" btn btn-info> Submit</button>
    </form>

    <div class="row">
    <?php 
if($result=$conn->query("SELECT * FROM avatars")){
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
?>



<div class="col-md-4">
    <div class="card mb-2">
      <img class="card-img-top "
        src="<?php echo $row['file_path'];
?>"
        alt="Card image cap">
      <div class="card-body">
      </div>
    </div>
  </div>


<?php
        }
    }
}
?>
</div>
<script type="text/javascript">

// $('.file-upload').file_upload();
</script>

