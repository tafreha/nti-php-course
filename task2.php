<?php
function nextchar($char){
    $characters=["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","a"];
$index=array_search($char, $characters);
    # code...
if($index <sizeof($characters))
   {
   echo $characters[++$index];
     }
// elseif($char="z")
// {
//     echo  $characters[0];
// }
// elseif($index==sizeof($characters))
// {
//     echo  $characters[0];
// }
// else{
//     echo "not character";
// }
 
   
}
nextchar("v");
?>