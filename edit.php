<?php
require 'dbConnection.php';

# Fetch Id Data ...... 
$id = $_GET['id'];

$sql = "select * from data where id = $id"; 
$op  = mysqli_query($con,$sql); 
# Fetch Data 
$data = mysqli_fetch_assoc($op);

function Clean($input){
    
   $input = trim($input);
   $input = strip_tags($input);
   $input = stripslashes($input);

   return $input;
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {

$title = Clean($_POST['title']);
$content = Clean($_POST['content']);
# Errors Array ... 
$errors = []; 

if(empty($title)){
   $errors['title']  = "Required Field"; 
}elseif(strlen($title) < 10){
   $errors['title']  = "Length Must Be >= 10 Chars"; 
}
if(empty($content)){
   $errors['content']  = "Required Field"; 
}elseif(strlen($content) < 50){
   $errors['content']  = "Length Must Be >= 50 Chars"; 
}
 
// If upload button is clicked ...

if (isset($_POST['submit'])) {

    $fileName    = $_FILES['image']['name'];
    $fileTemName = $_FILES['image']['tmp_name'];
    $fileType    = $_FILES['image']['type'];
    $fileSize    = $_FILES['image']['size'];
    # Allowed Extensions 
    $allowedExtensions = ['jpg','jpeg','png'];

    $fileArray = explode('/', $fileType);

    # file Extension ...... 
    $fileExtension = end($fileArray);

    if (in_array( $fileExtension, $allowedExtensions)) {

        # IMage New Name ...... 
        $FinalName = time() . rand() . '.' .  $fileExtension;

        $disPath = 'images/' . $FinalName;
        if (move_uploaded_file($fileTemName, $disPath)) {
            $sql="update data SET image='$FinalName' where id = $id ";
            $op  = mysqli_query($con,$sql); 
        # Fetch Data 
            $data = mysqli_fetch_assoc($op);
            $con->exec($sql);

                        echo 'image Uploaded Succ.... <br> ';
                    } else {
                        $errors['image']  =  'Error try Again....<br>';
                    }
                } else {
                    $errors['image']  =  'InValid Extension  image must be .png or jpg ....<br> ';
                }
             }else {
                       echo $data['image'] ;
            
            }
# Check Errors ...... 
if(count($errors) > 0 ){
   foreach ($errors as $key => $value) {
       # code...
       echo '* '.$key.' : '.$value.'<br>';
   }
    } else {

        // code ...... 
        
        $sql = "update data set title = '$title' , content = '$content', image= '$FinalName' where id = $id";
         $op =  mysqli_query($con,$sql);

       if($op){
           $message =  'Raw Updated';

        # SET SESSION ..... 
        $_SESSION['Message'] = $message;

        //header("Location: index.php");

       }else{
           echo 'Error Try Again '.mysqli_error($con);
       }


       mysqli_close($con);

    }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
    <div class="alert alert-danger">

        <h2>Update Account</h2>


</form>

        <form action="edit.php?id=<?php echo $data['id'];?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">title</label>
                <input type="text" class="form-control" required id="exampleInputtitle" name="title" value="<?php echo $data['title']?>">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">content</label>
                <input type="text" class="form-control" required id="exampleInputcontent"  name="content"  value="<?php echo $data['content']?>">
            </div>
            <div class="form-group">
          <div class="form-group"> <img src="./images/<?php echo $data['image'];?>" widht="80" height="80"></div>
          <div class="form-group">
            <label>upload new image </label>  <input type="file" name="image" >
            
</div>
</div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>


</body>

</html>