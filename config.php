<?php

$mysqli =   new mysqli ("localhost","root","","registration");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}else{
    // echo "connection succesfull";
}

