<?php
 function Clean($input){
     
    $input = trim($input);
    $input = strip_tags($input);
    $input = stripslashes($input);

    return $input;
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {

 $name     = Clean($_POST['name']);
 $email    = Clean($_POST['email']);
 $password = Clean($_POST['password']);
 $address = Clean($_POST['address']);
 $website = Clean($_POST['website']);
 # Errors Array ... 
 $errors = []; 
 
 # Validate Name ..... 
 if(empty($name)){
     $errors['name'] = "Required Field ";
 } 
//  elseif(!preg_match ("/^[a-zA-z]*$/", $name)){
//     $errors['name']  = "Invalid Format, must be string "; 
//  }

 # Validate Email ... 
 if(empty($email)){
     $errors['Email']  = "Required Field"; 
 }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
     $errors['Email']  = "Invalid Format"; 
 }

 # Validate Password .... 
 if(empty($password)){
     $errors['Password']  = "Required Field"; 
 }elseif(strlen($password) < 6){
     $errors['Password']  = "Length Must Be >= 6 Chars"; 
 }
 if(empty($address)){
    $errors['Password']  = "Required Field"; 
}elseif(strlen($address) < 10){
    $errors['address']  = "Length Must Be >= 10 Chars"; 
}


if(!isset($_POST["gender"])){
    $errors['gender']  = "Required Field"; 
    }
    else{
        $gender = $_POST["gender"];
        if ($gender == "Male"){
            $Mchecked = "checked";
        }
        else if ($gender == "Female"){
            $Fchecked = "checked";
        }
    }
#check url
if(empty($website)){
    $errors['website']  = "Required Field"; 
}elseif(!filter_var($website,FILTER_VALIDATE_URL)){
    $errors['website']  = "Invalid Format"; 
}

if (!empty($_FILES['cv']['name'])) {

    $fileName    = $_FILES['cv']['name'];
    $fileTemName = $_FILES['cv']['tmp_name'];
    $fileType    = $_FILES['cv']['type'];
    $fileSize    = $_FILES['cv']['size'];

    # Allowed Extensions 
    $allowedExtensions = ['pdf'];

    $fileArray = explode('/', $fileType);

    # file Extension ...... 
    $fileExtension = end($fileArray);


    if (in_array( $fileExtension, $allowedExtensions)) {

        # IMage New Name ...... 
        $FinalName = time() . rand() . '.' .  $fileExtension;

        $disPath = 'uploads/' . $FinalName;


        if (move_uploaded_file($fileTemName, $disPath)) {
            echo 'cv Uploaded Succ.... <br> ';
        } else {
            $errors['cv']  =  'Error try Again....<br>';
        }
    } else {
        $errors['cv']  =  'InValid Extension  cv must be .pdf....<br> ';
    }
} else {
    $errors['cv']  =  'cv is Required....  <br>';
}

# Check Errors ...... 
if(count($errors) > 0 ){
    foreach ($errors as $key => $value) {
        # code...
        echo '* '.$key.' : '.$value.'<br>';
    }
}else{
    echo 'Name : '.$name.'<br>'.' Email : '.$email.'<br>'.'address : '.$address.'<br>'.' gender : '.$gender.'<br>'.'website : '.$website.'<br>'.' Email : '.$email;
}
}



?>
<html>
    <body>

<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

Name: <input type="text" name="name">

<br><br>
E-mail:
<input type="text" name="email">

<br><br>
Website: <input type="text" name="website">

<br><br>
password: <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">

<br><br>
address: <input type="text" name="address" require>
  <br><br>
Gender:
<input type="radio" name="gender" value="female">Female
<input type="radio" name="gender" value="male" >Male
<br><br>
cv: <input type="file" name="cv" require>
<input type="submit" name="submit" value="Submit">

</form>
</body>
</html>