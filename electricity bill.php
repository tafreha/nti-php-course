<?php
$bill=50;
if($bill<=50){
    $bill=$bill*3.50;
}
elseif($bill<=150) {
$bill=$bill*4;

}
else{
    $bill=$bill*6.50;
}
echo "electricitty bill= ".$bill;

?>