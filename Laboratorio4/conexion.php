<?php 
$con=mysqli_connect("localhost","root","","bd_agenda");
if(mysqli_connect_errno()){
    die("Se produjo un error ".mysqli_connect_error());
}
?>