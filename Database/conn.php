<?php
$conn= mysqli_connect("localhost","root","","Sports");
if(mysqli_connect_errno()){
     echo "ERROR". mysqli_connect_error();
}