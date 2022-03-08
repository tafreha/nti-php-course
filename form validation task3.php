
<?php
$nameErr = $emailErr = $passworderr = $urlerr =$addresserr= "";
$name = $email = $password = $url = $address = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (empty ($_POST["name"]) or !preg_match ("/^[a-zA-z]*$/", $name)) {  
    $nameErr = "Error! You didn't enter the Name.  or  Only alphabets and whitespace are allowed.";  
        } 
        else {
       
       $name  = $_POST['name'];
       
      }

$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
  if (empty($_POST["email"])|| !preg_match ($pattern, $email) ) {
    $emailErr = "Email is required";
  } else {
    $email = $_REQUEST['email'];
  }

  if (empty($_POST["password"])  || strlen($password)<6) {
    $passworderr = "password is required ";
  } else {
    $password = $_REQUEST["password"];
  }

  if (empty($_POST["address"])|| strlen($address)<10) {
    $addresserr = "address is required or less than 10 character";
  } else {
    $address = $_POST["address"];
  }
  
  if (empty($_POST["url"]) || !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) {
    $urlerr = "url is required";
  } else {
    $url = $_POST["url"];
  }
}

?>

<html>
<body>
    <style>
.error {color: #FF0000;}
</style>
<form action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post">
Name: <input type="text" name="name" require><span class="error">* <?php echo $nameErr;?></span>
  <br><br>
E-mail: <input type="email" name="email" require><span class="error">* <?php echo $emailErr;?></span>
  <br><br>
password: <input type="password" name="password" require> <span class="error">* <?php echo $passworderr;?></span>
  <br><br>
address: <input type="text" name="address" require><span class="error">* <?php echo $addresserr;?></span>
  <br><br>
linked url: <input type="url" name="url" require><span class="error">* <?php echo $urlerr;?></span>
  <br><br>
<input type="submit">
</form>
<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $password;
echo "<br>";
echo $address;
echo "<br>";
echo $url;
echo "<br>";
?>
</body>
</html>