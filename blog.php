<!-- <?php
session_start();
// if(isset($_SESSION['content'])){
//     echo $_SESSION['content'];
//     }
//     else{
//         echo 'No  content';
//     }
  
//echo $_SESSION['content'];

?> -->
<?php

//session_start();
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

if (!empty($_FILES['image']['name'])) {

    $fileName    = $_FILES['image']['name'];
    $fileTemName = $_FILES['image']['tmp_name'];
    $fileType    = $_FILES['image']['type'];
    $fileSize    = $_FILES['image']['size'];

    # Allowed Extensions 
    $allowedExtensions = ['jpg','png'];

    $fileArray = explode('/', $fileType);

    # file Extension ...... 
    $fileExtension = end($fileArray);


    if (in_array( $fileExtension, $allowedExtensions)) {

        # IMage New Name ...... 
        $FinalName = time() . rand() . '.' .  $fileExtension;

        $disPath = 'uploads/' . $FinalName;


        if (move_uploaded_file($fileTemName, $disPath)) {
            echo 'image Uploaded Succ.... <br> ';
        } else {
            $errors['image']  =  'Error try Again....<br>';
        }
    } else {
        $errors['image']  =  'InValid Extension  image must be .png or jpg ....<br> ';
    }
} else {
    $errors['image']  =  'image is Required....  <br>';
}

# Check Errors ...... 
if(count($errors) > 0 ){
    foreach ($errors as $key => $value) {
        # code...
        echo '* '.$key.' : '.$value.'<br>';
    }
}else{
    $data= ["title" => $title,"content" => $content, "image" => $_FILES];
//$_SESSION['content'] = ["title" => $title,"content" => $content, "image" => $_FILES];
$file = fopen('employee.txt','a') or die("unable to open file ");
 
   $text = implode(" ",$data);    // \t 
     fwrite($file,$text);

 fclose($file);
 $file = fopen('employee.txt','r') or die("unable to open file ");

   echo  fread($file,filesize('employee.txt'));
  while(!feof($file)){ 
 echo  fgets($file).'<br>';
 echo  fgetc($file).'<br>';  
 }
 fclose($file);
}
}

?>
<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
title: <input type="text" name="title" require>
  <br><br>
  content: <input type="textarea" name="content" require>
  <br><br>
  image: <input type="file" name="image" require>
<br><br>
  <input type="submit" name="submit" value="Submit">

</form>
